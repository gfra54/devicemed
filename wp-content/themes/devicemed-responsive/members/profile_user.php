<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="profile">
		<h2 class="title">Votre profil</h2>
		<form method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">Identifiant</th>
						<td>
							<input type="text" name="user_login" value="<?php echo esc_attr($data['user_login']); ?>" class="regular-text"<?php echo $data['user_id'] ? ' disabled="disabled"' : ''; ?> />
							<?php if ($errors['user_login']): ?><span class="description error"><?php echo $errors['user_login']; ?></span><?php endif; ?>
						</td>
					</tr>
					<tr>
					<tr<?php if ($errors['user_lastname']): echo ' class="error"'; endif; ?>>
						<th scope="row">Nom <span class="description">(obligatoire)</span>
						</th>
						<td>
							<input type="text" name="user_lastname" value="<?php echo esc_attr($data['user_lastname']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_lastname']): echo $errors['user_lastname']; endif; ?></span>
						</td>
					</tr>
					<tr<?php if ($errors['user_firstname']): echo ' class="error"'; endif; ?>>
						<th scope="row">Prénom <span class="description">(obligatoire)</span></th>
						<td>
							<input type="text" name="user_firstname" value="<?php echo esc_attr($data['user_firstname']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_firstname']): echo $errors['user_firstname']; endif; ?></span>
						</td>
					</tr>
					<tr<?php if ($errors['user_email']): echo ' class="error"'; endif; ?>>
						<th scope="row">Email <span class="description">(obligatoire)</span></th>
						<td>
							<input type="text" name="user_e-mail" value="<?php echo esc_attr($data['user_email']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_email']): echo $errors['user_email']; endif; ?></span>
						</td>
					</tr>
					<!--<tr<?php if ($errors['user_sex']): echo ' class="error"'; endif; ?>>
						<th scope="row">Sexe <span class="description">(obligatoire)</span></th>
						<td>
							<select name="user_sex">
								<option value="M"<?php echo $data['user_sex'] == 'M' ? ' selected="selected"' : ''; ?>>Masculin</option>
								<option value="F"<?php echo $data['user_sex'] == 'F' ? ' selected="selected"' : ''; ?>>Féminin</option>
							</select>
						</td>
					</tr>-->
				</tbody>
			</table>
			<h3 class="title">Votre adresse</h2>
			<table class="form-table">
				<tbody>
					<tr<?php if ($errors['user_address']): echo ' class="error"'; endif; ?>>
						<th scope="row">Adresse</th>
						<td>
							<input type="text" name="user_address" value="<?php echo esc_attr($data['user_address']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_address']): echo $errors['user_address']; endif; ?></span>
						</td>
					</tr>
					<tr<?php if ($errors['user_postalcode']): echo ' class="error"'; endif; ?>>
						<th scope="row">Code Postal</th>
						<td>
							<input type="text" name="user_postalcode" value="<?php echo esc_attr($data['user_postalcode']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_postalcode']): echo $errors['user_postalcode']; endif; ?></span>
						</td>
					</tr>
					<tr<?php if ($errors['user_city']): echo ' class="error"'; endif; ?>>
						<th scope="row">Ville</th>
						<td>
							<input type="text" name="user_city" value="<?php echo esc_attr($data['user_city']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_city']): echo $errors['user_city']; endif; ?></span>
						</td>
					</tr>
					<tr<?php if ($errors['user_country']): echo ' class="error"'; endif; ?>>
						<th scope="row">Pays</th>
						<td>
							<input type="text" name="user_country" value="<?php echo esc_attr($data['user_country']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_country']): echo $errors['user_country']; endif; ?></span>
						</td>
					</tr>
				</tbody>
			</table>
<?php if (!$data['user_password']): ?>
			<h3 class="title">Votre mot de passe</h2>
			<table class="form-table">
				<tbody>
					<tr<?php if ($errors['user_new_password']): echo ' class="error"'; endif; ?>>
						<th scope="row">Mot de passe <span class="description">(obligatoire)</span></th>
						<td>
							<input type="password" name="user_new_password" value="<?php echo esc_attr($data['user_new_password']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_new_password']): echo $errors['user_new_password']; endif; ?></span>
						</td>
					</tr>
					<tr<?php if ($errors['user_new_password_confirm']): echo ' class="error"'; endif; ?>>
						<th scope="row">Répéter votre mot de passe <span class="description">(obligatoire)</span></th>
						<td>
							<input type="password" name="user_new_password_confirm" value="<?php echo esc_attr($data['user_new_password_confirm']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_new_password_confirm']): echo $errors['user_new_password_confirm']; endif; ?></span>
						</td>
					</tr>
				</tbody>
			</table>
<?php else: ?>
			<h3 class="title">Changez votre mot de passe</h2>
			<table class="form-table">
				<tbody>
					<tr<?php if ($errors['user_new_password']): echo ' class="error"'; endif; ?>>
						<th scope="row">Nouveau mot de passe</th>
						<td>
							<input type="password" name="user_new_password" value="<?php echo esc_attr($data['user_new_password']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_new_password']): echo $errors['user_new_password']; endif; ?></span>
						</td>
					</tr>
					<tr<?php if ($errors['user_new_password_confirm']): echo ' class="error"'; endif; ?>>
						<th scope="row">Répéter nouveau mot de passe</th>
						<td>
							<input type="password" name="user_new_password_confirm" value="<?php echo esc_attr($data['user_new_password_confirm']); ?>" class="regular-text" />
							<span class="description error"><?php if ($errors['user_new_password_confirm']): echo $errors['user_new_password_confirm']; endif; ?></span>
						</td>
					</tr>
				</tbody>
<?php endif; ?>
			</table>
			<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour votre profil" /></p>
		</form>
	</section>
</div><!-- .column-main -->
<?php get_footer(); ?>