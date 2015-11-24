
<?php 
$date_envoi = "03-11-2015";
$titre='Nouveau salon du DM, électronique, impression 3D, liaison sans fil, métaux…';

$urls = array(
'http://www.devicemed.fr/dossiers/actualites/evenements/medtec-france-nest-plus-vive-intermeditech/4787',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/module-radio-miniaturise-pour-les-implants-connectes/4747',
'http://www.devicemed.fr/dossiers/actualites/evenements/conferences-sur-la-microelectronique-pour-les-applications-medicales-les-25-et-26-novembre-a-lyon/4789',
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/impression-3d-equipements-de-production-et-techniques-de-fabrication/impression-3d-quel-impact-dans-le-secteur-de-la-sante/4791',
'http://www.devicemed.fr/dossiers/actualites/vie-des-entreprises/heptal-accede-a-une-taille-critique-en-rejoignant-le-groupe-stainless/4732',
'http://www.devicemed.fr/dossiers/composants-oem/moteurs-et-entrainements/systeme-de-guidage-lineaire-par-vis-ecrou-pour-vitesses-elevees/4728'
//array('category'=>'Réglementation','url'=>'http://www.devicemed.fr/dossiers/reglementation/rapport-devaluation-clinique-un-element-de-plus-en-plus-essentiel-du-dossier-technique/4575'),
);
$banners = array(
	'top' => array(
		'image'=>'http://i.snag.gy/wA7Of.jpg',
		'pixel'=>'http://bs.serving-sys.com/BurstingPipe/adServer.bs?cn=tf&c=19&mc=imp&pli=15303200&PluID=0&ord=[timestamp]&rtu=-1',
		'url'=>'http://bs.serving-sys.com/BurstingPipe/adServer.bs?cn=tf&c=20&mc=click&pli=15303200&PluID=0&ord=[timestamp]'
	),	
	'right' => array(
		array(
			'image'=>'http://www.device-med.fr/wp-content/uploads/newsletter/devicemed_de.jpg',
			'url'=>'http://www.device-med.fr/?url=http://www.devicemed.de/&amp;id=60'
		),
		array(
			'image'=>'http://i.snag.gy/T8BCh.jpg',
			'url'=>'http://www.devicemed.fr/fournisseurs_partenaires' // pas le bon nom !
		),
	)
);
$ads = array(
	2 => array(
		'image'=>'http://i.snag.gy/TH5lW.jpg',
		'title'=>'Monitoring pour les environnements contrôlés',
		'text'=>'Conçu pour les environnements contrôlés dans les industries de santé, le Système de Monitoring Vaisala viewLinc fournit en continu des données de température, humidité et autres paramètres tout en garantissant la totale conformité réglementaire BPx.',
		'lien'=>'Pour plus d\'informations',
		'url'=>'http://www.vaisala.fr/cms'
	),
);

$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/Sept-Oct%202015.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/Septembre%20-%20Octobre%202015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}