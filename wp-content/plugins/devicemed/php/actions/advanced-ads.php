<?php

add_filter('advanced-ads-output-final',function($output, $ad, $output_options) {


	$options = $ad->options();
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
			return render_textad($params,'site');
		}
	}

	return $output;
}, 10, 3);

/*add_filter('advanced-ads-output-final',function($array) {
	m('!',$array);
	return $array;
});*/
/*
add_filter('advanced-ads-group-output-array',function($array) {
	m($array);
	return $array;
});*/