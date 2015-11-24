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
			<th scope="row">Titre <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_event_title" value="<?php echo esc_attr($data['supplier_event_title']); ?>" class="regular-text" />
				<?php if ($errors['supplier_event_title']): ?><span class="description error"><?php echo $errors['supplier_event_title']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Aperçu de l'évènement</th>
			<td>
				<div><?php if ($_GET['supplier_event_id']): ?><span class="description error"><img src='<?php echo "http://www.device-med.fr/wp-content/uploads/suppliers/events/". $_GET['supplier_event_id'] ."/". $data['supplier_event_apercu']; ?>' /></span><?php endif; ?></div>
				<div class="fileupload-wrapper">
					<input id="fileupload" type="file" name="supplier_event_apercu" accept="image/*" multiple>
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row">Lieu <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_event_lieu" value="<?php echo esc_attr($data['supplier_event_lieu']); ?>" class="regular-text" />
				<?php if ($errors['supplier_event_lieu']): ?><span class="description error"><?php echo $errors['supplier_event_lieu']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Début <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_event_debut" placeHolder='YYYYY-mm-dd' value="<?php echo esc_attr($data['supplier_event_debut']); ?>" class="regular-text" />
				<?php if ($errors['supplier_event_debut']): ?><span class="description error"><?php echo $errors['supplier_event_debut']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Fin <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_event_fin" placeHolder='YYYYY-mm-dd' value="<?php echo esc_attr($data['supplier_event_fin']); ?>" class="regular-text" />
				<?php if ($errors['supplier_event_fin']): ?><span class="description error"><?php echo $errors['supplier_event_fin']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Description <span class="description">(obligatoire)</span></th>
			<td>
				<textarea class="editable" name="supplier_event_description" cols="40" rows="10"><?php echo esc_html($data['supplier_event_description']); ?></textarea>
				<?php if ($errors['supplier_event_description']): ?><span class="description error"><?php echo $errors['supplier_event_description']; ?></span><?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>

	<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour l'évènement" /></p>

</form>

</div>
<script type="text/javascript">
/*jslint unparam: true */
/*global window, $ */
(function($) { $(function() {
	tinymce.init({
		language: 'fr_FR',
		selector: ".editable",
		plugins: "paste autolink link lists",
		menubar: false,
		toolbar: "bold italic formatselect bullist numlist link unlink",
		valid_elements: "a[href|target=_blank],strong,em,h1,h2,p,ul,ol,li,br",
		block_formats: "Paragraph=p;Titre=h1;Sous-titre=h2"
	});
}); })(jQuery);
</script>
<?php
DM_Wordpress_Admin::js('tinymce/tinymce.min.js', array('jquery'));
?>