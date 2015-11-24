<?php 
$date_envoi = "22-09-2015";
$titre='Métrologie des salles propres – Etalonnage en fluorescence – Formation à l’internationalisation des DM';
$urls = array(
'http://www.devicemed.fr/dossiers/actualites/associations_professionnelles/formation-diplomante-en-metrologie-des-salles-propres/4376',
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/metrologie_controle/solution-innovante-detalonnage-des-microscopes-a-fluorescence/4388',
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/metrologie_controle/microscope-sans-oculaire-stereoscopique-ergonomique-et-modulaire/4384',
array('category'=>'Réglementation','url'=>'http://www.devicemed.fr/dossiers/reglementation/formation-a-la-mise-sur-le-marche-des-dm-a-linternational/4372'),
'http://www.devicemed.fr/dossiers/equipements-de-production-et-techniques-de-fabrication/travail_metaux/anodisation-couleur-du-titane-sur-pieces-en-vrac/4379',
'http://www.devicemed.fr/dossiers/composants-oem/mecaniques/temoin-de-controle-de-choc-ultra-compact/4362'
);
$banners = array(
	'top' => array(
		'image'=>'http://i.snag.gy/auLnW.jpg',
		'url'=>'http://bit.ly/1KvVo8t'
	),
	'right' => array(
		array(
			'image'=>'http://i.snag.gy/eaQXh.jpg',
			'url'=>'http://www.formation-emitech.fr/content/sécurité-des-appareils-électromédicaux-–-en-60601-1-0'
		),
		array(
			'image'=>'http://i.snag.gy/LuIuH.jpg',
			'url'=>'http://www.devicemed.fr/fournisseurs_partenaires'
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
		'image'=>'http://i.snag.gy/j2RZH.jpg',
		'title'=>'Impression 3D: Explorez ses dimensions!',
		'text'=>'La fabrication additive est un procédé innovant qui utilise les dernières technologies d’impression 3D pour créer des prototypes avec une extrême précision. Découvrez les avantages et inconvénients de ces technologies d’impression 3D en consultant notre nouveau livre blanc.',
		'lien'=>'Téléchargez.',
		'url'=>'http://p.protolabs.fr/additive-white-paper?utm_campaign=fr-sos&utm_medium=display&utm_source=dm0915&utm_content=b-awp'
	),
);

$pdf = array(
	'image'=>'http://www.devicemed.fr/wp-content/uploads/archives/apercu/Sept-Oct%202015.png',
	'url'=>'http://www.devicemed.fr/wp-content/uploads/archives/pdf/Septembre%20-%20Octobre%202015.pdf'
);

if(empty($GLOBALS['NORENDER'])) {

	include 'render.php';
}