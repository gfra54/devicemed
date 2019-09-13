<?php



add_filter('advanced-ads-output-final',function($output, $ad, $output_options) {

	$options = $ad->options();

	$condition=false;

	if($pages = get_field('pages',$ad->id)) {
		if($pages == 'urls') {
			if($ciblage = get_field('urls_cibles',$ad->id)) {
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
		} else if($pages == 'home') {
			if(is_home()) {
				$condition = 'is_home';
			} else {
				return false;
			}
		}
	}

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

	}

	$comment = 'Ad ID '.$ad->id;
	if($condition) {
		$comment .=PHP_EOL.$condition;
	}

	$output = '<!-- '.PHP_EOL.$comment.PHP_EOL.' -->'.$output;

	return $output;

}, 10, 3);





