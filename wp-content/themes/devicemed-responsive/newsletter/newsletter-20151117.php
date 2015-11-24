
<?php 
$date_envoi = "17-11-2015";
$titre='Réglementation, modélisation, électronique, vision, aphérèse, Pharmapack…';
if($_GET['variante']==2) {
	$titre='Compatibilité ISO 9001 et 13485– Simulation biomécanique – Pharmapack 2016';
}

$urls = array(
array('category'=>'Réglementation','url'=>'http://www.devicemed.fr/dossiers/reglementation/smq-les-nouvelles-versions-des-normes-iso-9001-et-iso-13485-sont-elles-toujours-compatibles/4854'),
array('text'=>'Du coeur artificiel aux prothèses, en passant par les implants dentaires, la traçabilité des ancillaires ou les lits médicalisés, l’activité du Cetim est de plus en plus souvent au cœur des travaux de recherche et d’innovation des entreprises du secteur médical. Comme on a pu le constater cette année avec l’inauguration de son laboratoire de biomécanique, et la mise en place ...','url'=>'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/logiciels/modeliser-la-compression-du-sein-pour-concevoir-des-mammographes-indolores/4873'),

'http://www.devicemed.fr/dossiers/actualites/associations_professionnelles/alsace-biovalley-et-biowin-lancent-un-appel-a-projets-conjoint/4889',
'http://www.devicemed.fr/dossiers/composants-oem/accessoires-in-vitro/systeme-de-connexion-standardise-pour-securiser-les-procedures-dapherese/4841',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/isolateurs-numeriques-pour-securiser-les-applications-delectronique-medicale/4849',
'http://www.devicemed.fr/dossiers/actualites/evenements/pharmapack-europe-cherche-les-prochains-vainqueurs-de-ses-pharmapack-awards/4882',
'http://www.devicemed.fr/dossiers/actualites/evenements/forum-technologique-de-vision-industrielle-le-3-decembre-2015-a-paris/4887',
'http://www.devicemed.fr/dossiers/composants-oem/accessoires-in-vitro/de-la-conception-a-la-fabrication-de-ballonnets-medicaux-personnalises/4310'
//array('category'=>'Réglementation','url'=>'http://www.devicemed.fr/dossiers/reglementation/rapport-devaluation-clinique-un-element-de-plus-en-plus-essentiel-du-dossier-technique/4575'),
);
$banners = array(
/*	'top' => array(
		'image'=>'http://i.snag.gy/wA7Of.jpg',
		'pixel'=>'http://bs.serving-sys.com/BurstingPipe/adServer.bs?cn=tf&c=19&mc=imp&pli=15303200&PluID=0&ord=[timestamp]&rtu=-1',
		'url'=>'http://bs.serving-sys.com/BurstingPipe/adServer.bs?cn=tf&c=20&mc=click&pli=15303200&PluID=0&ord=[timestamp]'
	),	*/
	'right' => array(
		array(
			'image'=>'http://i.snag.gy/NFiWT.jpg',
			'url'=>'https://unispourservir.ups.com/fr/sante/#supply-chain-flexibility'
		),
		array(
			'image'=>'http://i.snag.gy/En70p.jpg',
			'url'=>'http://www.devicemed.fr/fournisseurs_partenaires'
		),
	)
);
/*$ads = array(
	2 => array(
		'image'=>'http://i.snag.gy/TH5lW.jpg',
		'title'=>'Monitoring pour les environnements contrôlés',
		'text'=>'Conçu pour les environnements contrôlés dans les industries de santé, le Système de Monitoring Vaisala viewLinc fournit en continu des données de température, humidité et autres paramètres tout en garantissant la totale conformité réglementaire BPx.',
		'lien'=>'Pour plus d\'informations',
		'url'=>'http://www.vaisala.fr/cms'
	),
);
*/
$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/DM.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/novembre-decembre2015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}