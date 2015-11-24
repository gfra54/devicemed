<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="login">
			<h2 class="title">Espace abonnés</h2>
			<form method="post">
			<input type="hidden" name="action" value="login" />
			<div class="form-fieldset">
				<div class="form-row">
					<div class="form-label"><label for="login-email">email</label></div>
					<div class="form-field"><input id="login-email" type="text" name="user_login" value="<?php echo esc_attr($data['user_login']); ?>" placeholder="email" /></div>
					<div class="form-message"><?php if (!empty($errors['user_login'])): ?><div class="form-error"><?php echo $errors['user_login']; ?></div><?php endif; ?></div>
				</div>
				<div class="form-row">
					<div class="form-label"><label for="login-password">Mot de passe</label></div>
					<div class="form-field"><input id="login-password" type="password" name="user_password" value="<?php echo esc_attr($data['user_password']); ?>" placeholder="Mot de passe" /></div>
					<div class="form-message"><?php if (!empty($errors['user_password'])): ?><div class="form-error"><?php echo $errors['user_password']; ?></div><?php endif; ?></div>
				</div>
				<div class="form-row">
					<div class="form-submit"><input type="submit" value="Se connecter" /></div>
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
					<div class="form-label"><label for="create-email">Votre adresse email</label></div>
					<div class="form-field"><input id="create-email" type="text" name="create_e-mail" value="<?php echo esc_attr($data['create_e-mail']); ?>" placeholder="email" /></div>
					<div class="form-message"><?php if (!empty($errors['create_e-mail'])): ?><div class="form-error"><?php echo $errors['create_e-mail']; ?></div><?php endif; ?></div>
				</div>
				<div class="form-row">
					<div class="form-submit"><input type="submit" value="S'enregistrer" /></div>
				</div>
			</div>
		</form>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>