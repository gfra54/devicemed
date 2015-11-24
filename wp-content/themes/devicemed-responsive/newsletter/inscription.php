<?php 
include 'utils.inc.php';
$GLOBALS['NORENDER']=true;
get_header(); 

$newsletters = array_reverse(glob('/home/devicemedr/www/wp-content/themes/devicemed-responsive/newsletter/newsletter-*.php'));

?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="new-newsletter">
		<h2 class="title">Abonnement à la newsletter bimensuelle</h2>

					<div class="form-label"> &nbsp; &nbsp; <small><label for="create-newsletter"><input id="create-newsletter" type="checkbox" onchange="if(this.checked) { $('#normal').hide();$('#partenaires').show(); } else {$('#partenaires').hide();$('#normal').show();}"> Recevoir les offres de nos partenaires</label></small></div>

					<iframe id="normal" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://widget.mailjet.com/45493f8e7f7ab7abd7241dbcff7fd7dd07f726b6.html" width="100%" height="138"></iframe>

					<iframe id="partenaires" style="display:none" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://widget.mailjet.com/565689424cb5a890ee70e37db49f4d11aa8108bd.html" width="100%" height="138"></iframe>



				<div class="lien-derniere-nl"><b>Lire les dernières newsletters :</b></div><br />
				<div class='link_newsletter'>

					<?php foreach($newsletters as $newsletter) { 
							$url = str_replace('/home/devicemedr/www/','http://www.devicemed.fr/',$newsletter);
							include $newsletter;
							if(strtotime($date_envoi)<=time()) {
								echo 'Le '.utf8_encode(strftime("%d %B %Y",strtotime($date_envoi))). ' : <a href="'.$url.'">'.$titre.'</a><br>';
							}
					}?>

					Le 22 juillet 2015 : <a href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter16-15.php?mail=#">Implant cérébral microscopique – BGS mise gros sur les rayons gamma – Forums LNE sur la règlementation</a><br />
					Le 07 juillet 2015 : <a href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter15-15.php?mail=#">Fimado rachète Paucaplast - Le SNITEM réélit son président - L'Alsace labellisée MedTech</a><br />
					Le 24 juin 2015 : <a href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter14-15.php?mail=#">Nouvelle plate-forme pour le DM implantable – Formation réglementaire – Transpondeur NFC pour capteurs médicaux</a><br />
					Le 09 juin 2015 : <a href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter13-15.php?mail=#" target="blank">Tubulures en PEEK – Electronique imprimée – Guidage linéaire amagnétique</a><br />
					Le 02 juin 2015 : <a href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter12-15.php?mail=#" target="blank">Une vision précise du conditionnement – Microscope inversé évolutif - Les moyens du Cetim au service des DM</a><br />
					Le 26 mai 2015 : <a href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter11-15.php?mail=#" target="blank">Panser intelligemment – Des CROs en fusion – Medtech Village 2</a><br />
					Le 12 mai 2015 : <a href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter10-15.php?mail=#" target="blank">Living Lab pour la e-santé - des DM couverts de diamants - implantation ionique multi-sources</a><br />
					Le 28 avril 2015 : <a href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter9-15.php?mail=#" target="blank">EPHJ-EMPT-SMT tient le cap – Perforation laser d’emballage pour stérilisation…</a>
				</div>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>