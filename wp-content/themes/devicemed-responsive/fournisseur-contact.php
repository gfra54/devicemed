<?php
/*
Template Name: fournisseur-contact
*/

if($contact = check('contact')) {

	$etat='ko';
	if(is_email($contact['email'])) {
		$nom  = $contact['nom'].' '.($contact['societe'] ? '('.$contact['societe'].')' : '');
		$to =array('laurence.jaffeux@devicemed.fr ','jilfransoi@gmail.com','evelyne.gisselbrecht@devicemed.fr');
		// $to =array('jilfransoi+test@gmail.com');
		$subject='Demande de contact / '.$nom.'';

		$message='Une demande de contact vous a été envoyée.'.PHP_EOL.'Voici les détails de la demande ci-dessous : <pre>';
		foreach($contact as $k=>$v) {
			$message.='<b>'.ucfirst($k).'</b>'.PHP_EOL.nl2br(stripslashes($v)).PHP_EOL.PHP_EOL;
		}
		$message.='</pre>'.PHP_EOL.'Pour contacter cette personne, vous pouvez directement répondre à ce message.';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'Reply-To: '.$nom.' <'.$contact['email'].'>' . "\r\n";

		if(wp_mail($to, $subject, $message, $headers)) {
		// me($to, $subject, $message, $headers);
			$etat='ok';
		}
	}
	wp_redirect('/devenez-fournisseur-partenaire?envoi='.$etat.'#form');
	exit;


}
$envoi = check('envoi');
get_header(); ?>
<div class="row column-content page-page page-members">
	<div class="col-md-9 col-sm-8 column-main">

		<section class="article">
			<?php while (have_posts()): the_post(); ?>
				<article>
					<h1 class="title"><?php echo get_the_title(); ?></h1>

					<div class="content"><?php 

					echo wpautop($post->post_content, true );

					?></div>
				<?php endwhile; ?>

				<br>
				<a name="form"></a>
				<form method="post">
					<h2 class="title">Vous voulez en savoir plus sur notre programme de fournisseurs partenaires ?</h2>
					<p>Remplissez le formulaire ci-dessous et nous vous contacterons dans les meilleurs délais</p>
					<?php if($envoi == 'ok') {?>
						<p style="color:green"><b>Votre message a été envoyé. Nous allons vous recontacter très prochainement.</b></p>
					<?php } else if($envoi == 'ko') {?>
						<p><b style="color:red">Impossible d'envoyer votre message à l'heure actuelle.</b>
							Nous vous invitions à nous contactez par téléphone au 04 73 61 95 57 ou par e-mail à <a href="mailto:info@devicemed.fr"><u>info@devicemed.fr</u></a> !
						</p>
					<?php }?>
					<div class="form-fieldset">
						<br><br>
						<div class="title22">Vos informations</div>
						<div class="form-row">
							<div class="form-field"><input type="text" name="contact[nom]" placeholder="Nom complet *" required></div>
						</div>
						<div class="form-row">
							<div class="form-field"><input type="text" name="contact[societe]" placeholder="Société"></div>
						</div>
						<div class="form-row">
							<div class="form-field"><input type="email" name="contact[email]" placeholder="Adresse mail *" required></div>
						</div>
						<div class="form-row">
							<div class="form-field"><input type="text" name="contact[telephone]" placeholder="Numéro de téléphone"></div>
						</div>
						<br><br>
						<div class="title22">Votre message</div>
						<div class="form-row">
							<div class="form-field"><textarea width="100%" name="contact[message]"></textarea></div>
						</div>

						<br><br>
						<div class="form-row">
							<div class="form-field"><input type="submit" value="Soumettre la demande de contact"></div>
						</div><br>
						<small>Les champs marqués d'une astérisque* sont requis</small>
					</div>
				</form>
				<br><br>
				<p>Vous pouvez aussi nous contacter par téléphone au 04 73 61 95 57 ou par e-mail à <a href="mailto:info@devicemed.fr"><u>info@devicemed.fr</u></a> !
				</article>
			</section>
		</div>
		<?php get_footer(); ?>