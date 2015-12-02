<?php

//wp_register_style( 'pubs', plugins_url().'/custom-functions/css/pubs.css');
//wp_enqueue_style( 'pubs' );


//require_once(dirname(__FILE__).'/widgets/pubs_300x250.widget.php');

function afficher_pub($type,$attr=array()) {
	$args = array( 
		'category_name'	=> $type,
			'post_type'	=> 'pubs',
	);
	if(!empty($attr['raw'])){
		$cadre=false;
	}
	if($pubs = new WP_Query($args)) {

		if($pub = get_selected_pub($pubs->posts)) {

			
			$PUB = pub_metrics($pub);
			if($type == 'habillages') {
				$out = '<body class="body-habillage" data-url="'.get_field('url_cible',$PUB['ID']).'">';
				$out.='<style>.body-habillage {
					background-color:'.get_field('couleur_de_fond',$PUB['ID']).';
					padding-top:'.get_field('hauteur',$PUB['ID']).'px;
					background-image:url('.$PUB['url_tracking_display'].');
				}</style>';
				$cadre=false;
			} else {
				$cadre=true;
				if($PUB['url_tracking_display']) {
					$out = '<a href="'.addToURL($PUB['url_tracking_clicks'],'t',time()).'" target="_blank"><img src="'.addToURL($PUB['url_tracking_display'],'t',time()).'"></a>';
				}
			}
			if($cadre){
				echo '<section '.array_to_html_attributes($attr,array('class'=>'reclame')).'>';
			}
			echo $out;
			echo get_field('code',$PUB['ID']);
			
			if($cadre){
				echo '</section>';
			}
			return true;
		}
	}
	return false;
}

function get_selected_pub($pubs) {
	$pubs_sort=array();
	foreach($pubs as $key => $pub) {
/*		$duree = get_field('duree',$pub->ID);
		$difference = intval((time() - strtotime($pub->post_date)) / (3600 * 24));
		
		if(empty($duree) || $duree >= $difference) {*/
		if($date_debut = get_field('date_debut',$pub->ID)) {
			$date_debut.=' 00:00:00';
		}
		if($date_fin = get_field('date_fin',$pub->ID)) {
			$date_fin.=' 23:59:59';
		}
		$ok=true;
		if(!empty($date_debut) && time()<strtotime($date_debut)) {
			$ok=false;
		}
		if(!empty($date_fin) && time()>strtotime($date_fin)) {
			$ok=false;
		}
		if($ok) {
			if(check_univers(get_field('univers',$pub->ID))){
				$pubs_sort[$key] = get_field('pages',$pub->ID);
			}
		}
	}
	asort($pubs_sort);
	$pubs_sort = array_reverse($pubs_sort,true);

	$normal = array();
	foreach($pubs_sort as $id_pub => $pages) {
		if(check_pub_page($pages)) {
			return $pubs[$id_pub];
		} else if(empty($pages)){
			$normal[]=$pubs[$id_pub];
		}
	}
	if(count($normal)) {
		return $normal[array_rand($normal)];
	}

}
function check_univers($univers) {

	if($univers == "Toutes les pages") {
		return true;
	} else if($univers == "Seulement la page d'accueil" && is_front_page()) {
		return true;
	} else if($univers == "Toutes les pages sauf la page d'accueil" && !is_front_page()) {
		return true;
	}
	return false;
}
function check_pub_page($pages) {
	if($pages) {
		$pages = array_map('trim',explode(PHP_EOL,$pages));
		
		$uri = $_SERVER['REQUEST_URI'];
		foreach($pages as $page) {
			if($page) {
				if($uri == $page) {
					return true;
				} else if(strlen($page) > 2 && strstr($uri, $page)!==false) {
					return true;
				}
			}
		}
	}
	return false;
}

function pub_metrics($pub) {
	if($url_cible = get_field('url_cible',$pub->ID)) {
		if(!$url_tracking_clicks = get_field('url_tracking_clicks',$pub->ID)) {
			$url_tracking_clicks = bitly_shorten($url_cible);
			if(!$url_tracking_clicks) {
				$url_tracking_clicks = $url_cible;
			} else {
				update_post_meta($pub->ID, 'url_tracking_clicks', $url_tracking_clicks);
			}
		}
	}
	$out=array();
	foreach($pub as $k=>$v) {
		$out[$k]=$v;
	}
	if($out['image'] = sinon(wp_get_attachment_image_src(get_post_thumbnail_id($pub->ID),'full'),0)) {
		if(!$url_tracking_display = get_field('url_tracking_display',$pub->ID)) {
			if($url_tracking_display = bitly_shorten($out['image'])) {
				update_post_meta($pub->ID, 'url_tracking_display', $url_tracking_display);
			} else {
				$url_tracking_display = $out['image'];
			}
		}
	}
	$out['url_tracking_clicks']=$url_tracking_clicks;
	$out['url_tracking_display']=$url_tracking_display;
	return $out;
}
/*'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true );
*/