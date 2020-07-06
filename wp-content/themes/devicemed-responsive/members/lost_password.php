<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="login">
		<h2 class="title">Mot de passe oublié ?</h2>
		<p>Veuillez renseigner votre adresse mail, pour recevoir le lien de récupération du mot de passe.</p>
		<form method='POST' action='' name='form_lost_mdp_user'>
			<input type='text' name='mail_user' placeHolder='Adresse mail' value='<?php echo $_POST['mail_user']; ?>' />
			<input type='submit' value='Réinitialiser votre mot de passe' />
		</form><br />
		<?php
			// On exécute le formulaire
			if(!empty($_POST)) {
				$mailUser = $_POST['mail_user'];

				if($mailUser != '') {
					$key = md5(mt_rand());

					$sqlMailUser = "SELECT * FROM wordpress_dm_users WHERE user_email='$mailUser'";
					$resultMailUser = mysql_query($sqlMailUser);
					$nbMailUser = mysql_num_rows($resultMailUser);

					$sqlMailUserSupplier = "SELECT * FROM wordpress_dm_suppliers_users WHERE supplier_user_email='$mailUser'";
					$resultMailUserSupplier = mysql_query($sqlMailUserSupplier);
					$nbMailUserSupplier = mysql_num_rows($resultMailUserSupplier);

					if($nbMailUser > 0 || $nbMailUserSupplier > 0) {
						if($nbMailUser > 0) {
							$sqlUpdateUser = "UPDATE wordpress_dm_users SET user_lostpassword_key='$key' WHERE user_email='$mailUser'";
							$resultUpdateUser = mysql_query($sqlUpdateUser);

							if($resultUpdateUser !== FALSE) {
								$to      = $mailUser;
								$subject = 'DeviceMed.fr - Mot de passe oublié';
								$subject = mb_encode_mimeheader($subject, "UTF-8");
								$message = 'Bonjour ! Vous avez oublié votre mot de passe ?<br /><a href="'.site_url('/members/lost_password/'.$key).'">Veuillez cliquer sur ce lien afin de le réinitialiser.</a>';
								$message .= "<br /><br />Bien cordialement,<br />";
								$message .= "L'équipe de DeviceMed France";
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
								$headers .= "From: \"DeviceMed France\"<info@devicemed.fr>";

								if (mail($to, $subject, $message, $headers)) {
									echo "<div class='success-general'>Votre demande a été prise en compte. Vous allez recevoir un mail pour réinitialiser votre mot de passe.</div>";
								}
							}
						}elseif($nbMailUserSupplier > 0) {
							$sqlUpdateUser = "UPDATE wordpress_dm_suppliers_users SET supplier_user_lostpassword_key='$key' WHERE supplier_user_email='$mailUser'";
							$resultUpdateUser = mysql_query($sqlUpdateUser);

							if($resultUpdateUser !== FALSE) {
								$to      = $mailUser;
								$subject = 'DeviceMed.fr - Mot de passe oublié';
								$subject = mb_encode_mimeheader($subject, "UTF-8");
								$message = 'Bonjour ! Vous avez oublié votre mot de passe.<br /><a href="'.site_url('/members/lost_password/'.$key).'">Veuillez cliquer sur ce lien afin de le réinitialiser.</a>';
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
								$headers .= "From: \"DeviceMed France\"<info@devicemed.fr>";

								if (mail($to, $subject, $message, $headers)) {
									echo "<div class='success-general'>Votre demande a été prise en compte. <br />Vous allez recevoir un email pour réinitialiser votre mot de passe.</div>";
								}
							}
						}
					}else {
						echo "<div class='error-general'>Cette adresse mail n'existe pas.</div>";
					}
				}else {
					echo "<div class='error-general'>Veuillez renseigner une adresse mail.</div>";
				}
			}
		?>
	</section>
	</div><!-- .column-main -->
<?php get_footer(); ?>