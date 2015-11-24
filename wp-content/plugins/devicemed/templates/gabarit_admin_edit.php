<?php 
	if(isset($_GET['dynamique']) && $_GET['dynamique'] == 1) {
		$dynamique = 1;
	}else {
		$dynamique = 0;
	}
	
	$contenuGabarit = stripslashes(html_entity_decode($data['contenu_gabarit'])); 
	$contenuPub = stripslashes(html_entity_decode($data['contenu_pub'])); 
?>
<div class="wrap page-suppliers-products page-suppliers-products-edit">

<h2>
	<?php 
		if($dynamique != 1) {
			echo esc_html($page->page_title()); 
		}else {
			echo "Gabarit Dynamique";
		}
	?>
	<?php if ($data['ID']): ?>
		<?php if($dynamique == 1) { ?>
			<a href="<?php echo home_url().'/newsletter/previsualiser/'. $data['ID'] .'&dynamique=1'; ?>" target='_blank' class="add-new-h2">Prévisualiser</a>
			<a href="?page=devicemed-gabarit-edit&gabarit_id=<?php echo $data['ID']; ?>&action=envoyerDynamique&mail=<?php echo $data['mail_test']; ?>&dynamique=1" class="add-new-h2">Envoi test</a>
			<a href="?page=devicemed-gabarit-edit&gabarit_id=<?php echo $data['ID']; ?>&action=envoyerDynamique&dynamique=1" class="add-new-h2">Envoyer la newsletter</a>
		<?php }else { ?>
			<a href="<?php echo home_url().'/newsletter/previsualiser/'. $data['ID']; ?>" target='_blank' class="add-new-h2">Prévisualiser</a>
			<a href="?page=devicemed-gabarit-edit&gabarit_id=<?php echo $data['ID']; ?>&action=envoyer&mail=<?php echo $data['mail_test']; ?>" class="add-new-h2">Envoi test</a>
			<a href="?page=devicemed-gabarit-edit&gabarit_id=<?php echo $data['ID']; ?>&action=envoyer" class="add-new-h2">Envoyer la newsletter</a>
		<?php } ?>
	<?php endif; ?>
</h2>

<form method="post" enctype="multipart/form-data">

<table class="form-table">
	<tbody>
		<?php if ($success['general']): ?><tr><td><span class="description error"><?php echo $success['general']; ?></span></td></tr><?php endif; ?>
		<?php if ($errors['general']): ?><tr><td><span class="description error"><?php echo $errors['general']; ?></span></td></tr><?php endif; ?>
		<tr>
			<th scope="row">Titre de la newsletter <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="nom_gabarit" value="<?php echo esc_attr($data['nom_gabarit']); ?>" class="regular-text" />
				<?php if ($errors['nom_gabarit']): ?><span class="description error"><?php echo $errors['nom_gabarit']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Mail de test <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="mail_test" value="<?php echo esc_attr($data['mail_test']); ?>" class="regular-text" />
				<?php if ($errors['mail_test']): ?><span class="description error"><?php echo $errors['mail_test']; ?></span><?php endif; ?>
			</td>
		</tr>
		<?php if($dynamique != 1) { ?>
			<tr>
				<th scope="row">Contenu <span class="description">(obligatoire)</span></th>
				<td>
					<textarea class="editable" name="contenu_gabarit" cols="100" rows="20"><?php echo $contenuGabarit; ?></textarea>
					<?php if ($errors['contenu_gabarit']): ?><span class="description error"><?php echo $errors['contenu_gabarit']; ?></span><?php endif; ?>
				</td>
			</tr>
		<?php }else { ?>
			<tr>
				<th scope="row">Nom pub</th>
				<td>
					<input type="text" name="nom_pub" value="<?php echo esc_attr($data['nom_pub']); ?>" class="regular-text" />
					<?php if ($errors['nom_pub']): ?><span class="description error"><?php echo $errors['nom_pub']; ?></span><?php endif; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">Nom entreprise pub</th>
				<td>
					<input type="text" name="nom_entreprise_pub" value="<?php echo esc_attr($data['nom_entreprise_pub']); ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row">Lien de la pub</th>
				<td>
					<input type="text" name="lien_pub" value="<?php echo esc_attr($data['lien_pub']); ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th scope="row">Image pub</th>
				<td>
					<?php
						if($data['image_pub'] != '') {
							echo "<img src='http://device-med.fr/wp-content/uploads/newsletter/". $data['image_pub'] ."' width='100px' />";
						}
					?>
					<input type='file' name='image_pub' />
				</td>
			</tr>
			<tr>
				<th scope="row">Contenu pub</th>
				<td>
					<textarea class="editable" name="contenu_pub" cols="100" rows="20"><?php echo $contenuPub; ?></textarea>
				</td>
			</tr>
		<?php } ?>
<?php if ($data['ID']): ?>
		<tr>
			<th scope="row">Date de création</th>
			<td><input type="text" name="date_created" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['date_created']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
		<tr>
			<th scope="row">Dernière modification</th>
			<td><input type="text" name="date_modified" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['date_modified']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
<?php endif; ?>
	</tbody>
</table>

<?php if($_GET['gabarit_id'] != '') { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour le gabarit" /></p>
<?php }else { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Ajouter le gabarit" /></p>
<?php } ?>

</form>
</div>