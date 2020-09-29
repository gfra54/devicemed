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

	}

	if($prioritaire) {

		$final = array($prioritaire);

	}

	return $adgroup->output( $final );

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

									if($cible['url'] == 'home') {

										$ok = $_SERVER['REQUEST_URI']=='/';

									} else {

										$ok = strstr($_SERVER['REQUEST_URI'],$cible['url'])!==false;

									}

								} else {

									if($cible['url'] == 'home') {

										$ok = $_SERVER['REQUEST_URI']!='/';

									} else {

										$ok = strstr($_SERVER['REQUEST_URI'],$cible['url'])===false;



									}

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

	if($condition = advanced_ads_ok_page($ad->id)) {

		// if($options['group_info']['id']==3788) { //Site - Text Ad ou bannière



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



				$output = render_textad($params,'site',false);



			}



		// }



		if(get_field('pub_video',$ad->id)) {
			$embed_video = get_field('embed_video',$ad->id);
			if(!$embed_video) {
				$tmp = explode('v=',$ad->url);
				$code = current(explode('&',$tmp[1]));
				$embed_video  = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$code.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			}
			$titre_video = get_field('titre_video',$ad->id);
			$output = '
				<section id="sidebar-tag">
					<header>
						<div class="right-side">
							<h1 class="title">'.$titre_video.'</h1>
						</div>
					</header>	
					<article>

					
				<div class="cadre-video">
					
				'.$embed_video.'
					
					</div>
						<br>
				</article>
				</section>		
				<br>
				<style>
				.cadre-video  {
					position:relative;
					width:100%;
					height:0;
					padding-bottom:60%;
				}
				.cadre-video  > * {
					position:absolute;
					width:100%;
					height:100%;
					top:0;
					left:0;
				}
				</style>';

		}

		$comment = 'Ad ID '.$ad->id;

		if($condition) {

			$comment .=PHP_EOL.$condition;

		}



		$output = '<!-- '.PHP_EOL.$comment.PHP_EOL.' -->'.$output;

		return $output;



	}

}, 10, 3);











