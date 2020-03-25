<div class="wrap">
<h2><?php echo esc_html($page->page_title()); ?></h2>

<form method="post">

<table class="form-table">
	<tbody>
		<?php if(isset($success['general']) && $success['general'] != '') { ?>
			<tr>
				<td colspan='2'><?php echo $success['general']; ?></td>
			</tr>
		<?php } ?>
		<tr>
			<th scope="row">Adresse mail <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="mail_newsletter" value="<?php echo esc_attr($data['mail_newsletter']); ?>" class="regular-text" />
				<?php if ($errors['mail_newsletter']): ?><span class="description error"><?php echo $errors['mail_newsletter']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Recevoir la newsletter devicemed <span class="description">(obligatoire)</span></th>
			<td>
				<?php if($data['offre_devicemed'] == 1) { ?>
					<input type="radio" name="offre_devicemed" value="1" checked> <span class='radiobutton_newsletter'>Oui</span> 
					<input type="radio" name="offre_devicemed" value="2"> <span class='radiobutton_newsletter'>Non</span>
				<?php }elseif($data['offre_devicemed'] == 2) { ?>
					<input type="radio" name="offre_devicemed" value="1"> <span class='radiobutton_newsletter'>Oui</span> 
					<input type="radio" name="offre_devicemed" value="2" checked> <span class='radiobutton_newsletter'>Non</span>
				<?php }else { ?>
					<input type="radio" name="offre_devicemed" value="1"> <span class='radiobutton_newsletter'>Oui</span> 
					<input type="radio" name="offre_devicemed" value="2"> <span class='radiobutton_newsletter'>Non</span>
				<?php } ?>
				<?php if ($errors['offre_devicemed']): ?><span class="description error"><?php echo $errors['offre_devicemed']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Recevoir les offres de nos partenaire <span class="description">(obligatoire)</span></th>
			<td>
				<?php if($data['offre_partenaires'] == 1) { ?>
					<input type="radio" name="offre_partenaires" value="1" checked> <span class='radiobutton_newsletter'>Oui</span> 
					<input type="radio" name="offre_partenaires" value="2"> <span class='radiobutton_newsletter'>Non</span>
				<?php }elseif($data['offre_partenaires'] == 2) { ?>
					<input type="radio" name="offre_partenaires" value="1"> <span class='radiobutton_newsletter'>Oui</span> 
					<input type="radio" name="offre_partenaires" value="2" checked> <span class='radiobutton_newsletter'>Non</span>
				<?php }else { ?>
					<input type="radio" name="offre_partenaires" value="1"> <span class='radiobutton_newsletter'>Oui</span> 
					<input type="radio" name="offre_partenaires" value="2"> <span class='radiobutton_newsletter'>Non</span>
				<?php } ?>
				<?php if ($errors['offre_partenaires']): ?><span class="description error"><?php echo $errors['offre_partenaires']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Nom <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="nom" value="<?php echo esc_attr($data['nom']); ?>" class="regular-text" />
				<?php if ($errors['nom']): ?><span class="description error"><?php echo $errors['nom']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Prénom <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="prenom" value="<?php echo esc_attr($data['prenom']); ?>" class="regular-text" />
				<?php if ($errors['prenom']): ?><span class="description error"><?php echo $errors['prenom']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Ville <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="ville" value="<?php echo esc_attr($data['ville']); ?>" class="regular-text" />
				<?php if ($errors['ville']): ?><span class="description error"><?php echo $errors['ville']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Code postal <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="cp" value="<?php echo esc_attr($data['cp']); ?>" class="regular-text" />
				<?php if ($errors['cp']): ?><span class="description error"><?php echo $errors['cp']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Actif</th>
			<td>
				<?php if($data['actif'] == 1) { ?>
					<select name='actif'>
						<option value='0'>Non</option>
						<option value='1' selected>Oui</option>
					</select>
				<?php }else { ?>
					<select name='actif'>
						<option value='0' selected>Non</option>
						<option value='1'>Oui</option>
					</select>
				<?php } ?>
			</td>
		</tr>
	</tbody>
</table>
<?php if(isset($_GET['inscrits_id']) && $_GET['inscrits_id'] != '') { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour le mail" /></p>
<?php }else { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Ajouter le mail" /></p>
<?php } ?>

</form>

</div>