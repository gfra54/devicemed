<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="new-newsletter">
		<h2 class="title">S'abonner à la newsletter</h2>
		<form method="post">
			<input type="hidden" name="action" value="create" />
			<?php if (!empty($errors['general'])): ?><div class='error-general'><?php echo $errors['general']; ?></div><?php endif; ?>
			<?php if (!empty($success['general'])): ?><div class='success-general'><?php echo $success['general']; ?></div><?php endif; ?>
			<div class="form-fieldset">
				<div class="form-row">
					<div class="form-label"><label for="create-newsletter">Votre nom</label></div>
					<div class="form-field"><input id="create-newsletter" type="text" name="nom_newsletter" value="<?php echo esc_attr($data['nom_newsletter']); ?>" placeholder="Nom" /></div>
					<div class="form-message"><?php if (!empty($errors['nom_newsletter'])): ?><div class="form-error"><?php echo $errors['nom_newsletter']; ?></div><?php endif; ?></div>
				</div>
				<div class="form-row">
					<div class="form-label"><label for="create-newsletter">Votre prénom</label></div>
					<div class="form-field"><input id="create-newsletter" type="text" name="prenom_newsletter" value="<?php echo esc_attr($data['prenom_newsletter']); ?>" placeholder="Prénom" /></div>
					<div class="form-message"><?php if (!empty($errors['prenom_newsletter'])): ?><div class="form-error"><?php echo $errors['prenom_newsletter']; ?></div><?php endif; ?></div>
				</div>
				<div class="form-row">
					<div class="form-label"><label for="create-newsletter">Votre ville</label></div>
					<div class="form-field"><input id="create-newsletter" type="text" name="ville_newsletter" value="<?php echo esc_attr($data['ville_newsletter']); ?>" placeholder="Ville" /></div>
					<div class="form-message"><?php if (!empty($errors['ville_newsletter'])): ?><div class="form-error"><?php echo $errors['ville_newsletter']; ?></div><?php endif; ?></div>
				</div>
				<div class="form-row">
					<div class="form-label"><label for="create-newsletter">Votre code postal</label></div>
					<div class="form-field"><input id="create-newsletter" type="text" name="cp_newsletter" value="<?php echo esc_attr($data['cp_newsletter']); ?>" placeholder="Code postal" /></div>
					<div class="form-message"><?php if (!empty($errors['cp_newsletter'])): ?><div class="form-error"><?php echo $errors['cp_newsletter']; ?></div><?php endif; ?></div>
				</div>
				<?php if(empty($success['general'])) { ?>
					<div class="form-row">
						<div class="form-submit"><input type="submit" value="Finaliser l'abonnement à la newsletter" /></div>
					</div>
				<?php }else { ?>
					<div class="form-row">
						<div class="form-submit"><a href='http://www.devicemed.fr/'><div class='lien_accueil_abonnement'>Retour à la page d'accueil</div></a></div>
					</div>
				<?php } ?>
			</div>
		</form>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>