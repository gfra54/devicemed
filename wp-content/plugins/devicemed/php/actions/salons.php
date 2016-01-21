<?php

setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

function get_salons($nb=4) {
	$args = array( 
		'post_type'	=> 'salons',
		'posts_per_page'=>1000,
		'meta_query'	=> array(
			'relation'		=> 'OR',
			array(
				'key'	  	=> 'date_debut',
				'value'	  	=> date('Y-m-d'),
				'compare' 	=> '>=',
			),
			array(
				'key'	  	=> 'date_fin',
				'value'	  	=> date('Y-m-d'),
				'compare' 	=> '>=',
			),
		),		
/*		'meta_key'=>'date_debut',
		'orderby' => 'meta_value_num',
		'order' => 'ASC'*/
	);
	if($salons = new WP_Query($args)) {
		$sort=array();
		foreach($salons->posts as $key => $salon) {
			$sort[$key]=get_field('date_debut',$salon->ID);
		}
		asort($sort);
//		$sort = array_reverse($sort,true);
		$out=array();
		foreach($sort as $key=>$val) {
			if(count($out) <= $nb) {
				$salon = $salons->posts[$key];
				$tmp = array('titre'=>get_the_title($salon->ID));
				foreach(array('url','date_debut','date_fin','description','lieu','dates') as $champ) {
					$tmp[$champ]=get_field($champ,$salon->ID);
					if($champ == 'url') {
						$tmp[$champ]= http($tmp[$champ]);
					}
				}
				$out[]= $tmp;

			}
		}
		return $out;
	}
}
$GLOBALS['salons'] = array(
	array(
		'url'=>'http://www.pharmapackeurope.com/fr',
		'titre'=>'PHARMAPACK',
		'texte'=>'Exposition dédiée au packaging pharmaceutique et à l’administration de médicaments',
		'dateheure'=>'2016-02-10',
		'date'=>'10-11 février 2016',
		'lieu'=>'Paris'
	),
	array(
		'url'=>'http://www.medical-devices-meetings.com/',
		'titre'=>'MEDICAL DEVICES MEETINGS',
		'texte'=>'Convention d\'affaires dédiée à la fabrication de dispositifs et d’équipements médicaux',
		'dateheure'=>'2016-02-24',
		'date'=>'24-25 février 2016',
		'lieu'=>'Stuttgart'
	),
	array(
		'url'=>'http://medinov-connection.wix.com/medinov-connection',
		'titre'=>'MEDI’NOV',
		'texte'=>'Rencontres d’affaires dédiées à la fabrication et à la conception d’équipements médicaux',
		'dateheure'=>'2016-03-16',
		'date'=>'16-17 mars 2016',
		'lieu'=>'Grenoble'
	),
	array(
		'url'=>'http://industrie-expo.com/',
		'titre'=>'INDUSTRIE PARIS',
		'texte'=>'Salon des technologies de production',
		'dateheure'=>'2016-04-04',
		'date'=>'4-8 avril 2016',
		'lieu'=>'Paris Nord Villepinte'
	),
	array(
		'url'=>'http://www.medteceurope.com/',
		'titre'=>'MEDTEC EUROPE',
		'texte'=>'Salon des technologies médicales',
		'dateheure'=>'2016-04-12',
		'date'=>'12-14 avril',
		'lieu'=>'Stuttgart'
	),
	array(
		'url'=>'http://www.intermeditech.fr/',
		'titre'=>'INTERMEDITECH',
		'texte'=>'Salon de l’industrie des dispositifs médicaux',
		'dateheure'=>'2016-05-24',
		'date'=>'24-26 mai 2016',
		'lieu'=>'Paris Nord Villepinte'
	),
);
