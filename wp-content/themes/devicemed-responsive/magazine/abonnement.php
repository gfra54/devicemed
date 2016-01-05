<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="new-newsletter">
		<h2 class="title">Abonnement au magazine</h2>
		<?php if($success['general'] == '') { ?>
			<?php if (!empty($errors['general'])): ?><div class='error-general'><?php echo $errors['general']; ?></div><?php endif; ?>
			<?php if (!empty($success['general'])): ?><div class='success-general'><?php echo $success['general']; ?></div><?php endif; ?>
			<p class='texte_magazine'>Après validation de votre abonnement, vous recevrez le dernier numéro gratuitement.</p>
			<p class='texte_magazine'><b>Attention :</b> si vous souhaitez prolonger votre abonnement gratuit aux numéros suivants, il vous sera nécessaire de remplir le formulaire d'abonnement inclus dans le numéro que vous allez recevoir.</p>
			<br />
			<h3 class="title42">Vos coordonnées (tous les champs sont obligatoires) :</h3>
			<form method="post">
				<input type="hidden" name="action" value="create" />
				<div class="form-fieldset">
					<div class="form-row">
						<div class="form-field"><input id="create-newsletter" type="text" name="nom" value="<?php echo esc_attr($data['nom']); ?>" placeholder="Nom *" /></div>
						<div class="form-message"><?php if (!empty($errors['nom'])): ?><div class="form-error"><?php echo $errors['nom']; ?></div><?php endif; ?></div>
					</div>
					<div class="form-row">
						<div class="form-field"><input id="create-newsletter" type="text" name="prenom" value="<?php echo esc_attr($data['prenom']); ?>" placeholder="Prénom *" /></div>
						<div class="form-message"><?php if (!empty($errors['prenom'])): ?><div class="form-error"><?php echo $errors['prenom']; ?></div><?php endif; ?></div>
					</div>
					<div class="form-row">
						<div class="form-field"><input id="create-newsletter" type="text" name="email" value="<?php echo esc_attr($data['email']); ?>" placeholder="Email *" /></div>
						<div class="form-message"><?php if (!empty($errors['email'])): ?><div class="form-error"><?php echo $errors['email']; ?></div><?php endif; ?></div>
					</div>
					<div class="form-row">
						<div class="form-field"><input id="create-newsletter" type="text" name="societe" value="<?php echo esc_attr($data['societe']); ?>" placeholder="Société *" /></div>
						<div class="form-message"><?php if (!empty($errors['societe'])): ?><div class="form-error"><?php echo $errors['societe']; ?></div><?php endif; ?></div>
					</div>
					<div class="form-row">
						<div class="form-field"><input id="create-newsletter" type="text" name="adresse" value="<?php echo esc_attr($data['adresse']); ?>" placeholder="Adresse *" /></div>
						<div class="form-message"><?php if (!empty($errors['adresse'])): ?><div class="form-error"><?php echo $errors['adresse']; ?></div><?php endif; ?></div>
					</div>
					<div class="form-row">
						<div class="form-field"><input id="create-newsletter" type="text" name="code_postal" value="<?php echo esc_attr($data['code_postal']); ?>" placeholder="Code postal *" /></div>
						<div class="form-message"><?php if (!empty($errors['code_postal'])): ?><div class="form-error"><?php echo $errors['code_postal']; ?></div><?php endif; ?></div>
					</div>
					<div class="form-row">
						<div class="form-field"><input id="create-newsletter" type="text" name="ville" value="<?php echo esc_attr($data['ville']); ?>" placeholder="Ville *" /></div>
						<div class="form-message"><?php if (!empty($errors['ville'])): ?><div class="form-error"><?php echo $errors['ville']; ?></div><?php endif; ?></div>
					</div>
					<?php if($success['general'] == '') { ?>
						<div class="form-row">
							<div class="form-submit input_sabonner_magazine"><input type="submit" value="S'abonner" /></div>
						</div>
					<?php } ?>
				</div>
			</form>
		<?php }else { ?>
			<p class='texte_magazine'>Votre demande d'abonnement a été prise en compte. Vous recevrez le dernier numéro gratuitement dès que possible.</p>
			<p class='texte_magazine'><b>Rappel :</b> si vous souhaitez prolonger votre abonnement gratuit aux numéros suivants, il vous sera nécessaire de remplir le formulaire d'abonnement inclus dans le numéro que vous allez recevoir.</p>
			<p class='texte_magazine'>Bonne lecture !</p>
			<div id='bt_retour_magazine'><a href='/'>Retour à la page d'accueil</a></div>
		<?php } ?>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>