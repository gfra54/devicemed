<?php 
$GLOBALS['NORENDER']=true;
get_header(); 

?>
<style>
.nl-header {
	display:none;
}
</style>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="new-newsletter">
		<h2 class="title">Abonnement à la newsletter bimensuelle</h2>

		<div class="">
			<button class="btn-nl">Cliquez ici pour vous abonner</button>
		</div>
    	</form>
    	<br><br><p style="color:tomato">Attention: Si vous souhaitez vous abonner à la newsletter de DeviceMed, vous devez faire en sorte d'ajouter l'adresse <b>newsletter@devicemed.fr</b> à votre liste de contacts pour être certain que notre mailing ne termine pas dans vos spams</p>

				<div class="lien-derniere-nl"><b>Lire les dernières newsletters :</b></div><br />
				<div class='link_newsletter'>

				<?php 
				$args = array( 
						'post_type'	=> 'newsletter',
						'post_status'=>array('publish'),
						'posts_per_page'=>100
					);

					if($newsletters = new WP_Query($args)) {
						foreach($newsletters->posts as $post) {
							$date_envoi = get_field('date_envoi',$post->ID);
							if(strtotime($date_envoi)<=time()) {
								$url = get_permalink($post->ID);
								$titre = get_the_title($post->ID);
								echo 'Le '.(datefr($date_envoi)). ' : <a href="'.$url.'">'.$titre.'</a><br>';
							}
						}
					}
					$newsletters = array_reverse(glob('wp-content/themes/devicemed-responsive/newsletter/newsletter-*.php'));
					foreach($newsletters as $newsletter) { 

							$url = str_replace('/home/devicemedr/www/','/',$newsletter);
							if(substr($url,0,4)!='http') {
								$url = '/'.$url;
							}
							include $newsletter;
							if(strtotime($date_envoi)<=time()) {
								echo 'Le '.(strftime("%d %B %Y",strtotime($date_envoi))). ' : <a href="'.$url.'">'.$titre.'</a><br>';
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