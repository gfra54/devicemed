<?php 
$date_envoi = "25-08-2015";
$titre='Projets medtech financés par bpifrance – Silicones "purement" médicaux – Laser et microstructuration de surface';
$urls = array(
	'http://www.devicemed.fr/dossiers/actualites/conjoncture/la-e-sante-au-premier-plan-des-projets-finances-par-bpifrance-en-matiere-de-medtech/4253',
	'http://www.devicemed.fr/dossiers/materiaux/materiaux-plastiques/des-silicones-purement-medicaux/4233',
	'http://www.devicemed.fr/dossiers/actualites/evenements/locomotricite-et-fabrication-additive-sur-smte-2015/4224',
	'http://www.devicemed.fr/dossiers/sous-traitance-et-services/traitement_surface/de-lutilisation-du-laser-pour-la-microstructuration-de-surfaces-dimplants/4245',
	'http://www.devicemed.fr/dossiers/actualites/evenements/pack-design-day-pour-ne-rien-ignorer-de-lemballage-des-dm-a-usage-unique/4249',
	'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/assemblage/equipements-dassemblage-et-de-controle-de-pieces-medicales/4227',
	'http://www.devicemed.fr/dossiers/sous-traitance-et-services/travail_metaux-sous-traitance-et-services/marquage-decoupe-et-soudure-laser-au-service-des-dm/4239',
);

$ads = array(
	4 => array(
		'title'=>'Avantage ergonomique et 3D',
		'text'=>'Avantage ergonomique et 3D',
		'image'=>'http://i.snag.gy/axaDe.jpg',
		'url'=>'http://bit.ly/1VJ43wD'
	),
	2 => array(
		'image'=>'http://www.devicemed.fr/wp-content/uploads/2015/08/Picture-Textad-1_CW35-15_100x100-1.png',
		'title'=>'Avantage ergonomique et 3D',
		'text'=>'Microscope stéréo sans oculaire pour les tâches minutieuses nécessitant une visualisation stéréo 3D haute résolution, le Lynx EVO allie une performance optique exceptionnelle à une ergonomie sans pareil pour une productivité accrue. Grâce à un dispositif d’inspection rotatif sur 360°, il est possible d\'observer de manière optimale les composants médicaux et plastiques, par exemple.',
		'url'=>'http://bit.ly/1PoNu5C'
	)
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}