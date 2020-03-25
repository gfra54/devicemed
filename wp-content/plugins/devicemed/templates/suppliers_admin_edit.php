<?php
	$supplier_id = $data['supplier_id'];
	$chemin_destination = '../wp-content/uploads/logo_suppliers/';

	if(isset($_FILES['supplier_logo'])) {
		if ($_FILES['supplier_logo']['error']) {     
			switch ($_FILES['supplier_logo']['error']){     
			   case 1: // UPLOAD_ERR_INI_SIZE     
			   echo"Le fichier dépasse la limite autorisée par le serveur !";     
			   break;     
			   case 2: // UPLOAD_ERR_FORM_SIZE     
			   echo "Le fichier dépasse la limite autorisée dans le formulaire HTML !"; 
			   break;     
			   case 3: // UPLOAD_ERR_PARTIAL     
			   echo "L'envoi du fichier a été interrompu pendant le transfert !";     
			   break;     
			   case 4: // UPLOAD_ERR_NO_FILE     
			   echo "Le fichier que vous avez envoyé a une taille nulle !"; 
			   break;     
			}     
		}else {
			if ((isset($_FILES['supplier_logo']['tmp_name'])&&($_FILES['supplier_logo']['error'] == 0))) {
				if(move_uploaded_file($_FILES['supplier_logo']['tmp_name'], $chemin_destination.$_FILES['supplier_logo']['name'])) {      
					$supplier_logo = $_FILES['supplier_logo']['name'];
					$data['supplier_logo'] = $supplier_logo;
					
					$sqlUpdateLogo = "UPDATE wordpress_dm_suppliers SET supplier_logo = '$supplier_logo' ";
					$sqlUpdateLogo .= "WHERE ID=$supplier_id;";
					$resultUpdateLogo = mysql_query($sqlUpdateLogo);
				}					
			}   
		}
	}
?>
<div class="wrap">

<h2><?php echo esc_html($page->page_title()); ?></h2>

<form method="post" enctype="multipart/form-data">
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Nom <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_name" value="<?php echo esc_attr($data['supplier_name']); ?>" class="regular-text" />
				<?php if ($errors['supplier_name']): ?><span class="description error"><?php echo $errors['supplier_name']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Logo</th>
			<td>
				<?php if($data['supplier_logo'] != '') { ?>
					<img src='http://www.devicemed.fr/wp-content/uploads/logo_suppliers/<?php echo $data['supplier_logo']; ?>' />
				<?php } ?>
				<input type="file" name="supplier_logo" id="supplier_logo" accept="image/*" />
				<?php if ($errors['supplier_logo']): ?><span class="description error"><?php echo $errors['supplier_logo']; ?></span><?php endif; ?>
			</td>
		</tr>
		<!--<tr>
			<th scope="row">Coordonnées</th>
			<td>
				<textarea name="supplier_coordonnees" rows="10" cols="40"><?php echo esc_html($data['supplier_coordonnees']); ?></textarea>
				<?php if ($errors['supplier_coordonnees']): ?><span class="description error"><?php echo $errors['supplier_coordonnees']; ?></span><?php endif; ?>
			</td>
		</tr>-->
		<tr>
			<th scope="row">Catégorie</th>
			<td>
				<div id='bloc_categories_fournisseurs'>
					<?php
						// On récupére les category parente et on créer une colonne toutes les 7 catégories
						$sqlCategorieParente = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent='0' ORDER BY supplier_category_title ASC";
						$resultCategorieParente = mysql_query($sqlCategorieParente);
						$i = 1;

						while($rowCategorieParent = mysql_fetch_array($resultCategorieParente)) {
							$idCategorieParent = $rowCategorieParent['ID'];
							$nomCategorieParent = $rowCategorieParent['supplier_category_title'];

							if($i == 1) {
								echo "<div class='colonne'>";
							}elseif($i == 8) {
								echo "</div><div class='colonne'>";
							}elseif($i == 15) {
								echo "</div><div class='colonne'>";
							}elseif($i == 19) {
								echo "</div>";
							}

							echo "<h4 class='title3 title_sous_menu_checkbox' id='title_$idCategorieParent' style='cursor:pointer'>$nomCategorieParent</h4>";

							echo "<div class='sous_menu_checkbox' id='sous_menu_$idCategorieParent' style='display:none'>";
								$category = $data['supplier_category_id'];
								$tabCategory = explode(',', $category);
								
								/*** RECUPERATION DES SOUS CATEGORIES ***/	
								// On récupére les sous catégorie de la catégorie courante
								$sqlSousCategorieId = "SELECT *	 FROM wordpress_dm_suppliers_souscategories WHERE supplier_category_parent=$idCategorieParent";
								$resultSousCategorieId = mysql_query($sqlSousCategorieId);
								$nbSousCategorieId = mysql_num_rows($resultSousCategorieId);

								if($nbSousCategorieId > 0) {
									while($rowSousCategorie = mysql_fetch_array($resultSousCategorieId)) {
										$idSousCategorie = $rowSousCategorie['ID'];
										$nomSousCategorie = $rowSousCategorie['supplier_souscategorie_name'];

										echo "<br /><div class='sous_categorie_inscription'>$nomSousCategorie</div><br />";

										// On récupére les catégories de la sous catégorie
										$sqlCategorieSupplier = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_souscategorie_parent=$idSousCategorie ORDER BY supplier_category_title";
										$resultCategorieSupplier = mysql_query($sqlCategorieSupplier);
										$nomSousCatTemp = '';

										while($rowCategorieSupplier = mysql_fetch_array($resultCategorieSupplier)) {
											$idCategorieSupplier = $rowCategorieSupplier['ID'];
											$titleCategorieSupplier = $rowCategorieSupplier['supplier_category_title'];
									
											if(in_array($idCategorieSupplier,  $tabCategory)) {
												echo "<div class='categorie_inscription' style='margin-left:20px;'><input type='checkbox' name='supplier_category_id[]' value='$idCategorieSupplier' checked><span class='intitule_checkbox_fournisseurs'>$titleCategorieSupplier</span></div>";
											}else {
												echo "<div class='categorie_inscription' style='margin-left:20px;'><input type='checkbox' name='supplier_category_id[]' value='$idCategorieSupplier'><span class='intitule_checkbox_fournisseurs'>$titleCategorieSupplier</span></div>";
											}
										}
									}
								}else {
									$sqlCategorieSupplier = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=$idCategorieParent ORDER BY supplier_category_title";
									$resultCategorieSupplier = mysql_query($sqlCategorieSupplier);
									$nomSousCatTemp = '';

									while($rowCategorieSupplier = mysql_fetch_array($resultCategorieSupplier)) {
										$idCategorieSupplier = $rowCategorieSupplier['ID'];
										$titleCategorieSupplier = $rowCategorieSupplier['supplier_category_title'];
									
										if(in_array($idCategorieSupplier,  $tabCategory)) {
											echo "<div class='categorie_inscription'><input type='checkbox' name='supplier_category_id[]' value='$idCategorieSupplier' checked><span class='intitule_checkbox_fournisseurs'>$titleCategorieSupplier</span></div>";
										}else {
											echo "<div class='categorie_inscription'><input type='checkbox' name='supplier_category_id[]' value='$idCategorieSupplier'><span class='intitule_checkbox_fournisseurs'>$titleCategorieSupplier</span></div>";
										}
									}
								}
								/*** FIN RECUPERATION SOUS CATEGORIES ***/

								/*$sqlCategorieSupplier = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=$idCategorieParent ORDER BY supplier_category_title ASC";
								$resultCategorieSupplier = mysql_query($sqlCategorieSupplier);
								
								while($rowCategorieSupplier = mysql_fetch_array($resultCategorieSupplier)) {
									$idCategorieSupplier = $rowCategorieSupplier['ID'];
									$titleCategorieSupplier = $rowCategorieSupplier['supplier_category_title'];
									
									if(in_array($idCategorieSupplier,  $tabCategory)) {
										echo "<input type='checkbox' name='categories[]' value='$idCategorieSupplier' checked><span class='intitule_checkbox_fournisseurs'>$titleCategorieSupplier</span><br />";
									}else {
										echo "<input type='checkbox' name='categories[]' value='$idCategorieSupplier'><span class='intitule_checkbox_fournisseurs'>$titleCategorieSupplier</span><br />";
									}
								}*/
							echo "</div>";

							$i++;
						}
					?>
				</div>
			</td>
		</tr>
		<!--<tr>
			<th scope="row">Adresse</th>
			<td>
				<input type="text" name="supplier_address" value="<?php echo esc_attr($data['supplier_address']); ?>" class="regular-text" />
				<?php if ($errors['supplier_address']): ?><span class="description error"><?php echo $errors['supplier_address']; ?></span><?php endif; ?>
			</td>
		</tr>-->
		<tr>
			<th scope="row">Téléphone</th>
			<td>
				<input type="text" name="supplier_telephone" value="<?php echo esc_attr($data['supplier_telephone']); ?>" class="regular-text" />
				<?php if ($errors['supplier_telephone']): ?><span class="description error"><?php echo $errors['supplier_telephone']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Adresse</th>
			<td>
				<input type="text" name="supplier_address" value="<?php echo esc_attr($data['supplier_address']); ?>" class="regular-text" />
				<?php if ($errors['supplier_address']): ?><span class="description error"><?php echo $errors['supplier_address']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Code Postal</th>
			<td>
				<input type="text" name="supplier_postalcode" value="<?php echo esc_attr($data['supplier_postalcode']); ?>" class="regular-text" />
				<?php if ($errors['supplier_postalcode']): ?><span class="description error"><?php echo $errors['supplier_postalcode']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Ville</th>
			<td>
				<input type="text" name="supplier_city" value="<?php echo esc_attr($data['supplier_city']); ?>" class="regular-text" />
				<?php if ($errors['supplier_city']): ?><span class="description error"><?php echo $errors['supplier_city']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Pays</th>
			<td>
				<input type="text" name="supplier_country" value="<?php echo esc_attr($data['supplier_country']); ?>" class="regular-text" />
				<?php if ($errors['supplier_country']): ?><span class="description error"><?php echo $errors['supplier_country']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Site internet</th>
			<td>
				<input type="text" name="supplier_website" value="<?php echo esc_attr($data['supplier_website']); ?>" class="regular-text" />
				<?php if ($errors['supplier_website']): ?><span class="description error"><?php echo $errors['supplier_website']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Blog</th>
			<td>
				<input type="text" name="supplier_social_blog" value="<?php echo esc_attr($data['supplier_social_blog']); ?>" class="regular-text" />
				<?php if ($errors['supplier_social_blog']): ?><span class="description error"><?php echo $errors['supplier_social_blog']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Facebook</th>
			<td>
				<input type="text" name="supplier_social_facebook" value="<?php echo esc_attr($data['supplier_social_facebook']); ?>" class="regular-text" />
				<?php if ($errors['supplier_social_facebook']): ?><span class="description error"><?php echo $errors['supplier_social_facebook']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Twitter</th>
			<td>
				<input type="text" name="supplier_social_twitter" value="<?php echo esc_attr($data['supplier_social_twitter']); ?>" class="regular-text" />
				<?php if ($errors['supplier_social_twitter']): ?><span class="description error"><?php echo $errors['supplier_social_twitter']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Youtube</th>
			<td>
				<input type="text" name="supplier_social_youtube" value="<?php echo esc_attr($data['supplier_social_youtube']); ?>" class="regular-text" />
				<?php if ($errors['supplier_social_youtube']): ?><span class="description error"><?php echo $errors['supplier_social_youtube']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Google+</th>
			<td>
				<input type="text" name="supplier_social_google_plus" value="<?php echo esc_attr($data['supplier_social_google_plus']); ?>" class="regular-text" />
				<?php if ($errors['supplier_social_google_plus']): ?><span class="description error"><?php echo $errors['supplier_social_google_plus']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Linkedin</th>
			<td>
				<input type="text" name="supplier_social_linkedin" value="<?php echo esc_attr($data['supplier_social_linkedin']); ?>" class="regular-text" />
				<?php if ($errors['supplier_social_linkedin']): ?><span class="description error"><?php echo $errors['supplier_social_linkedin']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Personne à contacter : </th>
			<td></td>
		</tr>
		<tr>
			<th scope="row">Nom</th>
			<td>
				<input type="text" name="supplier_contact_nom" value="<?php echo esc_attr($data['supplier_contact_nom']); ?>" class="regular-text" />
				<?php if ($errors['supplier_contact_nom']): ?><span class="description error"><?php echo $errors['supplier_contact_nom']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Téléphone</th>
			<td>
				<input type="text" name="supplier_contact_tel" value="<?php echo esc_attr($data['supplier_contact_tel']); ?>" class="regular-text" />
				<?php if ($errors['supplier_contact_tel']): ?><span class="description error"><?php echo $errors['supplier_contact_tel']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Email</th>
			<td>
				<input type="text" name="supplier_contact_mail" value="<?php echo esc_attr($data['supplier_contact_mail']); ?>" class="regular-text" />
				<?php if ($errors['supplier_contact_mail']): ?><span class="description error"><?php echo $errors['supplier_contact_mail']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">À propos</th>
			<td>
				<textarea name="supplier_about" rows="10" cols="40"><?php echo esc_html($data['supplier_about']); ?></textarea>
				<?php if ($errors['supplier_about']): ?><span class="description error"><?php echo $errors['supplier_about']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Evènements</th>
			<td>
				<textarea name="supplier_events" rows="10" cols="40"><?php echo esc_html($data['supplier_events']); ?></textarea>
				<?php if ($errors['supplier_events']): ?><span class="description error"><?php echo $errors['supplier_events']; ?></span><?php endif; ?>
			</td>
		</tr>
<?php if ($data['supplier_id']): ?>
		<tr>
			<th scope="row">Date de création</th>
			<td><input type="text" name="supplier_created" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['supplier_created']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
		<?php if($data['supplier_modified'] != '' && $data['supplier_modified'] != '0000-00-00 00:00:00') { ?>
			<tr>
				<th scope="row">Dernière modification</th>
				<td><input type="text" name="supplier_modified" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['supplier_modified']))); ?>" class="regular-text" disabled="disabled" /></td>
			</tr>
		<?php }?>
<?php endif; ?>
		<tr>
			<th scope="row">Statut</th>
			<td>
				<select name="supplier_status">
					<option value="0"<?php echo $data['supplier_status'] == '0' ? ' selected="selected"' : ''; ?>>Fournisseur désactivé</option>
					<option value="1"<?php echo $data['supplier_status'] == '1' ? ' selected="selected"' : ''; ?>>Fournisseur actif</option>
					<option value="2"<?php echo $data['supplier_status'] == '2' ? ' selected="selected"' : ''; ?>>En attente</option>
				</select><br /><br />
				<div style='color:red;'>Attention : L'activation d'un fournisseur génère l'envoi d'un email.</div>
			</td>
		</tr>
		<tr>
			<th scope="row">Compte payant</th>
			<td>
				<?php if($data['supplier_premium'] == 1) { ?>
					<input type="checkbox" name="supplier_premium" value="1" checked />
				<?php }else { ?>
					<input type="checkbox" name="supplier_premium" value="1" />
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Je souhaite être contacté pour compléter mon profil</th>
			<td>
				<?php if($data['souhait_contact'] == 1) { ?>
					<p>Oui</p>
				<?php }else { ?>
					<p>Non</p>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Contact pour compléter mon profil : </th>
			<td>
				<?php 
					$supplier_id = $data['supplier_id'];

					// On récupére l'utilisateur qui s'est inscris, et qui souhaite être contacté pour compléter son profil
					$sqlSupplierUser = "SELECT * FROM wordpress_dm_suppliers_users WHERE supplier_id=$supplier_id";
					$resultSupplierUser = mysql_query($sqlSupplierUser);

					if($rowSupplierUser = mysql_fetch_array($resultSupplierUser)) {
						$nom = $rowSupplierUser['supplier_user_lastname'];
						$prenom = $rowSupplierUser['supplier_user_firstname'];
						$email = $rowSupplierUser['supplier_user_email'];
					}

					echo "Nom : $nom<br />";
					echo "Prénom : $prenom<br />";
					echo "Email : $email<br />";
				?>
			</td>
		</tr>
	</tbody>
</table>

<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour le fournisseur" /></p>

</form>

</div>
<script src="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/js/tinymce/tinymce.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type='text/javascript'> 
	tinymce.init({
		selector:'textarea',
		plugins:'table',
		theme_advanced_buttons1: 'tablecontrols'
	});

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
	});
</script>