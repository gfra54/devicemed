<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="login">
			<h2 class="title">Connexion avec un compte existant</h2>
			<form method="post">
			<input type="hidden" name="action" value="login" />
			<input type="hidden" name="uri" value="<?php echo htmlspecialchars(check('uri'));?>" />
			<div class="form-fieldset">
				<div class="form-row">
					<div class="form-field"><input id="login-email" type="text" name="user_login" value="<?php echo esc_attr($data['user_login']); ?>" placeholder="Email" /></div>
					<div class="form-message"><?php if (!empty($errors['user_login'])): ?><div class="form-error"><?php echo $errors['user_login']; ?></div><?php endif; ?></div>
				</div>
				<div class="form-row">
					<div class="form-field"><input id="login-password" type="password" name="user_password" value="<?php echo esc_attr($data['user_password']); ?>" placeholder="Mot de passe" /></div>
					<div class="form-message"><?php if (!empty($errors['user_password'])): ?><div class="form-error"><?php echo $errors['user_password']; ?></div><?php endif; ?></div>
					<p class='mdp-oublie-login'><a href='/members/get_password'>Mot de passe oublié ?</a></p>
				</div>
				<div class="form-row">
					<input type="checkbox" name="rester_connecter" /><label class="rester_connecter">Rester connecté</span>
				</div>
				<div class="form-row">
					<div class="form-submit form_login_submit"><input type="submit" value="Se connecter" /></div>
				</div>
			</div>
			</form>
	</section>
	<section class="new-account">
		<h2 class="title">Créer un nouveau compte</h2>
		<form method="post">
			<input type="hidden" name="action" value="create" />
			<div class="form-fieldset">
				<div class="form-row">
					<div class="form-field"><input id="create-email" type="text" name="create_email" value="<?php echo esc_attr($data['create_email']); ?>" placeholder="Email" /></div>
					<div class="form-message"><?php if (!empty($success['create_email'])): ?><div class="form-success"><?php echo $success['create_email']; ?></div><?php endif; ?><?php if (!empty($errors['create_email'])): ?><div class="form-error"><?php echo $errors['create_email']; ?></div><?php endif; ?></div>
				</div>
				<div class="form-row">
					<div class="form-submit form_login_submit"><input type="submit" value="Soumettre votre enregistrement" /></div>
				</div>
			</div>
		</form>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>