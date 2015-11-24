<?php 
$date_envoi = "08-09-2015";
$titre='Durée de vie des prothèses -  Moteur pour DM portables – Medtech en Suisse - DM et métrologie';
$urls = array(
'http://www.devicemed.fr/dossiers/actualites/evenements/sante-et-metrologie-se-rencontrent-au-cim-2015-du-21-au-24-septembre-prochains/4279',
'http://www.devicemed.fr/dossiers/composants-oem/moteurs-et-entrainements/un-moteur-dc-sans-balais-pour-meuler-percer-et-scier-en-salle-doperation/4321',
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/travail_metaux/de-nouvelles-solutions-laser-pour-la-fabrication-de-dm/4315',
array('category'=>'Réglementation','url'=>'http://www.devicemed.fr/dossiers/reglementation/lansm-publie-un-rapport-sur-la-duree-de-vie-des-protheses-de-hanche/4325'),
'http://www.devicemed.fr/dossiers/actualites/conjoncture/technologies-medicales-une-perspective-de-croissance-en-suisse/4330',
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/travail_metaux/gaz-industriels-un-role-cle-dans-les-procedes-laser/4335'
);
$banners = array(
	'bottom' => array(
		'image'=>'http://i.snag.gy/axaDe.jpg',
		'url'=>'http://bit.ly/1JYvrSM'
	),
	'top' => array(
		'image'=>'http://www.viapalma.fr/Acto/BanSept2015/DEVICE-MED-2015_256.gif',
		'url'=>'http://bit.ly/1IVSoRZ'
	),
	
);
$ads = array(
	2 => array(
		'image'=>'http://i.snag.gy/r5BbN.jpg',
		'title'=>'CALCULS DE VALEURS D’HUMIDITÉ',
		'text'=>'Connaissez-vous la corrélation entre les différents paramètres de l’humidité ? Avec le Calculateur d’humidité de Vaisala vous pouvez calculer plusieurs paramètres à partir d’une seule valeur connue. La nouvelle interface utilisateur fonctionne avec tous les terminaux, en ligne ou hors connexion.',
		'lien'=>'Téléchargez.',
		'url'=>'http://www.vaisala.fr/fr/services/technicalsupport/HumidityCalculator/Pages/default.aspx'
	),
);

$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/Sept-Oct%202015.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/Septembre%20-%20Octobre%202015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}