<div class="wrap">
<h2><?php echo esc_html($page->page_title()); ?></h2>

<form method="post" enctype="multipart/form-data">
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Nom <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="titre_archive" value="<?php echo esc_attr($data['titre_archive']); ?>" class="regular-text" />
				<?php if ($errors['titre_archive']): ?><span class="description error"><?php echo $errors['titre_archive']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Aperçu du catalogue <?php if(!isset($_GET['archive_id']) && $_GET['archive_id'] == '') { ?><span class="description">(obligatoire)</span><?php } ?></th>
			<td>
				<div class="fileupload-wrapper">
					<input id="fileupload" type="file" name="apercu_archive" accept="image/*" multiple>
					<?php if ($errors['apercu_archive']): ?><span class="description error"><?php echo $errors['apercu_archive']; ?></span><?php endif; ?>
				</div>
			<td>
		</tr>
		<tr>
			<th scope="row">Catalogue (Format PDF) <?php if(!isset($_GET['archive_id']) && $_GET['archive_id'] == '') { ?><span class="description">(obligatoire)</span><?php } ?></th>
			<td>
				<div class="fileupload-wrapper">
					<input id="fileupload" type="file" name="pdf_archive" accept="application/pdf" multiple>
					<?php if ($errors['pdf_archive']): ?><span class="description error"><?php echo $errors['pdf_archive']; ?></span><?php endif; ?>
				</div>
			<td>
		</tr>
	</tbody>
</table>
<?php if(isset($_GET['archive_id']) && $_GET['archive_id'] != '') { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour l'archive" /></p>
<?php }else { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Ajouter l'archive" /></p>
<?php } ?>
</form>

</div>