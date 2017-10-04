
<?php 
$date_envoi = "15-12-2015";
$titre='Réglementation – Médecine du futur – Silicone – Alimentation DC – Electronique';

$urls = array(
'http://www.devicemed.fr/dossiers/actualites/evenements/test-gilles-merci-dignorer-cet-article/5025',
array('category'=>'Réglementation','url'=>'http://www.devicemed.fr/dossiers/reglementation/attention-aux-residus-doxyde-dethylene-pour-les-touts-petits/5013'),
'http://www.devicemed.fr/dossiers/materiaux/materiaux-plastiques/dow-corning-elargit-son-portefeuille-de-silicone-liquide-dedies-aux-dm/4998',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/alimentations-ac-dc-de-30-w-et-225-w-pour-les-applications-medicales-2/5030',
'http://www.devicemed.fr/dossiers/sous-traitance-et-services/electronique/flex-confirme-ses-ambitions-dans-le-medical-en-ouvrant-une-usine-au-mexique-et-en-rachetant-farm-design/5023',
'http://www.devicemed.fr/dossiers/actualites/evenements/un-colloque-dedie-a-la-revision-de-la-norme-iso-14644-le-12-janvier-2016-a-paris/4996',
'http://www.devicemed.fr/dossiers/actualites/vie-des-entreprises/stil-s-a-est-desormais-dirigee-par-cosimi-corleto/5050'
);

$banners = array(
	'top' => array(
		'image'=>'http://i.snag.gy/wA7Of.jpg',
		'pixel'=>'http://bs.serving-sys.com/BurstingPipe/adServer.bs?cn=tf&c=19&mc=imp&pli=15303200&PluID=0&ord=[timestamp]&rtu=-1',
		'url'=>'http://bs.serving-sys.com/BurstingPipe/adServer.bs?cn=tf&c=20&mc=click&pli=15303200&PluID=0&ord=[timestamp]'
	),	
	'right' => array(
		array(
			'image'=>'http://i.snag.gy/GovSk.jpg',
			'url'=>'http://www.devicemed.fr/'
		),
		array(
			'image'=>'http://i.snag.gy/En70p.jpg',
			'url'=>'http://www.devicemed.fr/fournisseurs_partenaires'
		),
	)
);
/*$ads = array(
	2 => array(
		'image'=>'http://i.snag.gy/z5Uez.jpg',
		'title'=>'Calculs de valeurs d’humidité',
		'text'=>'Connaissez-vous la corrélation entre les différents paramètres de l’humidité ? Avec le Calculateur d’humidité de Vaisala vous pouvez calculer plusieurs paramètres à partir d’une seule valeur connue. La nouvelle interface utilisateur fonctionne avec tous les terminaux, en ligne ou hors connexion.',
		'lien'=>'Téléchargez',
		'url'=>'http://forms.vaisala.com/LP=1315?utm_medium=email&utm_source=Devicemed&utm_campaign=CEN-LSC-EMEA-FR-Device%20Med&utm_content=RH_calculator'
	),
);*/

$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/DM.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/novembre-decembre2015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}