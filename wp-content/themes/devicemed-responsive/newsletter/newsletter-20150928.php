<?php 
$date_envoi = "29-09-2015";
$titre='Edition spéciale : l’électronique au service des dispositifs médicaux';
$titre_disp='Newsletter spéciale Electronique du 29 septembre 2015';
$urls = array(
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/un-capteur-de-position-sans-contact-au-service-du-traitement-des-bebes-prematures/4424',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/conditionnement-de-circuits-des-solutions-innovantes-pour-lelectronique-medicale/4444',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/lelectronique-embarquee-au-secours-des-secouristes/4470',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/un-systeme-de-vision-polyvalent-sur-un-cm3-seulement/4484',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/capteur-de-mouvement-triaxial-pour-dm-implantables/4461',
'http://www.devicemed.fr/dossiers/composants-oem/electriques_electroniques/memoire-resistante-au-rayonnement-gamma-pour-capteurs-medicaux-a-usages-uniques/4465',
);
$banners = array(
	'top' => array(
		'image'=>'http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/images/ANIM_device_med_france.gif',
		'url'=>'http://www.fischerconnectors.com/france/fr'
	),
	'right' => array(
		array(
			'image'=>'http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/images/banner_160x600pix.gif',
			'url'=>'http://www.fischerconnectors.com/france/fr/applications/medical'
		),

/*		array(
			'html'=>'
<div style="width:127px;background:#214f8e;padding:10px 0;font-family:\'Arial Black\',Arial;" bgcolor="#214f8e">
<center style="font-size:11px;margin:4px;padding-bottom:5px;">
	<b><font  color="white">FOURNISSEURS<br>PARTENAIRES</font></b>
</center>
<div style="font-size:12px;padding-left:6px;"><b>
<a style="text-decoration:none;display:block;margin-bottom:6px;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Fpsa/199?premiere_visite=1" target="_blank"><font  color="white">FPSA</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Heptal/306?premiere_visite=1" target="_blank"><font  color="white">Heptal</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Keol/260?premiere_visite=1" target="_blank"><font  color="white">Keol</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Ogp-France/226?premiere_visite=1" target="_blank"><font  color="white">OGP France</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Pierre-Fabre-Medicament-Supercritical-Fluids-Division/329?premiere_visite=1" target="_blank"><font  color="white">Pierre Fabre Médicaments</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Préiso/249?premiere_visite=1" target="_blank"><font  color="white">Préiso</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Qosina/6?premiere_visite=1" target="_blank"><font  color="white">Qosina</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Realmeca/221?premiere_visite=1" target="_blank"><font  color="white">Realmeca</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Teleflex-Medical-Oem/253?premiere_visite=1" target="_blank"><font  color="white">Teleflex Med.</font></a>
<a style="text-decoration:none;display:block;margin-bottom:6px;" href="http://www.devicemed.fr/suppliers/Usiplast-Composites/72?premiere_visite=1" target="_blank"><font  color="white">Usiplast Comp.</font></a>
</b>
</div>

</div>
			',
		),*/
	),	
);
$ads = array(
	2 => array(
		'image'=>'http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/images/ANIM_banner_100x100pix_1.gif',
		'title'=>'La fiabilité prime à qui sauve des vies',
		'text'=>'Les experts médicaux font confiance aux connecteurs en inox, plastique et jetables de Fischer Connectors, très fiables et faciles à manipuler et nettoyer. Pour une haute densité de signal et d’alimentation, ils choisissent Fischer MiniMax. Pour la transmission rapide des données : Fischer FiberOptic.',
		'lien'=>'Pour en savoir plus.',
		'url'=>' http://www.fischerconnectors.com/france/fr/applications/medical'
	),
);

$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/Sept-Oct%202015.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/Septembre%20-%20Octobre%202015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}