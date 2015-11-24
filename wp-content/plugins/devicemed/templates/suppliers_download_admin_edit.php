<div class="wrap">

<h2><?php echo esc_html($page->page_title()); ?></h2>

<form method="POST" enctype="multipart/form-data">

<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Fournisseur <span class="description">(obligatoire)</span></th>
			<td>
				<select name="supplier_id">
					<option value="0">Aucun</option>
<?php foreach ($suppliers as $supplier_id => $supplier_name): ?>
					<option value="<?php echo esc_attr($supplier_id); ?>"<?php echo $data['supplier_id'] == $supplier_id ? ' selected="selected"' : ''; ?>"><?php echo esc_html($supplier_name); ?></option>
<?php endforeach; ?>
				</select>
				<?php if ($errors['supplier_id']): ?><span class="description error"><?php echo $errors['supplier_id']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Nom du fichier <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_download_title" value="<?php echo esc_attr($data['supplier_download_title']); ?>" class="regular-text" />
				<?php if ($errors['supplier_download_title']): ?><span class="description error"><?php echo $errors['supplier_download_title']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Aperçu du fichier</th>
			<td>
				<div><?php if ($_GET['supplier_download_id']): ?><span class="description error"><img src='<?php echo "http://www.device-med.fr/wp-content/uploads/suppliers/downloads/apercu/". $_GET['supplier_download_id'] ."/". $data['supplier_download_apercu']; ?>' width='200' /></span><?php endif; ?></div>
				<div class="fileupload-wrapper">
					<input id="fileupload" type="file" name="supplier_download_apercu" accept="image/*" multiple>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row">Fichier PDF</th>
			<td>
				<div><?php if ($_GET['supplier_download_id']): ?><span class="description error"><a href='<?php echo "http://www.device-med.fr/wp-content/uploads/suppliers/downloads/pdf/". $_GET['supplier_download_id'] ."/". $data['supplier_download_pdf']; ?>' target='_blank'>PDF</a></span><?php endif; ?></div>
				<div class="fileupload-wrapper">
					<input id="fileupload" type="file" name="supplier_download_pdf" accept="application/pdf" multiple>
					<?php if ($errors['supplier_download_pdf']): ?><span class="description error"><?php echo $errors['supplier_download_pdf']; ?></span><?php endif; ?>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row">Description PDF</th>
			<td>
				<div class="fileupload-wrapper">
					<textarea name="supplier_download_description"><?php echo $data['supplier_download_description']; ?></textarea>
					<?php if ($errors['supplier_download_description']): ?><span class="description error"><?php echo $errors['supplier_download_description']; ?></span><?php endif; ?>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour le fichier" /></p>
</form>
</div>
<script src="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/js/tinymce/tinymce.min.js"></script>
<script type='text/javascript'> tinymce.init({selector:'textarea'}); </script>