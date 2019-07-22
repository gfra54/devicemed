<?php

setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

function get_salons($nb=4,$annee=false) {
	$debut=time();
	$cle = 'salons-'.$nb.'-'.$annee;
	$salons = get_transient($cle);

	if(!is_array($salons)) {
		$args = array( 
			'post_type'	=> 'salons',
			'posts_per_page'=>1000,
		);
		if($q = new WP_Query($args)) {
			$sort = array();
			foreach($q->posts as $key => $salon) {
				$date_debut=get_field('date_debut',$salon->ID);
				if($annee) {
					if(strstr($date_debut, $annee)!==false) {
						$sort[$key]=$date_debut;
					} else if($annee == date('Y')) {
						$annee2=''.($annee+1);
						if(strstr($date_debut, $annee2)!==false) {
							$sort[$key]=$date_debut;
						}
					}
				} else if(strtotime(get_field('date_fin',$salon->ID)) > $debut) {
					$sort[$key]=$date_debut;
				}
			}
			asort($sort);
			$salons=array();
			foreach($sort as $key=>$val) {
				$salon = $q->posts[$key];
				$tmp = array('titre'=>get_the_title($salon->ID));
				foreach(array('url','date_debut','date_fin','description','lieu','dates') as $champ) {
					$tmp[$champ]=get_field($champ,$salon->ID);
					if($champ == 'url') {
						$tmp[$champ]= http($tmp[$champ]);
					}
				}
				$salons[]=$tmp;
			}
			set_transient($cle, $salons);
		}

	}
	$out=array();
	$cpt=0;
	foreach($salons as $salon) {
		if(count($out) <= $nb+$debut) {
			$out[]= $salon;

		}
		$cpt++;
	}
	return $out;
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
