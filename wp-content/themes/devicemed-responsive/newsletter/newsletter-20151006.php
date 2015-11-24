<?php 
$date_envoi = "06-10-2015";
$titre='Du mouvement nait l’énergie - Rapport d’évaluation clinique – Capteurs confocaux';

$urls = array(
'http://www.devicemed.fr/dossiers/actualites/evenements/une-rentree-du-dispositif-medical-reussie-avec-160-industriels-reunis-sur-deux-jours/4569',
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/metrologie_controle/capteurs-compacts-pour-des-mesures-de-distance-submicroniques/4567',
array('category'=>'Réglementation','url'=>'http://www.devicemed.fr/dossiers/reglementation/rapport-devaluation-clinique-un-element-de-plus-en-plus-essentiel-du-dossier-technique/4575'),
'http://www.devicemed.fr/dossiers/actualites/evenements/davantage-de-sous-traitants-de-lindustrie-medicale-au-midest/4563',
'http://www.devicemed.fr/dossiers/sous-traitance-et-services/traitement_surface/revetements-pour-augmenter-la-duree-de-vie-des-instruments-medicaux/4543',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/du-mouvement-nait-lenergie-electrique/4493',
);
$banners = array(
	'top' => array(
		'image'=>'http://i.snag.gy/mgNuO.jpg',
		'url'=>'http://www.micronora.com'
	),	
	'right' => array(
		array(
			'image'=>'http://www.device-med.fr/wp-content/uploads/newsletter/devicemed_de.jpg',
			'url'=>'http://www.device-med.fr/?url=http://www.devicemed.de/&amp;id=60'
		),
		array(
			'image'=>'http://i.snag.gy/LuIuH.jpg',
			'url'=>'http://www.devicemed.fr/fournisseurs_partenaires'
		),
	)
);
$ads = array(
	2 => array(
		'image'=>'http://i.snag.gy/hd8lr.jpg',
		'title'=>'Vaisala HMT330 pour des mesures précises',
		'text'=>'Les transmetteurs d’humidité et de température Vaisala HUMICAP® HMT330 sont parfaits pour les applications où la stabilité de la mesure est importante. La garantie de 10 ans prouve leur excellente fiabilité. Avec de nombreuses options, les instruments peuvent s’adapter aux besoins de chacun et à toutes les applications.',
		'lien'=>'Pour plus d\'information',
		'url'=>'http://www.vaisala.fr/hmt330'
	),
);

$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/Sept-Oct%202015.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/Septembre%20-%20Octobre%202015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}