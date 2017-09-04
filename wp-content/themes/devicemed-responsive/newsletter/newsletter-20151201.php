
<?php 
$date_envoi = "01-12-2015";
$date_display = "1<sup>er</sup> décembre 2015";
$titre='Traitement de surface - e-santé – implants – plasturgie – électronique – laser';
if($_GET['variante']==2) {
	$titre='Film actif pour implants – alliance pour l’e-santé – simulation et plasturgie';
}

$urls = array(
'http://www.devicemed.fr/dossiers/sous-traitance-et-services/traitement_surface/un-film-biologique-pour-prevenir-les-infections-et-les-inflammations-liees-aux-implants/4951',
'http://www.devicemed.fr/dossiers/actualites/associations_professionnelles/ehealth-france-une-nouvelle-alliance-pour-promouvoir-la-sante-numerique/4936',
'http://www.devicemed.fr/dossiers/actualites/evenements/implants-2016-le-congres-implants-renouvelle-sa-formule-dune-journee-sur-paris/4940',
'http://www.devicemed.fr/dossiers/actualites/associations_professionnelles/philippe-rusch-elu-president-du-pole-des-technologies-medicales/4928',
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/logiciels/une-nouvelle-reference-en-matiere-de-simulation-3d-des-procedes-de-plasturgie/4945',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/module-de-traitement-numerique-pour-protheses-auditives-connectees/4968',
'http://www.devicemed.fr/dossiers/actualites/evenements/le-salon-francais-espace-laser-sinvite-sur-lasys-2016-avec-un-stand-collectif/4741'
);

$banners = array(
	'top' => array(
		'image'=>'http://i.snag.gy/wA7Of.jpg',
		'pixel'=>'http://bs.serving-sys.com/BurstingPipe/adServer.bs?cn=tf&c=19&mc=imp&pli=15303200&PluID=0&ord=[timestamp]&rtu=-1',
		'url'=>'http://bs.serving-sys.com/BurstingPipe/adServer.bs?cn=tf&c=20&mc=click&pli=15303200&PluID=0&ord=[timestamp]'
	),	
	'right' => array(
		array(
			'image'=>'http://i.snag.gy/Wnj9A.jpg',
			'url'=>'http://www.visioneng.fr/produits?utm_source=Vision%20Engineering%20France&utm_medium=Skyscraper&utm_campaign=DMFR026_Newsletter-DeviceMedFR'
		),
		array(
			'image'=>'http://i.snag.gy/En70p.jpg',
			'url'=>'http://www.devicemed.fr/fournisseurs_partenaires'
		),
	)
);
$ads = array(
	2 => array(
		'image'=>'http://i.snag.gy/z5Uez.jpg',
		'title'=>'Calculs de valeurs d’humidité',
		'text'=>'Connaissez-vous la corrélation entre les différents paramètres de l’humidité ? Avec le Calculateur d’humidité de Vaisala vous pouvez calculer plusieurs paramètres à partir d’une seule valeur connue. La nouvelle interface utilisateur fonctionne avec tous les terminaux, en ligne ou hors connexion.',
		'lien'=>'Téléchargez',
		'url'=>'http://forms.vaisala.com/LP=1315?utm_medium=email&utm_source=Devicemed&utm_campaign=CEN-LSC-EMEA-FR-Device%20Med&utm_content=RH_calculator'
	),
);

$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/DM.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/novembre-decembre2015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}