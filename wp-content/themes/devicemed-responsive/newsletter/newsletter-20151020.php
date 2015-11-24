<?php 
$date_envoi = "20-10-2015";
$titre='Les bienfaits du parylène – Le robot soigne les finitions - 3000 visiteurs à 3D Print';

$urls = array(
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/plasturgie/12-secondes-pour-linjection-de-pieces-complexes/4670',
'http://www.devicemed.fr/dossiers/actualites/evenements/3000-visiteurs-et-80-exposants-a-3d-print-2015/4628',
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/travail_metaux/la-precision-robotique-au-service-des-procedes-de-finition/4638',
'http://www.devicemed.fr/dossiers/materiaux/materiaux-plastiques/parylene-pour-des-dm-sous-tres-haute-protection-12/4643',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/module-dentree-dalimentation-pour-les-equipements-medicaux-utilises-a-domicile/4501',
'http://www.devicemed.fr/dossiers/composants-oem/moteurs-et-entrainements/mini-broche-pour-les-taches-de-positionnement-lineaire/4631'
//array('category'=>'Réglementation','url'=>'http://www.devicemed.fr/dossiers/reglementation/rapport-devaluation-clinique-un-element-de-plus-en-plus-essentiel-du-dossier-technique/4575'),
);
$banners = array(
/*	'top' => array(
		'image'=>'http://i.snag.gy/mgNuO.jpg',
		'url'=>'http://www.micronora.com'
	),	*/
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
		'image'=>'http://www.devicemed.fr/wp-content/uploads/newsletter/ni_nl_25-05-2015.jpg',
		'title'=>'Solutions NI pour les dispositifs médicaux',
		'text'=>'National Instruments fournit les outils et la technologie nécessaires pour prototyper et déployer votre dispositif médical. Les plateformes de prototypage NI associent le logiciel de programmation graphique LabVIEW, des technologies FPGA et des E/S analogiques, afin d\'assurer une grande précision et fiabilité. ',
		'lien'=>'Pour en savoir plus',
		'url'=>'http://www.ni.com/medical/f/?cid=Advertising-701i0000001KXrJAAW-France-none&metc=mt34pe&id=42'
	),
);

$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/Sept-Oct%202015.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/Septembre%20-%20Octobre%202015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}