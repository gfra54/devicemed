<div class="wrap page-suppliers-products page-suppliers-products-edit">

<h2><?php echo esc_html($page->page_title()); ?></h2>

<form method="post">

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
				<input type="text" name="supplier_product_title" value="<?php echo esc_attr($data['supplier_product_title']); ?>" class="regular-text" />
				<?php if ($errors['supplier_product_title']): ?><span class="description error"><?php echo $errors['supplier_product_title']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Contenu</th>
			<td>
				<textarea class="editable" name="supplier_product_content" cols="40" rows="10"><?php echo esc_html($data['supplier_product_content']); ?></textarea>
				<?php if ($errors['supplier_product_content']): ?><span class="description error"><?php echo $errors['supplier_product_content']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Images</th>
			<td>
				<input type="hidden" name="supplier_product_featured_file" value="<?php echo esc_attr($data['supplier_product_featured_file']); ?>" />
				<div id="files" class="upload-file-list upload-file-list-selectable">
<?php foreach ($data['supplier_product_files'] as $file): ?>
					<div class="uploaded-file upload-file-selectable">
						<input type="hidden" name="supplier_product_files[]" value="<?php echo esc_attr($file); ?>" />
						<img src="<?php echo site_url('/wp-content/uploads/suppliers/products/'.$data['ID'].'/thumbnail/'.esc_attr($file)); ?>" />
						<p><?php echo esc_html($file); ?></p>
						<button class="button-delete" data-url="<?php echo site_url('/suppliers/products/upload?file='.esc_attr($file)); ?>" data-type="DELETE">Delete</button>
					</div>
<?php endforeach; ?>
<?php foreach ($data['supplier_product_uploaded_files'] as $file): ?>
					<div class="uploaded-file">
						<input type="hidden" name="supplier_products_uploaded_files[]" value="<?php echo esc_attr($file); ?>" />
						<img src="<?php echo site_url('/wp-content/uploads/suppliers/products/uploads/thumbnail/'.esc_attr($file)); ?>" />
						<p><?php echo esc_html($file); ?></p>
						<button class="button-delete" data-url="<?php echo site_url('/suppliers/products/upload?file='.esc_attr($file)); ?>" data-type="DELETE">Delete</button>
					</div>
<?php endforeach; ?>
				</div>
				<div class="note">Cliquez sur une image dans la liste pour définir une image principale.</div>
				<div class="fileupload-wrapper">
					<input id="fileupload" type="file" name="files[]" accept="image/*" multiple>
				</div>
			<td>
		</tr>
<?php if ($data['supplier_product_id']): ?>
		<tr>
			<th scope="row">Date de création</th>
			<td><input type="text" name="supplier_product_created" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['supplier_product_created']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
		<tr>
			<th scope="row">Dernière modification</th>
			<td><input type="text" name="supplier_product_modified" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['supplier_product_modified']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
<?php endif; ?>
		<tr>
			<th scope="row">Statut</th>
			<td>
				<select name="supplier_product_status">
					<option value="0"<?php echo $data['supplier_product_status'] == '0' ? ' selected="selected"' : ''; ?>>Brouillon</option>
					<option value="2"<?php echo $data['supplier_product_status'] == '2' ? ' selected="selected"' : ''; ?>>En attente de relecture</option>
					<option value="1"<?php echo $data['supplier_product_status'] == '1' ? ' selected="selected"' : ''; ?>>Publié</option>
				</select>
			</td>
		</tr>
	</tbody>
</table>

<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour le produit" /></p>

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

	var fileUploadTriggers = function() {
		var wrapper = $(this);
		var button = wrapper.find('button');
		var input = wrapper.find('input[type=hidden]');
		var featured = $('input[name=supplier_product_featured_file]');
		var image = wrapper.find('img');
		button.on('click', function(event) {
			event.preventDefault();
			$.ajax({
				url: $(this).data('url'),
				type: $(this).data('type')
			}).done(function(data) {
				if (wrapper.hasClass('selected')) {
					wrapper.siblings().first().addClass('selected');
				}
				wrapper.css({opacity: 1}).animate({opacity: 0}, function() {
					wrapper.remove();
				});
			});
		});
		image.on('click', function(event) {
			event.preventDefault();
			wrapper.siblings().removeClass('selected');
			wrapper.addClass('selected');
			featured.val(input.val());
		});
		if (!wrapper.siblings().size() || input.val() == featured.val()) {
			image.click();
		}
	}

    var url = '<?php echo site_url('/suppliers/products/upload'); ?>';
    $('#fileupload').fileupload({
		maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
				if (!file.error) {
					var wrapper = $('<div />').addClass('uploaded-file');
					$('<input type="hidden" name="supplier_product_uploaded_files[]" />')
						.val(file.name)
						.appendTo(wrapper);
					$('<img />')
						.attr('src', file.thumbnailUrl)
						.appendTo(wrapper);
					$('<p />')
						.text(file.name)
						.appendTo(wrapper);
					$('<button />')
						.addClass('button-delete')
						.text('Delete')
						.data('url', file.deleteUrl)
						.data('type', file.deleteType)
						.appendTo(wrapper);
					wrapper.appendTo('#files');
					fileUploadTriggers.apply(wrapper);
				}
            });
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
	
	$('#files > .uploaded-file').each(function() {
		fileUploadTriggers.apply(this);
	});
	
}); })(jQuery);
</script>

<?php
DM_Wordpress_Admin::js('jquery.file-upload/js/vendor/jquery.ui.widget.js', array('jquery'));
DM_Wordpress_Admin::js('jquery.file-upload/js/jquery.iframe-transport.js', array('jquery'));
DM_Wordpress_Admin::js('jquery.file-upload/js/jquery.fileupload.js', array('jquery'));
DM_Wordpress_Admin::js('tinymce/tinymce.min.js', array('jquery'));
?>