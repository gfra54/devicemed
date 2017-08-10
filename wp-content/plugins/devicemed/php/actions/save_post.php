<?php 

function save_post_action($post_id) {
    global $post; 
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
		set_transient('sommaire_magazine_home','');
		update_post_meta($post_id,'content_parsed','');
	}

}
add_action( 'save_post', 'save_post_action' );

/*
function on_all_status_transitions( $new_status, $old_status, $post ) {
    global $post; 
    if ($post->post_type == 'fournisseur'){
	    if ( $new_status != $old_status ) {
	    	if($new_status ==' publish' && $old_status == 'draft') {

	    		$envoi_mail = get_post_meta($post->ID,'envoi_mail');
	    		if(!$envoi_mail) {
					if(isDev()) {
	    				$to = 'jilfransoi@gmail.com';
	    			} else {
		    			$to = get_field('mail_contact_commercial',$post->ID);
		    		}

	    			$subject = 'Le fournisseurs "'.$post->post_title.'" est validé.';
	    			$message = 'Bonjour '.get_field('nom_contact_commercial',$post->ID)."\n".
	    			'Vous avez soumis le fournisseur "'.$post->post_title.'" pour qu\'il soit visible dans le répertoire DeviceMed des fournisseurs.'."\n".
	    			'Nos équipes ont passé en revue les données qui ont été saisies, et nous avons le plaisir de vous annoncer que ce fournisseur est désormais validé, et visible en ligne à cette adresse : '."\n\n".

	    			get_the_permalink($post)."\n\n".

	    			'Nous vous invitons à vérifer dès maintenant l\'exactitude des informations présentes sur la fiche fournisseur. Vous pouvez nous contacter pour indiquer des éventuels changements à apporter à votre fiche en envoyant un email à laurence.jaffeux@devicemed.fr (ou en répondant à cet email).'."\n\n".

	    			'Cordialement,'."\n".
	    			'l\'équipe DeviceMed';
	    			$headers='Reply-to: laurence.jaffeux@devicemed.fr';
	    			// $headers = 'BCC: web@devicemed.fr';
					if(wp_mail( $to, $subject, $message, $headers)) {
						add_post_meta($post->ID, 'envoi_mail', true, true);
					}
	    		}


	    	}

	    }
	}
}
add_action(  'transition_post_status',  'on_all_status_transitions', 10, 3 );

*/
/*function save_post_cache($post_id) {
	if(is_admin()) {
		cachepage_clear('index');
		cachepage_clear($post_id);
		//get_current_screen()->post_type		
	}

}
add_action( 'save_post', 'save_post_cache' );
// add_action( 'admin_menu', 'save_post_cache' );

/*$GLOBALS['pagecache_on']=false;
function watch_pagecache() {
	global $wp_query;
	if(!$GLOBALS['pagecache_on']) {
		$GLOBALS['pagecache_on']=true;
		if($wp_query->is_home()) {
			get_pagecache('index');
		} else {
			if(is_numeric($pid = $wp_query->query['p'])) {
				get_pagecache($pid);
			}
		}
	}
}
//add_action( 'pre_get_posts', 'watch_pagecache' );

/*function add_action_pagecache() {
	pagecache();
}
add_action('shutdown','add_action_pagecache');*/

/*foreach($_COOKIE as $name=>$val) {
	if(substr($name, 0, 20) == 'wordpress_logged_in_') {
		setcookie('wpadmin', true, time()+(3600 * 24 * 30),'/');
	}
}
*/