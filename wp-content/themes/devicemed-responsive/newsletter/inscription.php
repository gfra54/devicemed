<?php 
$GLOBALS['NORENDER']=true;
get_header(); 

$newsletters = array_reverse(glob('/home/devicemedr/www/wp-content/themes/devicemed-responsive/newsletter/newsletter-*.php'));

?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="new-newsletter">
		<h2 class="title">Abonnement à la newsletter bimensuelle</h2>

		<div class="">
				<form target="popup-news" action="https://app.mailjet.com/account/tools/widget/subscribe/1Ni" class="mailjet-widget-form" id="mailjet-widget-form" accept-charset="utf-8" method="post">      
	            <div class="form-fieldset">
	            	<div class="form-row">
	                	<div class="form-field">
	                		<input placeholder="Adresse mail" type="text" class="mailjet-widget-email-field" name="email" id="mailjet-widget-email-field-6900"  value="" size="20" maxlength="80"  />
	            		</div>
	            	</div>
				<div class="form-row"><small><label for="changer-newsletter"><input id="changer-newsletter" type="checkbox" onchange="if(this.checked) { $('#normal').hide();$('#partenaires').show(); } else {$('#partenaires').hide();$('#normal').show();}"> Recevoir les offres de nos partenaires</label></small></div>
				<div class="form-row">
					<div class="form-submit input_sabonner_magazine">
						<input type="submit" class="" value="S&#039;abonner">
					</div>
				</div>
		</div>
    	</form>


				<div class="lien-derniere-nl"><b>Lire les dernières newsletters :</b></div><br />
				<div class='link_newsletter'>

					<?php foreach($newsletters as $newsletter) { 
							$url = str_replace('/home/devicemedr/www/','/',$newsletter);
							include $newsletter;
							if(strtotime($date_envoi)<=time()) {
								echo 'Le '.utf8_encode(strftime("%d %B %Y",strtotime($date_envoi))). ' : <a href="'.$url.'">'.$titre.'</a><br>';
							}
					}?>

					Le 22 juillet 2015 : <a href="/wp-content/themes/devicemed-responsive/newsletter/newsletter16-15.php?mail=#">Implant cérébral microscopique – BGS mise gros sur les rayons gamma – Forums LNE sur la règlementation</a><br />
					Le 07 juillet 2015 : <a href="/wp-content/themes/devicemed-responsive/newsletter/newsletter15-15.php?mail=#">Fimado rachète Paucaplast - Le SNITEM réélit son président - L'Alsace labellisée MedTech</a><br />
					Le 24 juin 2015 : <a href="/wp-content/themes/devicemed-responsive/newsletter/newsletter14-15.php?mail=#">Nouvelle plate-forme pour le DM implantable – Formation réglementaire – Transpondeur NFC pour capteurs médicaux</a><br />
					Le 09 juin 2015 : <a href="/wp-content/themes/devicemed-responsive/newsletter/newsletter13-15.php?mail=#" target="blank">Tubulures en PEEK – Electronique imprimée – Guidage linéaire amagnétique</a><br />
					Le 02 juin 2015 : <a href="/wp-content/themes/devicemed-responsive/newsletter/newsletter12-15.php?mail=#" target="blank">Une vision précise du conditionnement – Microscope inversé évolutif - Les moyens du Cetim au service des DM</a><br />
					Le 26 mai 2015 : <a href="/wp-content/themes/devicemed-responsive/newsletter/newsletter11-15.php?mail=#" target="blank">Panser intelligemment – Des CROs en fusion – Medtech Village 2</a><br />
					Le 12 mai 2015 : <a href="/wp-content/themes/devicemed-responsive/newsletter/newsletter10-15.php?mail=#" target="blank">Living Lab pour la e-santé - des DM couverts de diamants - implantation ionique multi-sources</a><br />
					Le 28 avril 2015 : <a href="/wp-content/themes/devicemed-responsive/newsletter/newsletter9-15.php?mail=#" target="blank">EPHJ-EMPT-SMT tient le cap – Perforation laser d’emballage pour stérilisation…</a>
				</div>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>
<script>
	$(document).ready(function(){
		$('#changer-newsletter').on('change',function(){
			if($(this).prop('checked')) {
				_url = 'https://app.mailjet.com/account/tools/widget/subscribe/1Nj';
			} else {
				_url = 'https://app.mailjet.com/account/tools/widget/subscribe/1Ni';
			}
			$('#mailjet-widget-form').attr('action',_url);
		});
	})	
	$('#mailjet-widget-form').on('submit',function(){
		window.open('about:blank','popup-news','width=320,height=240,menubar=no,location=no,resizable=no,scrollbars=no,status=no')
	});
</script>