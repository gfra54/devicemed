<div class="wrap">

<h2><?php echo esc_html($page->page_title()); ?></h2>
<h3>Options personnelles</h3>

<form method="post">

<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Identifiant <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="user_login" value="<?php echo esc_attr($data['user_login']); ?>" class="regular-text"<?php echo $data['user_id'] ? ' disabled="disabled"' : ''; ?> />
				<?php if ($errors['user_login']): ?><span class="description error"><?php echo $errors['user_login']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Nom</th>
			<td>
				<input type="text" name="user_lastname" value="<?php echo esc_attr($data['user_lastname']); ?>" class="regular-text" />
				<?php if ($errors['user_lastname']): ?><span class="description error"><?php echo $errors['user_lastname']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Prénom</th>
			<td>
				<input type="text" name="user_firstname" value="<?php echo esc_attr($data['user_firstname']); ?>" class="regular-text" />
				<?php if ($errors['user_firstname']): ?><span class="description error"><?php echo $errors['user_firstname']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">E-Mail <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="user_email" value="<?php echo esc_attr($data['user_email']); ?>" class="regular-text" />
				<?php if ($errors['user_email']): ?><span class="description error"><?php echo $errors['user_email']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Sexe</th>
			<td>
				<select name="user_sex">
					<option value="M"<?php echo $data['user_sex'] == 'M' ? ' selected="selected"' : ''; ?>>Masculin</option>
					<option value="F"<?php echo $data['user_sex'] == 'F' ? ' selected="selected"' : ''; ?>>Féminin</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">Adresse</th>
			<td>
				<input type="text" name="user_address" value="<?php echo esc_attr($data['user_address']); ?>" class="regular-text" />
				<?php if ($errors['user_address']): ?><span class="description error"><?php echo $errors['user_address']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Code Postal</th>
			<td>
				<input type="text" name="user_postalcode" value="<?php echo esc_attr($data['user_postalcode']); ?>" class="regular-text" />
				<?php if ($errors['user_postalcode']): ?><span class="description error"><?php echo $errors['user_postalcode']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Ville</th>
			<td>
				<input type="text" name="user_city" value="<?php echo esc_attr($data['user_city']); ?>" class="regular-text" />
				<?php if ($errors['user_city']): ?><span class="description error"><?php echo $errors['user_city']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Pays</th>
			<td>
				<input type="text" name="user_country" value="<?php echo esc_attr($data['user_country']); ?>" class="regular-text" />
				<?php if ($errors['user_country']): ?><span class="description error"><?php echo $errors['user_country']; ?></span><?php endif; ?>
			</td>
		</tr>
<?php if ($data['user_id']): ?>
		<tr>
			<th scope="row">Date de création</th>
			<td><input type="text" name="user_created" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['user_created']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
		<tr>
			<th scope="row">Dernière modification</th>
			<td><input type="text" name="user_modified" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['user_modified']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
<?php endif; ?>
		<tr>
			<th scope="row">Statut</th>
			<td>
				<select name="user_status">
					<option value="0"<?php echo $data['user_status'] == '0' ? ' selected="selected"' : ''; ?>>Compte désactivé</option>
					<option value="1"<?php echo $data['user_status'] == '1' ? ' selected="selected"' : ''; ?>>Compte actif</option>
				</select>
			</td>
		</tr>
<?php if ($data['user_id']): ?>
		<tr>
			<th scope="row">Nouveau mot de passe</th>
			<td>
				<input type="password" name="user_new_password" value="<?php echo esc_attr($data['user_new_password']); ?>" class="regular-text" />
				<?php if ($errors['user_new_password']): ?><span class="description error"><?php echo $errors['user_new_password']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Répéter nouveau mot de passe</th>
			<td>
				<input type="password" name="user_new_password_confirm" value="<?php echo esc_attr($data['user_new_password_confirm']); ?>" class="regular-text" />
				<?php if ($errors['user_new_password_confirm']): ?><span class="description error"><?php echo $errors['user_new_password_confirm']; ?></span><?php endif; ?>
			</td>
		</tr>
<?php else: ?>
		<tr>
			<th scope="row">Mot de passe</th>
			<td>
				<input type="password" name="user_password" value="<?php echo esc_attr($data['user_password']); ?>" class="regular-text" />
				<?php if ($errors['user_password']): ?><span class="description error"><?php echo $errors['user_password']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Répéter Mot de passe</th>
			<td>
				<input type="password" name="user_password_confirm" value="<?php echo esc_attr($data['user_password']); ?>" class="regular-text" />
				<?php if ($errors['user_password_confirm']): ?><span class="description error"><?php echo $errors['user_password_confirm']; ?></span><?php endif; ?>
			</td>
		</tr>
<?php endif; ?>
	</tbody>
</table>

<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour le profil" /></p>

</form>

</div>