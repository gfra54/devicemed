<?php
/*
Template Name: nouveau-fournisseur
*/
if(check('action') == 'create') {
	$data = $_POST;
	$errors = array();
	if (!$data['nom_societe'])
	{
		$errors['nom_societe'] = 'Veuillez indiquer le nom de votre société.';
	}
	
	if (!$data['adresse'])
	{
		$errors['adresse'] = 'Veuillez indiquer l\'adresse de votre société.';
	}
	
	if (!$data['code_postal'])
	{
		$errors['code_postal'] = 'Veuillez indiquer le code postal de votre société.';
	}
	
	if (!$data['ville'])
	{
		$errors['ville'] = 'Veuillez indiquer la ville de votre société.';
	}
	
	if (!$data['pays'])
	{
		$errors['pays'] = 'Veuillez indiquer le pays de votre société.';
	}
	
	if (!$data['nom'])
	{
		$errors['nom'] = 'Veuillez indiquer votre nom.';
	}
	
	if (!$data['prenom'])
	{
		$errors['prenom'] = 'Veuillez indiquer votre prénom.';
	}

	if (!$data['supplier_contact_tel'])
	{
		$errors['supplier_contact_tel'] = 'Veuillez indiquer le numéro de téléphone de la personne à contacter.';
	}
	
	if (!$data['supplier_contact_nom'])
	{
		$errors['supplier_contact_nom'] = "Veuillez indiquer le nom d'une personne à contacter.";
	}
	
	if(!$data['email']) {
		$errors['email'] = 'Veuillez indiquer votre adresse mail.';
	}elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Veuillez indiquer une adresse mail valide.';
	}
	
	if(!$data['supplier_contact_mail']) {
		$errors['supplier_contact_mail'] = "Veuillez indiquer l'adresse mail de la personne à contacter.";
	}elseif(!filter_var($data['supplier_contact_mail'], FILTER_VALIDATE_EMAIL)) {
		$errors['supplier_contact_mail'] = 'Veuillez indiquer une adresse mail valide.';
	}		

	if(!count($errors)) {
		if($id_fournisseur = new_fournisseur(array(
			'nom_societe'=>check('nom_societe'),
			'content'=>'',
			'nom_contact_commercial'=>check('nom').' '.check('prenom'),
			'mail_contact_commercial'=>check('email'),
			'adresse'=>check('adresse'),
			'code_postal'=>check('code_postal'),
			'ville'=>check('ville'),
			'pays'=>check('pays'),
			'site_web'=>check('site_web'),
			'supplier_contact_nom'=>check('supplier_contact_nom'),
			'supplier_contact_tel'=>check('supplier_contact_tel'),
			'supplier_contact_mail'=>check('supplier_contact_mail'),
			'email'=>check('email'),
			'optin'=>check('contact_fiche_complete')
		),check('categories'))) {
			wp_redirect('/nouveau-fournisseur?id_fournisseur='.$id_fournisseur);
			exit;
		}
	}
}
get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
<?php if(check('id_fournisseur')) {

	?>
	<section>
		<h2 class="title">Action effectuée</h2>
		<p>Merci d'avoir ajouté ce nouveau fournisseur. L'équipe DeviceMed va vous recontacter très prochainement pour mettre en ligne la fiche correspondante dans le répertoire.</p>
		<a href="/" class="link">Retourner à l'accueil du site</a>
	</section>
<?php } else {?>

<script type='text/javascript'>
	$(document).ready(function() {
		$(".title_sous_menu_checkbox").click(function() {
			var id = $(this).attr("id");
			id = id.replace("title_","");

			if($("#sous_menu_"+ id).is(":hidden")) {
				$(".sous_menu_checkbox").hide();
				$("#sous_menu_"+ id).show();
			}else {
				$("#sous_menu_"+ id).hide();
			}
		});
		
		$(".form-field input[type='text']").click(function() {
			var valInput = $(this).val();
			
			if(valInput == 'Nom de votre société *' || valInput == 'Adresse *' || valInput == 'Code postal *' || valInput == 'Ville *' || valInput == 'Pays *' || valInput == 'Site web *' || valInput == 'Nom *' || valInput == 'Téléphone *' || valInput == 'Email *' || valInput == 'Votre nom *' || valInput == 'Votre prénom *' || valInput == 'Email *') {
				$(this).val('');
			}
		});
		
		$(".form-field input[type='text']").focusout(function() {
			var valInput = $(this).val();
			
			if(valInput == '') {
				var nameInput = $(this).attr("name");
				
				switch(nameInput) {
					case "nom_societe":
						$(this).val("Nom de votre société *");
						break;
					case "adresse":
						$(this).val("Adresse *");
						break;
					case "code_postal":
						$(this).val("Code postal *");
						break;
					case "ville":
						$(this).val("Ville *");
						break;
					case "pays":
						$(this).val("Pays *");
						break;
					case "site_web":
						$(this).val("Site Web *");
						break;
					case "supplier_contact_nom":
						$(this).val("Nom *");
						break;
					case "supplier_contact_tel":
						$(this).val("Téléphone *");
						break;
					case "supplier_contact_mail":
						$(this).val("Email *");
						break;
					case "nom":
						$(this).val("Votre nom *");
						break;
					case "prenom":
						$(this).val("Votre prénom *");
						break;
					case "email":
						$(this).val("Email *");
						break;
				}
			}
		});
	});
</script>
	<section class="new-newsletter">
		<h2 class="title">Figurer dans le répertoire</h2>
		<form method="post">
			<?php if (empty($success['general'])): ?>
				<p>Pour être référencé gratuitement parmi les fournisseurs de fabricants de dispositifs médicaux, dans ce répertoire mais aussi dans le <span id='bloc_guide_acheteur'>Guide de l'acheteur</span>, merci de remplir ce formulaire :</p>
				<input type="hidden" name="action" value="create" />
			<?php endif; ?>
			<?php if (!empty($errors['general'])): ?><div class='error-general'><?php echo $errors['general']; ?></div><div class="title5" id="retour_fournisseurs2"><a href="/suppliers/">Retour à la page de recherche d'un fournisseur</a></div><?php endif; ?>
			<?php if (!empty($success['general'])): ?><div class='success-general'><?php echo $success['general']; ?></div><div class="title5" id="retour_fournisseurs2"><a href="/suppliers/">Retour à la page de recherche d'un fournisseur</a></div><?php endif; ?>
			<?php if (empty($success['general'])): ?>
				<div class="form-fieldset">
					<div class="form-row">
						<?php if(esc_attr($data['nom_societe']) !== '') { ?>
							<div class="form-field"><input id="nom-societe" type="text" name="nom_societe" value="<?php echo esc_attr($data['nom_societe']); ?>" placeholder="Nom de votre société *" /></div>
							<div class="form-message"><?php if (!empty($errors['nom_societe'])): ?><div class="form-error"><?php echo $errors['nom_societe']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="nom-societe" type="text" name="nom_societe" value="Nom de votre société *" /></div>
							<div class="form-message"><?php if (!empty($errors['nom_societe'])): ?><div class="form-error"><?php echo $errors['nom_societe']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['adresse']) !== '') { ?>
							<div class="form-field"><input id="adresse" type="text" name="adresse" value="<?php echo esc_attr($data['adresse']); ?>" placeholder="Adresse *" /></div>
							<div class="form-message"><?php if (!empty($errors['adresse'])): ?><div class="form-error"><?php echo $errors['adresse']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="adresse" type="text" name="adresse" value="Adresse *" /></div>
							<div class="form-message"><?php if (!empty($errors['adresse'])): ?><div class="form-error"><?php echo $errors['adresse']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['code_postal']) !== '') { ?>
							<div class="form-field"><input id="code_postal" type="text" name="code_postal" value="<?php echo esc_attr($data['code_postal']); ?>" placeholder="Code postal *" /></div>
							<div class="form-message"><?php if (!empty($errors['code_postal'])): ?><div class="form-error"><?php echo $errors['code_postal']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="code_postal" type="text" name="code_postal" value="Code postal *" /></div>
							<div class="form-message"><?php if (!empty($errors['code_postal'])): ?><div class="form-error"><?php echo $errors['code_postal']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['ville']) !== '') { ?>
							<div class="form-field"><input id="ville" type="text" name="ville" value="<?php echo esc_attr($data['ville']); ?>" placeholder="Ville *" /></div>
							<div class="form-message"><?php if (!empty($errors['ville'])): ?><div class="form-error"><?php echo $errors['ville']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="ville" type="text" name="ville" value="Ville *" /></div>
							<div class="form-message"><?php if (!empty($errors['ville'])): ?><div class="form-error"><?php echo $errors['ville']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['pays']) !== '') { ?>
							<div class="form-field"><input id="pays" type="text" name="pays" value="<?php echo esc_attr($data['pays']); ?>" placeholder="Pays *" /></div>
							<div class="form-message"><?php if (!empty($errors['pays'])): ?><div class="form-error"><?php echo $errors['pays']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="pays" type="text" name="pays" value="Pays *" /></div>
							<div class="form-message"><?php if (!empty($errors['pays'])): ?><div class="form-error"><?php echo $errors['pays']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['site_web']) !== '') { ?>
							<div class="form-field"><input id="site_web" type="text" name="site_web" value="<?php echo esc_attr($data['site_web']); ?>" placeholder="Site web *" /></div>
							<div class="form-message"><?php if (!empty($errors['site_web'])): ?><div class="form-error"><?php echo $errors['site_web']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="site_web" type="text" name="site_web" value="Site web *" /></div>
							<div class="form-message"><?php if (!empty($errors['site_web'])): ?><div class="form-error"><?php echo $errors['site_web']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<br /><div class='title22'>Contact à afficher :</div></p>
					<div class="form-row">
						<?php if(esc_attr($data['supplier_contact_nom']) !== '') { ?>
							<div class="form-field"><input id="supplier_contact_nom" type="text" name="supplier_contact_nom" value="<?php echo esc_attr($data['supplier_contact_nom']); ?>" placeholder="Nom *" /></div>
							<div class="form-message"><?php if (!empty($errors['supplier_contact_nom'])): ?><div class="form-error"><?php echo $errors['supplier_contact_nom']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="supplier_contact_nom" type="text" name="supplier_contact_nom" value="Nom *" /></div>
							<div class="form-message"><?php if (!empty($errors['supplier_contact_nom'])): ?><div class="form-error"><?php echo $errors['supplier_contact_nom']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['supplier_contact_tel']) !== '') { ?>
							<div class="form-field"><input id="supplier_contact_tel" type="text" name="supplier_contact_tel" value="<?php echo esc_attr($data['supplier_contact_tel']); ?>" placeholder="Téléphone *" /></div>
							<div class="form-message"><?php if (!empty($errors['supplier_contact_tel'])): ?><div class="form-error"><?php echo $errors['supplier_contact_tel']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="supplier_contact_tel" type="text" name="supplier_contact_tel" value="Téléphone *" /></div>
							<div class="form-message"><?php if (!empty($errors['supplier_contact_tel'])): ?><div class="form-error"><?php echo $errors['supplier_contact_tel']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['supplier_contact_mail']) !== '') { ?>
							<div class="form-field"><input id="supplier_contact_mail" type="text" name="supplier_contact_mail" value="<?php echo esc_attr($data['supplier_contact_mail']); ?>" placeholder="Email *" /></div>
							<div class="form-message"><?php if (!empty($errors['supplier_contact_mail'])): ?><div class="form-error"><?php echo $errors['supplier_contact_mail']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="supplier_contact_mail" type="text" name="supplier_contact_mail" value="Email *" /></div>
							<div class="form-message"><?php if (!empty($errors['supplier_contact_mail'])): ?><div class="form-error"><?php echo $errors['supplier_contact_mail']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div><br />
					<div class='categorie_inscription_fournisseur'><h2 class='title2'>Catégories et sous-catégories</h2></div>
					<p>Veuillez cliquer sur une catégorie, pour faire apparaître les sous-catégories, et cocher celles qui vous concernent.</p>
					<p style='color:red;'>Attention : ne rien cocher dans les catégories où vous êtes uniquement utilisateur (éviter par exemple de remplir la catégorie « Salles propres » si vous êtes plasturgiste utilisateur d’une salle propre).</p>
					<div id='bloc_categories_fournisseurs'>
						<?php
							$categories = fournisseur_categories();
							fournisseurs_filtre_categories($categories,1,true,check('categories'));

						?>
					</div>
					<br /><br /><div class='title22'>Pour faciliter nos échanges, merci de préciser :</div></p>
					<div class="form-row">
						<?php if(esc_attr($data['nom']) !== '') { ?>
							<div class="form-field"><input id="nom" type="text" name="nom" value="<?php echo esc_attr($data['nom']); ?>" placeholder="Votre nom *" /></div>
							<div class="form-message"><?php if (!empty($errors['nom'])): ?><div class="form-error"><?php echo $errors['nom']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="nom" type="text" name="nom" value="Votre nom *" /></div>
							<div class="form-message"><?php if (!empty($errors['nom'])): ?><div class="form-error"><?php echo $errors['nom']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['prenom']) !== '') { ?>
							<div class="form-field"><input id="prenom" type="text" name="prenom" value="<?php echo esc_attr($data['prenom']); ?>" placeholder="Votre prénom *" /></div>
							<div class="form-message"><?php if (!empty($errors['prenom'])): ?><div class="form-error"><?php echo $errors['prenom']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="prenom" type="text" name="prenom" value="Votre prénom *" /></div>
							<div class="form-message"><?php if (!empty($errors['prenom'])): ?><div class="form-error"><?php echo $errors['prenom']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div>
					<div class="form-row">
						<?php if(esc_attr($data['email']) !== '') { ?>
							<div class="form-field"><input id="email" type="text" name="email" value="<?php echo esc_attr($data['email']); ?>" placeholder="Email *" /></div>
							<div class="form-message"><?php if (!empty($errors['email'])): ?><div class="form-error"><?php echo $errors['email']; ?></div><?php endif; ?></div>
						<?php }else { ?>
							<div class="form-field"><input id="email" type="text" name="email" value="Email *" /></div>
							<div class="form-message"><?php if (!empty($errors['email'])): ?><div class="form-error"><?php echo $errors['email']; ?></div><?php endif; ?></div>
						<?php } ?>
					</div><br />
					<?php if (!empty($errors['categories'])): ?><div class="form-error"><?php echo $errors['categories']; ?></div><?php endif; ?>
					<div class="form-row">
						<?php if(esc_attr($data['contact_fiche_complete']) == 1) { ?>
							<div class="form-field" id="contact_fiche_complete"><input id="nom-societe" type="checkbox" name="contact_fiche_complete" value="1" checked />Je souhaite être contacté pour compléter mon profil (description de la société,
articles, photos, vidéos, présence à des événements, documentation PDF…)</div>
						<?php }else { ?>
							<div class="form-field" id="contact_fiche_complete"><label><input id="nom-societe" type="checkbox" name="contact_fiche_complete" value="1" />Je souhaite être contacté pour compléter mon profil (description de la société,
articles, photos, vidéos, présence à des événements, documentation PDF…)</label></div>
						<?php } ?>
					</div>
					<?php if($success['general'] == '') { ?>
						<div class="form-row">
							<div class="form-submit" id="inscription_fournisseurs"><input type="submit" value="Soumettre la demande d’inscription" /></div>
						</div>
					<?php } ?>
				</div>
			<?php endif; ?>
		</form>
	</section>
<?php }?>
	</div><!-- .column-main -->
<?php 

get_footer(); ?>
