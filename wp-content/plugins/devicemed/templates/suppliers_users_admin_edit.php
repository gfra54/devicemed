<div class="wrap">

<h2><?php echo esc_html($page->page_title()); ?></h2>

<form method="post">

<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Identifiant <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_user_login" value="<?php echo esc_attr($data['supplier_user_login']); ?>" class="regular-text"<?php echo $data['supplier_user_id'] ? ' disabled="disabled"' : ''; ?> />
				<?php if ($errors['supplier_user_login']): ?><span class="description error"><?php echo $errors['supplier_user_login']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Fournisseur</th>
			<td>
				<select name="supplier_id">
					<option value="0">Aucun</option>
<?php foreach ($suppliers as $supplier_id => $supplier_name): ?>
					<option value="<?php echo esc_attr($supplier_id); ?>"<?php echo $data['supplier_id'] == $supplier_id ? ' selected="selected"' : ''; ?>"><?php echo esc_html($supplier_name); ?></option>
<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">Nom</th>
			<td>
				<input type="text" name="supplier_user_lastname" value="<?php echo esc_attr($data['supplier_user_lastname']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_lastname']): ?><span class="description error"><?php echo $errors['supplier_user_lastname']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Prénom</th>
			<td>
				<input type="text" name="supplier_user_firstname" value="<?php echo esc_attr($data['supplier_user_firstname']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_firstname']): ?><span class="description error"><?php echo $errors['supplier_user_firstname']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">E-Mail <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_user_email" value="<?php echo esc_attr($data['supplier_user_email']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_email']): ?><span class="description error"><?php echo $errors['supplier_user_email']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Sexe</th>
			<td>
				<select name="user_sex">
					<option value="M"<?php echo $data['supplier_user_sex'] == 'M' ? ' selected="selected"' : ''; ?>>Masculin</option>
					<option value="F"<?php echo $data['supplier_user_sex'] == 'F' ? ' selected="selected"' : ''; ?>>Féminin</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">Adresse</th>
			<td>
				<input type="text" name="supplier_user_address" value="<?php echo esc_attr($data['supplier_user_address']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_address']): ?><span class="description error"><?php echo $errors['supplier_user_address']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Code Postal</th>
			<td>
				<input type="text" name="supplier_user_postalcode" value="<?php echo esc_attr($data['supplier_user_postalcode']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_postalcode']): ?><span class="description error"><?php echo $errors['supplier_user_postalcode']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Ville</th>
			<td>
				<input type="text" name="supplier_user_city" value="<?php echo esc_attr($data['supplier_user_city']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_city']): ?><span class="description error"><?php echo $errors['supplier_user_city']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Pays</th>
			<td>
				<input type="text" name="supplier_user_country" value="<?php echo esc_attr($data['supplier_user_country']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_country']): ?><span class="description error"><?php echo $errors['supplier_user_country']; ?></span><?php endif; ?>
			</td>
		</tr>
<?php if ($data['supplier_user_id']): ?>
		<tr>
			<th scope="row">Date de création</th>
			<td><input type="text" name="supplier_user_created" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['supplier_user_created']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
		<tr>
			<th scope="row">Dernière modification</th>
			<td><input type="text" name="supplier_user_modified" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['supplier_user_modified']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
<?php endif; ?>
		<tr>
			<th scope="row">Statut</th>
			<td>
				<select name="supplier_user_status">
					<option value="0"<?php echo $data['supplier_user_status'] == '0' ? ' selected="selected"' : ''; ?>>Compte désactivé</option>
					<option value="1"<?php echo $data['supplier_user_status'] == '1' ? ' selected="selected"' : ''; ?>>Compte actif</option>
				</select>
			</td>
		</tr>
<?php if ($data['supplier_user_id']): ?>
		<tr>
			<th scope="row">Nouveau mot de passe</th>
			<td>
				<input type="password" name="supplier_user_new_password" value="<?php echo esc_attr($data['supplier_user_new_password']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_new_password']): ?><span class="description error"><?php echo $errors['supplier_user_new_password']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Répéter nouveau mot de passe</th>
			<td>
				<input type="password" name="supplier_user_new_password_confirm" value="<?php echo esc_attr($data['supplier_user_new_password_confirm']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_new_password_confirm']): ?><span class="description error"><?php echo $errors['supplier_user_new_password_confirm']; ?></span><?php endif; ?>
			</td>
		</tr>
<?php else: ?>
		<tr>
			<th scope="row">Mot de passe</th>
			<td>
				<input type="password" name="supplier_user_password" value="<?php echo esc_attr($data['supplier_user_password']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_password']): ?><span class="description error"><?php echo $errors['supplier_user_password']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Répéter Mot de passe</th>
			<td>
				<input type="password" name="supplier_user_password_confirm" value="<?php echo esc_attr($data['supplier_user_password']); ?>" class="regular-text" />
				<?php if ($errors['supplier_user_password_confirm']): ?><span class="description error"><?php echo $errors['supplier_user_password_confirm']; ?></span><?php endif; ?>
			</td>
		</tr>
<?php endif; ?>
	</tbody>
</table>

<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour le compte" /></p>

</form>

</div>