<div class="wrap">
<h2><?php echo esc_html($page->page_title()); ?></h2>

<form method="post" enctype="multipart/form-data">
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Nom <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="nom_banniere" value="<?php echo esc_attr($data['nom_banniere']); ?>" class="regular-text" />
				<?php if ($errors['nom_banniere']): ?><span class="description error"><?php echo $errors['nom_banniere']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Lien <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="lien" value="<?php echo esc_attr($data['lien']); ?>" class="regular-text" />
				<?php if ($errors['lien']): ?><span class="description error"><?php echo $errors['lien']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Date de fin <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="date_fin" value="<?php echo esc_attr($data['date_fin']); ?>" class="regular-text" />
				<?php if ($errors['date_fin']): ?><span class="description error"><?php echo $errors['date_fin']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Fréquence <span class="description">(obligatoire)</span></th>
			<td>
				<select name='frequence'>
					<?php
						if($data['frequence'] == 1) {
							echo "<option value='1' selected>Faible</option>";
							echo "<option value='2'>Moyenne</option>";
							echo "<option value='3'>Haute</option>";
						}elseif($data['frequence'] == 2) {
							echo "<option value='1'>Faible</option>";
							echo "<option value='2' selected>Moyenne</option>";
							echo "<option value='3'>Haute</option>";
						}elseif($data['frequence'] == 3) {
							echo "<option value='1'>Faible</option>";
							echo "<option value='2'>Moyenne</option>";
							echo "<option value='3' selected>Haute</option>";
						}
					?>
				</select>
				<?php if ($errors['frequence']): ?><span class="description error"><?php echo $errors['frequence']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Affichage <span class="description">(obligatoire)</span></th>
			<td>
				<select name='affichage'>
					<?php
						if($data['affichage'] == 1) {
							echo "<option value='1' selected>Verticale</option>";
							echo "<option value='2'>Horizontale</option>";
							echo "<option value='3'>Newsletter</option>";
						}elseif($data['affichage'] == 2) {
							echo "<option value='1'>Verticale</option>";
							echo "<option value='2' selected>Horizontale</option>";
							echo "<option value='3'>Newsletter</option>";
						}elseif($data['affichage'] == 3) {
							echo "<option value='1'>Verticale</option>";
							echo "<option value='2'>Horizontale</option>";
							echo "<option value='3' selected>Newsletter</option>";
						}
					?>
				</select>
				<?php if ($errors['affichage']): ?><span class="description error"><?php echo $errors['affichage']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Image <?php if(!isset($_GET['banniere_id']) && $_GET['banniere_id'] == '') { ?><span class="description">(obligatoire)</span><?php } ?></th>
			<td>
				<input id="fileupload" type="file" name="image" accept="image/*" multiple>
				<?php if ($errors['image']): ?><span class="description error"><?php echo $errors['image']; ?></span><?php endif; ?>
			<td>
		</tr>
	</tbody>
</table>
<?php if(isset($_GET['banniere_id']) && $_GET['banniere_id'] != '') { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour la banniére" /></p>
<?php }else { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Ajouter la banniére" /></p>
<?php } ?>
</form>

</div>