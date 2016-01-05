<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
		<section class="new-newsletter">
			<h2 class="title">Accusé de réception de demande d’inscription</h2>
			<form method="post">
				<input type="hidden" name="action" value="create" />
				<?php if (!empty($errors['general'])): ?><div class='error-general'><?php echo $errors['general']; ?></div><?php endif; ?>
				<?php if (!empty($success['general'])): ?><div class='success-general'><?php echo $success['general']; ?></div><?php endif; ?>
				<?php if(!empty($success['general'])) { ?>
					<div class="form-row">
						<div class="form-submit"><a href='/'><div class='lien_accueil_abonnement'>Retour à la page d'accueil</div></a></div>
					</div>
				<?php } ?>
			</form>
		</section>
	</div><!-- .column-main -->
<?php get_footer(); ?>