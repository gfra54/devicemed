<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="new-newsletter">
		<h2 class="title">Désabonnement à la newsletter</h2>
		<form method="post" name="desinscrire_newsletter">
			<input type="hidden" name="action" value="create" />
			<?php if (!empty($errors['general'])): ?><div class='error-general'><?php echo $errors['general']; ?></div><?php endif; ?>
			<?php if (!empty($success['general'])): ?><div class='success-general'><?php echo $success['general']; ?></div><?php endif; ?>
			<div class="form-fieldset">
				<div class="form-row">
					<?php if (empty($success['general'])) { ?>
						<div class="form-field">
							<input type="checkbox" name="confirmation_desinscrire" value="1"> 
						</div>
						<div class="form-label"><label for="delete-newsletter">Je veux me désabonner de la newsletter</label></div>
						<div class="form-message"><?php if (!empty($errors['confirmation_desinscrire'])): ?><div class="form-error"><?php echo $errors['confirmation_desinscrire']; ?></div><?php endif; ?></div>
					<?php } ?>
				</div>
				<?php if (empty($success['general'])) { ?>
					<div class="form-row">
						<div class="form-submit"><input type="submit" value="Validation" /></div>
					</div>
				<?php }else { ?>
					<a href='http://www.devicemed.fr/'><div id='bt_retour_accueil_desinscription'>Retour à la page d'accueil</div></a>
				<?php } ?>
			</div>
		</form>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>