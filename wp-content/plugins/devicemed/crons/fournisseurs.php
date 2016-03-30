<?php
	$all=in_array('all',$_SERVER['argv'])!==false;
	$vider=$all || in_array('vider',$_SERVER['argv'])!==false;
	$fournisseurs=$all || in_array('insert',$_SERVER['argv'])!==false;
	$galleries=$all || in_array('galleries',$_SERVER['argv'])!==false;
	$videos=$all || in_array('videos',$_SERVER['argv'])!==false;
	$categories=$all || in_array('categories',$_SERVER['argv'])!==false;

	require_once("../../../../wp-load.php");


	if($categories) {
		if($vider) {
			mysql_query('delete from legacy_categories');
			$res = mysql_query('SELECT * FROM wordpress_term_taxonomy WHERE taxonomy = "categorie"');
			$cpt=0;
			while($terme = mysql_fetch_array($res)) {
				$cpt++;
				mysql_query('delete from wordpress_terms where term_id = '.$terme['term_id']);
				mysql_query('delete from wordpress_term_taxonomy where term_taxonomy_id = '.$terme['term_id']);
				mysql_query('delete from wordpress_term_relashionships where term_taxonomy_id = '.$terme['term_id']);
			}
			mysql_query('delete from wordpress_term_taxonomy where taxonomy = "categorie"');
			e($cpt.' catégories effacées');
		}

		$sqlCategorie = "SELECT * FROM wordpress_dm_suppliers_categories";
		$resultCategorie = mysql_query($sqlCategorie);
		$nbCategorie = mysql_num_rows($resultCategorie);
		$arrayCategorie = array();

		while($rowCategorie = mysql_fetch_array($resultCategorie)) {
			$arrayCategorie[] = $rowCategorie;
		}
		foreach($arrayCategorie as $categorie) {
			if($categorie['supplier_souscategorie_parent']) {
				$categorie_parent = nouvelIdCategorie($categorie['supplier_souscategorie_parent'],true);
				$categorie_parent_ancien=$categorie['supplier_souscategorie_parent'];
			} else	if($categorie['supplier_category_parent']) {
				$categorie_parent = nouvelIdCategorie($categorie['supplier_category_parent'],false);
				$categorie_parent_ancien=$categorie['supplier_category_parent'];
			} else {
				$categorie_parent=0;
				$categorie_parent_ancien=0;
			}
			if($idCategorie = creerCategorie($categorie['supplier_category_title'],$categorie['ID'],false,$categorie_parent,$categorie_parent_ancien)) {
				$sqlSousCat = "SELECT * FROM wordpress_dm_suppliers_souscategories WHERE supplier_category_parent=".$categorie['ID'];
				$resultSousCat = mysql_query($sqlSousCat);
				while($rowSousCat = mysql_fetch_array($resultSousCat)) {
					if($idSousCat = creerCategorie($rowSousCat['supplier_souscategorie_name'],$rowSousCat['ID'],true,$idCategorie,$categorie['ID'])) {

					}
				}
			}
		}	
	}

	if($fournisseurs) {
		e('Fournisseurs');
		if($vider) {
			$args = array(
				'numberposts' => 5000,
				'post_status'=>array('draft','publish'),
				'post_type' =>'fournisseur'
			);
			$posts = get_posts( $args );
			if (is_array($posts)) {
				e('effacer '.count($posts).' fournisseurs');
			   foreach ($posts as $post) {
			       wp_delete_post( $post->ID, true);
			   }
			}
		}

		$res = mysql_query('SELECT * FROM wordpress_dm_suppliers');

		while($fournisseur = mysql_fetch_assoc($res)) {
			// if($fournisseur['ID']!=199) continue;
			$post = array(
				'post_type'=>'fournisseur',
				'post_date'=>$fournisseur['supplier_created'],
				'post_modified'=>$fournisseur['supplier_modified'],
				'post_content'=>trim($fournisseur['supplier_about']),
				'post_title'=>$fournisseur['supplier_name'],
				'post_status'=> $fournisseur['supplier_valide'] ? 'publish' : 'draft',
				'meta_input'=>array(
					'adresse'=>$fournisseur['supplier_address'],
					'code_postal'=>$fournisseur['supplier_postalcode'],
					'ville'=>$fournisseur['supplier_city'],
					'pays'=>$fournisseur['supplier_country'],
					'telephone'=>$fournisseur['supplier_telephone'],
					'url'=>http($fournisseur['supplier_website']),
					'blog'=>http($fournisseur['supplier_social_blog']),
					'facebook'=>http($fournisseur['supplier_social_facebook']),
					'twitter'=>http($fournisseur['supplier_social_twitter']),
					'youtube'=>http($fournisseur['supplier_social_youtube']),
					'googleplus'=>http($fournisseur['supplier_social_google_plus']),
					'linkedin'=>http($fournisseur['supplier_social_linkedin']),
					'premium'=>$fournisseur['supplier_premium'],
					'nom_contact'=>$fournisseur['supplier_contact_nom'],
					'email_contact'=>$fournisseur['supplier_contact_mail'],
					'telephone_contact'=>$fournisseur['supplier_contact_tel'],
					'optin'=>$fournisseur['supplier_souhait_contact'],
					'legacy_supplier_id'=>$fournisseur['ID'],
					'videos'=>'',
					'gallerie'=>'',
					)
			);

			e($fournisseur['supplier_name']);


			$post_id = wp_insert_post($post);


			foreach($post['meta_input'] as $k=>$v) {
				update_field($k,$v,$post_id);
			}


			$cats = explode(',',$fournisseur['supplier_category_id']);
			$$cats_nouveau=array();
			foreach($cats as $cat) {
				if($cat = nouvelIdCategorie($cat)) {
					$cats_nouveau[] = $cat;
				}
			}
			wp_set_post_terms( $post_id, $cats_nouveau, 'categorie' );

			if($fournisseur['supplier_logo']) {
				$path = ABSPATH.'wp-content/uploads/logo_suppliers/'.$fournisseur['supplier_logo'];
				Generate_Featured_Image($path,$post_id);
			}

		}
	}
	if($galleries) {
		$res = mysql_query('SELECT * FROM wordpress_dm_suppliers_galleries where supplier_gallery_status = 1 ORDER BY supplier_id ASC');
		while($gallerie = mysql_fetch_assoc($res)) {
			if($fournisseur = get_fournisseur($gallerie['supplier_id'],true)) {
				$new_photos = array();
				$new_videos = array();
				$res_media = mysql_query('SELECT * FROM wordpress_dm_suppliers_medias where supplier_id = '.$gallerie['supplier_id'].' AND supplier_media_related_id = '.$gallerie['ID']);
				while($media = mysql_fetch_assoc($res_media)) {
					$supplier_media_metas = unserialize($media['supplier_media_metas']);
					if($supplier_media_metas['filename']) {
						$photo_base = 'suppliers/galleries/'.$gallerie['ID'].'/'.$supplier_media_metas['filename'];
						$photo = wp_upload_dir()['basedir'].'/'.$photo_base;
						$photo_url = wp_upload_dir()['baseurl'].'/'.$photo_base;
						if($attach_id = get_attachment_id_by_url($photo_url)) {
							$new_photos[] = $attach_id;
						} else {
							if(file_exists($photo)) {
								$filetype = wp_check_filetype( basename( $photo ), null );
								$wp_upload_dir = wp_upload_dir();
								$attachment = array(
									'guid'           => $photo_url, 
									'post_mime_type' => $filetype['type'],
									'post_title'     => $fournisseur['post_title'].' - '.preg_replace( '/\.[^.]+$/', '', basename( $photo ) ),
									'post_excerpt'   => $media['supplier_media_legende'],
									'post_status'    => 'inherit'
								);
								$attach_id = wp_insert_attachment_meta( $attachment, $photo );
								$new_photos[] = $attach_id;
							} else {
								// e('gallerie '.$fournisseur['ID'].' / '.$fournisseur['post_title'].': manque '.$photo);
							}
						}
					}
				}
				if(count($new_photos)) {
					// e($fournisseur);
					$fournisseur['gallerie'] = array_unique(array_merge($fournisseur['gallerie'],$new_photos));
					foreach($fournisseur['gallerie'] as $k=>$id) {
						if(get_post_status($id)===false) {
							$fournisseur['gallerie'][$k]=0;
						}
					}
					$fournisseur['gallerie'] = array_filter($fournisseur['gallerie']);
					update_field('gallerie', $fournisseur['gallerie'], $fournisseur['ID'] );
					e('gallerie '.$fournisseur['ID'].' / '.$fournisseur['post_title'].': ajout de '.count($new_photos).' image(s)');
					// mse($fournisseur['ID'],$fournisseur['post_title'],$fournisseur['gallerie']);
				}
			}
		}
	}
	if($videos) {
		$new_videos=array();
		$res = mysql_query('SELECT * FROM wordpress_dm_suppliers_videos where supplier_video_status = 1 ORDER BY supplier_id ASC');
		while($video = mysql_fetch_assoc($res)) {
			if($fournisseur = get_fournisseur($video['supplier_id'],true)) {
				$res_data = mysql_query('SELECT * FROM wordpress_dm_suppliers_medias where supplier_media_related_type = "Video" AND supplier_media_related_id = '.$video['ID']);
				if($video_data = mysql_fetch_assoc($res_data)) {
					$supplier_media_metas = unserialize($video_data['supplier_media_metas']);
					// ms($video_data);
					if($supplier_media_metas['filetype'] == 'stream')  {
						$titre = $video['supplier_video_title'];
						$video_url = 'http://www.youtube.com/watch?v='.$supplier_media_metas['id'];

						$new_videos[$fournisseur['ID']][] = array(
							'titre_de_la_video' => $titre,
							'url_de_la_video' => $video_url,
						);
					}

				}
			}
		}
		if(count($new_videos)) {
			foreach($new_videos as $supplier_id=>$tmp_videos) {
				if($fournisseur = get_fournisseur($supplier_id)) {

					$fournisseur['videos'] = array_unique_multi(array_merge($tmp_videos,$fournisseur['videos']));
					foreach($fournisseur['videos'] as $cpt=>$video) {
						foreach($video as $k=>$v) {
							update_post_meta($fournisseur['ID'],'videos_'.$cpt.'_'.$k, $v);
						}
					}
					update_post_meta($fournisseur['ID'],'videos', count($fournisseur['videos']) );
					e('vidéos '.$fournisseur['ID'].' / '.$fournisseur['post_title'].': ajout de '.count($tmp_videos).' videos(s)');
				}

			}
		}

	}

