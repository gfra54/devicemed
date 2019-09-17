<?php

add_filter('advanced-ads-ad-select-override-by-group',function($nope, $adgroup, $ordered_ad_ids) {
	$ads = $adgroup->get_all_ads();
	$final = array();
	$prioritaire=false;
	if(is_array($ordered_ad_ids)) {
		foreach($ordered_ad_ids as $id) {
			$ad = $ads[$id];
			if($condition = advanced_ads_ok_page($ad->ID)) {
				if(!$prioritaire && get_field('pub_prioritaire',$ad->ID)) {
					$prioritaire = $id;
				}
				$final[] = $id;
			}
		}
		if($prioritaire) {
			$final = array($prioritaire);
		}
		return $adgroup->output( $final );
	}
}, 10, 3);

function advanced_ads_ok_page($id) {

	$condition=false;
	if($pages = get_field('pages',$id)) {
		if($pages == 'urls') {
			if($ciblage = get_field('urls_cibles',$id)) {
				if(count($ciblage)) {
					if(is_array($ciblage)) {
						$ok=false;
						foreach($ciblage as $cible) {
							if(!$ok && $cible['url']) {
								if($cible['condition'] == 'contient') {
									$ok = strstr($_SERVER['REQUEST_URI'],$cible['url'])!==false;
								} else {
									$ok = strstr($_SERVER['REQUEST_URI'],$cible['url'])===false;
								}
								if(!$condition && $ok) {
									$condition=print_r($cible,true);
								}
							}
						}
						if(!$ok) {
							return false;
						}
					}
				}
			}
		} else if($pages == 'all') {
			$condition='all';
		} else if($pages == 'home') {
			if(is_home() || $GLOBALS['ADVANCED_ADS_PAGE'] == 'home' || $GLOBALS['ADVANCED_ADS_PAGE'] == 'all') {
				$condition = 'is_home';
			} else {
				return false;
			}
		}
	}
	return $condition;

}







add_filter('advanced-ads-output-final',function($output, $ad, $output_options) {

	$options = $ad->options();
	// if($condition = advanced_ads_ok_page($ad->id)) {
		if($options['group_info']['id']==3788) { //Site - Text Ad ou bannière

			if(get_field('afficher_en_text_ad',$ad->id)) {

				$url = getHtmlVal('href="','"',$output);

				$image = getHtmlVal('src=\'','\'',$output);

				$params = [

					'image'=>$image,

					'title'=>get_field('titre_de_la_text_ad',$ad->id),

					'text'=>nl2br(get_field('texte_de_la_pub',$ad->id)),

					'lien'=>get_field('libelle_du_lien',$ad->id),

					'url'=>$url

				];

				$output = render_textad($params,'site');

			}

		// }


		$comment = 'Ad ID '.$ad->id;
		if($condition) {
			$comment .=PHP_EOL.$condition;
		}

		$output = '<!-- '.PHP_EOL.$comment.PHP_EOL.' -->'.$output;

		return $output;

	}
}, 10, 3);





