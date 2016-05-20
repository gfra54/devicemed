<?php

function telecharger_fournisseurs() {
	$categories = fournisseur_categories();
	$fournisseurs = get_fournisseurs(array('enrichir'=>true,'cache'=>'extraction_excel'));
	$data = array();
	foreach($categories as $categorie) {
		$ligne_categorie = array('Fournisseur','Pays','Web',mb_strtoupper($categorie['name']));
		foreach($categorie['categories'] as $sous_categorie) {
			if($sous_categorie['categories']) {
				foreach($sous_categorie['categories'] as $sous_sous_categorie) {
				$ligne_categorie[$sous_sous_categorie['term_id']] = $sous_categorie['name'].PHP_EOL.$sous_sous_categorie['name'];
				}
			} else {
				$ligne_categorie[$sous_categorie['term_id']] = $sous_categorie['name'];
			}
		}
		$data[]=array();
		$data[]=$ligne_categorie;
		foreach($fournisseurs as $fournisseur) {
			$ligne_fournisseur = array();
			$ligne_fournisseur[] = $fournisseur['post_title'];
			$ligne_fournisseur[] = $fournisseur['pays'];
			$ligne_fournisseur[] = $fournisseur['url'];
			$debut = count($ligne_fournisseur);
			$cpt=0;
			foreach($ligne_categorie as $idcat=>$cat) {
				$debut--;
				if($debut<0) {
					$trouve=false;
					foreach($fournisseur['categories'] as $categorie) {
						foreach($categorie['categories'] as $sous_categorie) {
							if($sous_categorie['id'] == $idcat) {
								$trouve=true;
							}
						}
					}
					if($trouve) {
						$ligne_fournisseur[]='X';
						$cpt++;
					} else {
						$ligne_fournisseur[]='';
					}
				}
			}
			if($cpt) {
				$data[]=$ligne_fournisseur;
			}
		}
		
	}
	foreach($data as $k=>$v) {
		foreach($v as $i=>$j) {
			$v[$i] = '"'.str_replace('"','\\"',str_replace("\n",' ',trim($j))).'"';
		}
		$data[$k] = $v;
	}
	$out='';
	foreach($data as $ligne) {
		$out.=implode(';',$ligne).PHP_EOL;
	}

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Length: " . strlen($out));
	header("Content-type: text/x-csv");
	header("Content-Disposition: attachment; filename=extraction-fournisseurs-".date('Y-m-d-h-i-s').'.csv');
	echo utf8_decode(trim($out));
	exit;	
}
function new_fournisseur($fournisseur,$categories=array()) {
	$date = date('Y-m-d H:i:s');
	$post = array(
		'post_type'=>'fournisseur',
		'post_date'=>$date,
		'post_modified'=>$date,
		'post_content'=>sinon($fournisseur,'content'),
		'post_title'=>sinon($fournisseur,'name','nom_societe'),
		'post_status'=> sinon($fournisseur,'valide') ? 'publish' : 'draft',
		'meta_input'=>array(
			'adresse'=>sinon($fournisseur,'adresse'),
			'code_postal'=>sinon($fournisseur,'code_postal'),
			'ville'=>sinon($fournisseur,'ville'),
			'pays'=>sinon($fournisseur,'pays'),
			'telephone'=>'',
			'url'=>http(sinon($fournisseur,'site_web')),
			'blog'=>'',
			'facebook'=>'',
			'twitter'=>'',
			'youtube'=>'',
			'googleplus'=>'',
			'linkedin'=>'',
			'premium'=>sinon($fournisseur,'premium') ? 1 : 0,
			'nom_contact'=>sinon($fournisseur,'supplier_contact_nom'),
			'email_contact'=>sinon($fournisseur,'supplier_contact_email','email'),
			'telephone_contact'=>sinon($fournisseur,'supplier_contact_tel'),
			'optin'=>sinon($fournisseur,'contact_fiche_complete','optin'),
			'legacy_supplier_id'=>false,
			'videos'=>'',
			'gallerie'=>'',
			)
	);

	$post_id = wp_insert_post($post);


	foreach($post['meta_input'] as $k=>$v) {
		update_field($k,$v,$post_id);
	}

	if(count($categories)) {
		wp_set_post_terms( $post_id, $categories, 'categorie' );
	}

	return $post_id;
}
function fournisseurs_filtre($query) {
    if ($query->post_type = 'fournisseur' && $query->is_search && !is_admin() ) {
    	// $query->query['s'] = '%'.$query->query['s'].'%';
    	// $query->query_vars['s'] = '%'.$query->query_vars['s'].'%';
    }
	return $query;
}

add_filter('pre_get_posts','fournisseurs_filtre');



$GLOBALS['MENU_FOURNISSEURS'] = array(
	array(
		'titre'=>'Coordonnées',
		'anchor'=>'coordonnees'
	),
	array(
		'titre'=>'Activités',
		'anchor'=>'activites',
	),
	array(
		'titre'=>'Présentation',
		'anchor'=>'presentation',
		'premium'=>true
	),
	array(
		'titre'=>'Articles',
		'anchor'=>'articles',
		'premium'=>true
	),
	array(
		'titre'=>'Photos',
		'anchor'=>'photos',
		'premium'=>true
	),
	array(
		'titre'=>'Vidéos',
		'anchor'=>'videos',
		'premium'=>true
	),
	array(
		'titre'=>'Evénements',
		'anchor'=>'evenements',
		'premium'=>true
	),
	array(
		'titre'=>'Documentation',
		'anchor'=>'documentation',
		'premium'=>true
	),
);

function fournisseurs_filtre_lettres() {
	$initiale = check('initiale');
	$lettres = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

	echo "<a class='case-initiale ".($initiale == '*' ? 'selected' : '')."' href='/fournisseurs-liste?initiale=*'>#</a>";
	foreach($lettres as $lettre) {
		echo " <a class='case-initiale ".($initiale == $lettre ? 'selected' : '')."' href='/fournisseurs-liste?initiale=$lettre'>$lettre</a>";
	}
}
function fournisseurs_filtre_categories($categories,$niveau=1,$checkboxes=false,$selected=array()) {
	if($niveau==1) {
		$html='<div class="case-categories-fournisseurs">';
	} else {
		$html='';
	}
	$demi = ceil(count($categories)/2);
	$cpt=0;
	foreach($categories as $categorie){
		$souscat = !empty($categorie['categories']);
		$html.='<ul class="liste-categorie '.($souscat && $niveau == 1? 'souscat closed' : '').'">';
		if($souscat && $niveau == 1) {
			$html.='<li class="cat-name">'.$categorie['name'].'</li>';
		} else if($souscat){
			$html.='<li><b>'.$categorie['name'].'</b></li>';
		} else if($checkboxes){
			$html.='<li><label><input '.(empty($selected) || in_array($categorie['term_id'], $selected)===false ? '' : 'checked').' name="categories[]" value="'.$categorie['term_id'].'" type="checkbox"> '.$categorie['name'].'</label></li>';
		} else {
			$html.='<li><a href="'.$categorie['url'].'">'.$categorie['name'].'</a></li>';
		}
		if($souscat) {
			$sub = fournisseurs_filtre_categories($categorie['categories'],$niveau+1,$checkboxes,$selected);
			if($niveau == 1) {
				$html.='<li class="cat-content">';
				$html.='<div class="cat-content-in">';
				$html.=$sub;
				$html.='</div>';
				$html.='</li>';
			} else {
				$html.='<li>'.$sub.'</li>';

			}
		}
		$html.='</ul>';
		if($niveau == 1) {
			$cpt++;
			if($cpt==$demi) {
				$html.='</div><div class="case-categories-fournisseurs">';
			}
		}
	}
	if($niveau==1) {
		$html.='</div>';
	} else {
		$html.='';
	}
	if($niveau == 1) {
		echo $html;
	} else {
		return $html;
	}
}
function fournisseur_categories($fournisseur=false) {
	$out=array();
	if(!$fournisseur) {
		$categories = get_terms('categorie',array(
		    'hide_empty' => false,
		));
		$categories_assoc = array();
		foreach($categories as $k=>$v) {
			$url = get_term_link($v);
			$v = get_object_vars($v);
			$v['url'] = $url;
			$categories_assoc[$v['term_id']] = $v;
		}

		$lien_papa = array();
		foreach($categories_assoc as $categorie) {
			if(!$categorie['parent']) {
				$out[$categorie['term_id']] = $categorie;
			} else {
				$lien_papa[$categorie['term_id']] = $categorie['parent'];
			}
		}
		foreach($categories_assoc as $categorie) {
			if(!$categorie['parent']) {
				$out[$categorie['term_id']] = $categorie;
			}
		}
		foreach($categories_assoc as $categorie) {
			if($categorie['parent']) {
				if(isset($out[$categorie['parent']])) {
					if(!isset($out[$categorie['parent']]['categories'])) {
						$out[$categorie['parent']]['categories'] = array();
					}
					$out[$categorie['parent']]['categories'][$categorie['term_id']] = $categorie;
				}
			}
		}
		foreach($categories_assoc as $categorie) {
			if($categorie['parent'] && !isset($out[$categorie['parent']])) {
				$root = $lien_papa[$categorie['parent']];
				if(isset($out[$root])) {
					if(!isset($out[$root]['categories'][$categorie['parent']]['categories'])) {
						$out[$root]['categories'][$categorie['parent']]['categories'] = array();
					}
					$out[$root]['categories'][$categorie['parent']]['categories'][$categorie['term_id']] = $categorie;
				}
			}
		}
/*		foreach($categories_assoc as $categorie) {
			if($categorie['parent']) {
				if(isset($out[$categorie['parent']])) {
					if(!isset($out[$categorie['parent']]['categories'])) {
						$out[$categorie['parent']]['categories'] = array();
					}
					if(!isset($out[$categorie['parent']]['categories'][$categorie['term_id']])) {
						$out[$categorie['parent']]['categories'][$categorie['term_id']] = $categorie;
					}
				} else {
					$root = $lien_papa[$categorie['parent']];
					if(!isset($out[$root]['categories'][$categorie['parent']]['categories'])) {
						$out[$root]['categories'][$categorie['parent']]['categories'] = array();
					}
					$out[$root]['categories'][$categorie['parent']]['categories'][$categorie['term_id']] = $categorie;
				}
			}
		}
		// me($out);*/
	} else
	if($cats = wp_get_post_terms($fournisseur['ID'],'categorie')) {
		foreach ($cats as $cat) {
			if($cat->parent) {
				if(!isset($out[$cat->parent])) {
					$parent = get_term($cat->parent,'categorie');
					if($parent->parent) {
						$parent2 = get_term($parent->parent,'categorie');
						$tmp = array('nom'=>$parent2->name,'url'=>get_term_link($parent2),'niveau'=>'1');
						$out[$parent->parent]=$tmp;
					}
					$tmp = array('nom'=>$parent->name,'url'=>get_term_link($parent),'categories'=>array(),'niveau'=>'2');
					$out[$cat->parent]=$tmp;
				}
				$out[$cat->parent]['categories'][]=array('nom'=>$cat->name,'url'=>get_term_link($cat),'id'=>$cat->term_id);
			}
		}
	}
	return $out;
}
function fournisseur_sections($fournisseur) {
	$page = check('page');
	foreach($GLOBALS['MENU_FOURNISSEURS'] as $item) {
		if(!$page || $page == $item['anchor']) {
			$file = get_template_directory().'/single-fournisseur-'.$item['anchor'].'.php';
			if(file_exists($file)) {
				ob_start();
				include $file;
				$data = ob_get_contents();
				ob_end_clean();
				if(!empty($data)) {
					echo '<section id="'.$item['anchor'].'"><h2 class="title"><a name="'.$item['anchor'].'">'.$item['titre'].'</a></h2></section><div>';
					echo $data;
					echo '</div>';
				}
			}
		}
	}
}
function fournisseur_menu($fournisseur) {
	$page = check('page');
	$ret='<input type=hidden name=page value="'.htmlspecialchars($page).'">';
	if(!$page) {
		$page = 'coordonnees';
	}
	$ret.= '<div class="cadre-menu-fournisseurs"><section class="actions menu-fournisseurs">';
	// $ret.='<div class="nom-fournisseur"><h2 class="title">'.$fournisseur['post_title'].'</h2></div>';
	foreach($GLOBALS['MENU_FOURNISSEURS'] as $item) {
		if($page == $item['anchor']) {
			$class='menu_actif';
		}else {
			$class='';
		}
		if(!$item['premium'] || $fournisseur['premium']) {
			$ret.='<a href="'.$fournisseur['premalink'].'?page='.$item['anchor'].'" data-id="'.$item['anchor'].'" class="button menu-item '.$class.'">'.$item['titre'].'</a>';
		} else {
			$ret.='<span class="button details_supplier_disabled">'.$item['titre'].'</span>';
		}
	}
	$ret.='</section></div>';

	echo $ret;
}

function fournisseur_categorie_redir() {
	if(!empty($_GET['categorie'])) {
		if($term_id = nouvelIdCategorie($_GET['categorie'])) {
			wp_redirect(get_term_link(get_term($term_id,'categorie')),301);
		}
	} else {
		if(check('type')=='liste') {
			wp_redirect('/fournisseurs-liste',301);
		} else {
			wp_redirect('/fournisseurs',301);
		}
	}
	exit;
}
function fournisseur_redir($legacy_supplier_id) {
	if($fournisseur = get_fournisseur($legacy_supplier_id,true)) {
		wp_redirect($fournisseur['permalink'],301);
	}
	exit;
}
add_filter( 'parse_query', 'filtre_fournisseurs' );
add_action( 'restrict_manage_posts', 'filtre_fournisseurs_restrict_manage_posts' );

function filtre_fournisseurs( $query )
{
    global $pagenow;

    if ( is_admin() && $pagenow=='edit.php') {
        if(!empty($_GET['ADMIN_FILTER_PREMIUM'])) {
	        $query->query_vars['meta_key'] = 'premium';
	        $query->query_vars['meta_value'] = 1;
	    }
    }
}

function filtre_fournisseurs_restrict_manage_posts()
{
    global $wpdb, $typenow;
		if ($typenow=='fournisseur'){
			$premium = !empty($_GET['ADMIN_FILTER_PREMIUM']);
?>
<select name="ADMIN_FILTER_PREMIUM" onchange="jQuery('input[name=filter_action]').trigger('click');">
<option value="1" <?php echo $premium ? 'selected' : '';?>>Partenaires</option>
<option value="0" <?php echo !$premium ? 'selected' : '';?>>Tous les fournisseurs</option>
</select>
<?php
}
}
/*
function filtre_fournisseurs_restrict_manage_posts()
{
    global $wpdb, $typenow;
		if ($typenow=='fournisseur'){
		    $sql = 'SELECT DISTINCT meta_key FROM '.$wpdb->postmeta.' ORDER BY 1';
		    $fields = $wpdb->get_results($sql, ARRAY_N);
?>
<select name="ADMIN_FILTER_FIELD_NAME">
<option value=""><?php _e('Filter By Custom Fields', 'baapf'); ?></option>
<?php
    $current = isset($_GET['ADMIN_FILTER_FIELD_NAME'])? $_GET['ADMIN_FILTER_FIELD_NAME']:'';
    $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
    foreach ($fields as $field) {
        if (substr($field[0],0,1) != "_"){
        printf
            (
                '<option value="%s"%s>%s</option>',
                $field[0],
                $field[0] == $current? ' selected="selected"':'',
                $field[0]
            );
        }
    }
?>
</select> <?php _e('Value:', 'baapf'); ?><input type="TEXT" name="ADMIN_FILTER_FIELD_VALUE" value="<?php echo $current_v; ?>" />
<?php
}
}*/

ini_set("memory_limit", "1G");

//error_reporting(-1);
//ini_set('display_errors', 'On');

function get_fournisseur($ID,$legacy=false) {
	if($legacy) {
		$query = new WP_Query(array(
			'post_type'		=> 'fournisseur',
			'meta_query' => array(
		       array(
		           'key' => 'legacy_supplier_id',
		           'value' => $ID,
		           'compare' => '=',
		       )
		   )
		));
		if(count($query->posts)) {
			return fournisseur_enrichir($query->posts[0]);
		}
	} else 
	if($fournisseur = get_post($ID)){
		if($fournisseur->post_type == 'fournisseur') {
			return fournisseur_enrichir($fournisseur);
		}
	}
}

function fournisseur_enrichir($fournisseur) {
	$fournisseur = get_object_vars($fournisseur);

	$allmeta = get_post_meta($fournisseur['ID']);
	foreach($allmeta as $k=>$v) {
		if(substr($k, 0,1) !='_') {
			$meta[$k] = $v[0];
			if(!isset($fournisseur[$k])) {
				$fournisseur[$k]=$v[0];
			}
		}
	}
	$fournisseur['meta'] = $meta;
	$gallerie = get_field('gallerie',$fournisseur['ID']);
	if(!is_array($gallerie)) {
		$gallerie = array();
	}
	foreach($gallerie as $k=>$photo) {
		if(is_numeric($photo)) {
			$photo = array('ID'=>$photo,'id'=>$photo);
			$meta = wp_get_attachment_metadata($photo['id']);
			$p = get_post($photo['id']);
			$photo['title'] = $p->post_title;
			$photo['caption'] = $p->post_excerpt;

			$photo['filename'] = basename($meta['file']);
			$photo['url'] = wp_upload_dir()['baseurl'].'/'.$meta['file'];
			$photo['sizes'] = array('thumbnail'=>wp_get_attachment_thumb_url($photo['id']));
			$gallerie[$k]=$photo;
		}
	}
	$fournisseur['gallerie'] = $gallerie;

	$fournisseur['videos'] = array();
	while(have_rows('videos',$fournisseur['ID'])) {
		the_row();
		$fournisseur['videos'][] = array(
			'titre_de_la_video'=>get_sub_field('titre_de_la_video'),
			'url_de_la_video'=>get_sub_field('url_de_la_video')
		);
	}

	$fournisseur['salons'] = array();
	while(have_rows('salons',$fournisseur['ID'])) {
		the_row();
		$fournisseur['salons'][] = array(
			'nom_du_salon'=>get_sub_field('nom_du_salon'),
			'url'=>get_sub_field('url'),
			'dates'=>get_sub_field('dates'),
			'lieu'=>get_sub_field('lieu'),
			'informations_additionelles'=>get_sub_field('informations_additionelles'),
		);
	}

	$fournisseur['logo'] = get_post_thumbnail_url($fournisseur['ID']);
	
	$fournisseur['permalink'] = get_post_permalink($fournisseur['ID']);

	$fournisseur['nom'] = $fournisseur['post_title'];

	$fournisseur['documentation']=array();
	$attachments = new Attachments( 'attachments_fournisseur', $fournisseur['ID']); 
	if($attachments->exist()) {
		while( $attachments->get() ){ 
			$fournisseur['documentation'][$attachments->url()]=$attachments->field( 'title' );
		}
	}

	$fournisseur['categories'] = fournisseur_categories($fournisseur);
	return $fournisseur;
}

function fournisseur_empty($test) {
	if(!$test) {
		?><i><small>Cette section est vide</small></i><?php
		return true;
	} else {
		return false;
	}
}
function fournisseurs_compte($categorie=false) {
	$ret = wp_count_posts('fournisseur');
	return $ret->publish;
}

function get_fournisseurs($params=array()) {
	$args = array();

	$cache = sinon($params,'cache');
	if($cache && ($data = get_transient($cache))) {
		return $data;
	} else {

		if($initiale = sinon($params,'initiale')) {
			global $wpdb;
			if($initiale == '*') {
				$clause = "post_title REGEXP '^[[:digit:]]+.*$'";
			} else {
				$clause = "post_title LIKE '$initiale%'";
			}
	         $results = $wpdb->get_results(
	                "
	                SELECT * FROM $wpdb->posts
	                WHERE post_type = 'fournisseur' 
	                AND $clause
	                AND post_status = 'publish'
	                ORDER BY post_title ASC; 
	                "
	         );
	         $fournisseurs = array();
	  		if ($results){
	            foreach ($results as $post){
	                // setup_postdata ($post); 
	                $fournisseurs[]=$post;
	            }
	         } 
		} else {
			if(sinon($params,'premium')) {
				$args['meta_key']='premium';
				$args['meta_value']=1;
				$params['images']=true;
				$rich=true;
			} else {
				$rich=false;
			}



			if(sinon($params,'categorie')) {
				$args['categorie']=sinon($params,'categorie');
		/*		$args['tax_query']=array(
					array(
						'taxonomy' => 'categorie',
						'field' => 'id',
						'terms' => sinon($params,'categorie')
					)
		    	);*/
			} else {
				$args['post_type'] = 'fournisseur';
			}
		//	$args['numberposts'] = sinon($params,'parpage','default:500');
			
			$args['orderby'] = 'title';
			$args['order'] = 'ASC';

			$args['offset']	= sinon($params,'debut','default:0');
			$args['posts_per_page'] = sinon($params,'parpage','default:500');

			$query = new WP_Query($args);
			$fournisseurs = $query->posts;
		}


		// me($args,$query->posts);
		// $fournisseurs = get_posts($args);
		if($rich || sinon($params,'images') || sinon($params,'enrichir')) {
			foreach($fournisseurs as $k=>$v) {
				$fournisseurs[$k] = fournisseur_enrichir($v);

			}
			$ret = $fournisseurs;
		} else {
			$ret = array_map('get_object_vars',$fournisseurs);
		}
		if($cache) {
			set_transient($cache,$ret);
		}
		return $ret;
	}
}
