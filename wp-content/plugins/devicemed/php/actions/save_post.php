<?php 

function save_post_action($post_id) {
	if(strstr($_SERVER['REQUEST_URI'],'post-new.php')!==false) {
		return;
	}
    global $post; 


    file_get_contents("https://waf.sucuri.net/api?v2&k=a1691d9eb844117a444359abb20b72ee&s=8ce3581bca2880c3bd31354222325762&a=clear_cache");

    if ($post->post_type == 'salons'){
		set_transient('salons','');
    }else if ($post->post_type == 'pubs'){
		
		

    	$display = bitly_shorten(get_post_thumbnail_url($post_id));
		update_field('url_tracking_display', $display, $post_id);

    
    	$url_cible = get_field('url_cible',$post_id);
    	update_field('url_cible',http($url_cible),$post_id);

		$clicks = bitly_shorten($url_cible);
		update_field('url_tracking_clicks', $clicks, $post_id);



    	store_pubs(true);



    	store_pub($post);
	} else if ($post->post_type == 'fournisseur'){
		fournisseur_enrichir($post,true);

		$noms_fournisseurs = get_transient('noms_fournisseurs');
		if(get_field('no_liens',$post_id)) {
			unset($noms_fournisseurs[$post_id]);
		} else {
			if(!is_array($noms_fournisseurs) || count($noms_fournisseurs) == 0) {
				$fournisseurs = get_fournisseurs(array('cache'=>false));

				$noms_fournisseurs = array();
				foreach($fournisseurs as $fournisseur) {
					if($alternatives_nom = fournisseur_alternatives_nom($fournisseur)) {
						$noms_fournisseurs[$fournisseur['ID']] = array(
							'alternatives'=>$alternatives_nom,
							'premium'=>get_field('premium',$fournisseur['ID']),
							'url'=>get_the_permalink($fournisseur['ID']),
							'nom'=>$fournisseur['post_title']
						);
					}
				}

			} else {
				if($alternatives_nom = fournisseur_alternatives_nom($post)) {
					$noms_fournisseurs[$post_id] = array(
						'alternatives'=>$alternatives_nom,
						'premium'=> get_field('premium',$post_id),
						'url'=>get_the_permalink($post_id),
						'nom'=>$post->post_title
					);
				}
			}
		}
		set_transient('noms_fournisseurs',$noms_fournisseurs);

	} else if ($post->post_type == 'newsletter'){

		$ordre_articles = get_field('ordre_articles',$post_id);
		if(!$ordre_articles) {
			$ordre_articles='';
			$args = array( 
			    'post_type' => 'post',
			    'tag' => get_field('mot_cle',$post_id)
			);

			if($arts = new WP_Query($args)) {
			  foreach($arts->posts as $art) {
			  	$ordre_articles.=$ordre_articles?"\n": '';
			  	$ordre_articles.=$art->ID;
			  }
			}
			update_field('ordre_articles',$ordre_articles,$post_id);
		}

	} else {
		if($post = get_post($post_id)) {
			if(strstr($post->post_content,'<a href=')!==false && strstr($post->post_content,'target="_blank"')===false) {
				$post_content = str_replace('<a href=','<a target="_blank" href=',$post->post_content);
				if($post_content != $post->post_content) {
					wp_update_post(array(
						'ID'=>$post_id,
						'post_content'=>$post_content
					));
				}
			}
		}
		set_transient('sommaire_magazine_home','');
		update_post_meta($post_id,'content_parsed','');
	}

}
add_action( 'save_post', 'save_post_action' );



