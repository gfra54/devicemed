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
			<th scope="row">Nom de la gallerie <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_gallery_title" value="<?php echo esc_attr($data['supplier_gallery_title']); ?>" class="regular-text" />
				<?php if ($errors['supplier_gallery_title']): ?><span class="description error"><?php echo $errors['supplier_gallery_title']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Images</th>
			<td>
				<input type="hidden" name="supplier_gallery_featured_file" value="<?php echo esc_attr($data['supplier_gallery_featured_file']); ?>" />
				<div id="files" class="upload-file-list upload-file-list-selectable">
<?php foreach ($data['supplier_gallery_files'] as $file): ?>
					<div class="uploaded-file upload-file-selectable" style="margin-top:20px;">
						<input type="hidden" name="supplier_gallery_files[]" value="<?php echo esc_attr($file); ?>" />
						<img src="<?php echo site_url('/wp-content/uploads/suppliers/galleries/'.$data['ID'].'/thumbnail/'.esc_attr($file)); ?>" />
						<?php
							$gallery_id = $_GET['supplier_gallery_id'];
							$legendImage = DM_Wordpress_Suppliers_Galleries::get_legend_image($gallery_id, $file);
							$legend = $legendImage[0]['supplier_media_legende'];
							$file_temp = $file;
							$array_file = explode('.',"$file");
							$file = $array_file[0];
							echo "<br />Légende : <input type='text' name='legend_$file' value='$legend' style='width:300px' />";
						?>
						<p><?php echo esc_html($file); ?></p>
						<div class="button-delete" id="<?php echo $file_temp; ?>" style='width:100px;height:20px;line-height:20px;background-color:#666;text-align:center;color:#fff;text-transform:uppercase;border-radius:3px;cursor:pointer;margin-bottom:20px;margin-top:5px;'>Delete</div>
					</div>
<?php endforeach; ?>
<?php foreach ($data['supplier_gallery_uploaded_files'] as $file): ?>
					<div class="uploaded-file" style="margin-top:20px;">
						<input type="hidden" name="supplier_products_uploaded_files[]" value="<?php echo esc_attr($file); ?>" />
						<img src="<?php echo site_url('/wp-content/uploads/suppliers/galleries/uploads/thumbnail/'.esc_attr($file)); ?>" />
						<?php
							$gallery_id = $_GET['supplier_gallery_id'];
							$legendImage = DM_Wordpress_Suppliers_Galleries::get_legend_image($gallery_id, $file);
							$legend = $legendImage[0]['supplier_media_legende'];
							echo "<br />Légende : <input type='text' name='legend_$file' value='$legend' style='width:300px' />";
						?>
						<p><?php echo esc_html($file); ?></p>
						<button class="button-delete" data-url="<?php echo site_url('/suppliers/galleries/upload?file='.esc_attr($file)); ?>" data-type="DELETE">Delete</button>
					</div>
<?php endforeach; ?>
				</div>
				<div class="note">Cliquez sur une image dans la liste pour définir une image principale.</div>
				<div class="fileupload-wrapper">
					<input id="fileupload" type="file" name="files[]" accept="image/*" multiple>
				</div>
			<td>
		</tr>
<?php if ($data['supplier_gallery_id']): ?>
		<tr>
			<th scope="row">Date de création</th>
			<td><input type="text" name="supplier_gallery_created" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['supplier_gallery_created']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
		<tr>
			<th scope="row">Dernière modification</th>
			<td><input type="text" name="supplier_gallery_modified" value="<?php echo esc_attr(date('\L\e d/m/Y \à H:i:s', strtotime($data['supplier_gallery_modified']))); ?>" class="regular-text" disabled="disabled" /></td>
		</tr>
<?php endif; ?>
		<tr>
			<th scope="row">Statut</th>
			<td>
				<select name="supplier_gallery_status">
					<option value="0"<?php echo $data['supplier_gallery_status'] == '0' ? ' selected="selected"' : ''; ?>>Brouillon</option>
					<option value="2"<?php echo $data['supplier_gallery_status'] == '2' ? ' selected="selected"' : ''; ?>>En attente de relecture</option>
					<option value="1"<?php echo $data['supplier_gallery_status'] == '1' ? ' selected="selected"' : ''; ?>>Publié</option>
				</select>
			</td>
		</tr>
	</tbody>
</table>
<?php if(isset($_GET['supplier_gallery_id']) && $_GET['supplier_gallery_id'] != '') { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour la gallerie" /></p>
<?php }else { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Ajouter la gallerie" /></p>
<?php } ?>

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
		var featured = $('input[name=supplier_gallery_featured_file]');
		var image = wrapper.find('img');
		// button.on('click', function(event) {
			// event.preventDefault();
			// $.ajax({
				// url: $(this).data('url'),
				// type: $(this).data('type')
			// }).done(function(data) {
				// if (wrapper.hasClass('selected')) {
					// wrapper.siblings().first().addClass('selected');
				// }
				// wrapper.css({opacity: 1}).animate({opacity: 0}, function() {
					// wrapper.remove();
				// });
			// });
		// });
		
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

    var url = '<?php echo site_url('/suppliers/galleries/upload'); ?>';
    $('#fileupload').fileupload({
		maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
				if (!file.error) {
					var wrapper = $('<div />').addClass('uploaded-file');
					wrapper.css("margin-top","20px");
					$('<input type="hidden" name="supplier_gallery_uploaded_files[]" />')
						.val(file.name)
						.appendTo(wrapper);
					$('<img />')
						.attr('src', file.thumbnailUrl)
						.appendTo(wrapper);
					$('<br /> Légende : <input type="text" name="legend_'+ file.name +'" value="" style="width:300px" />').val("").appendTo(wrapper);
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
	
	$(".button-delete").click(function() {
		var parentDiv = $(this).parent();
		var filename = $(this).attr("id");
		var supplier_id = '<?php echo $data['supplier_id']; ?>';
		
		$.ajax({
			url: 'http://www.devicemed.fr/wp-content/themes/devicemed-responsive/suppliers/functions.php?pattern=deleteImage&filename='+ filename +'&supplier_id='+ supplier_id,
			dataType: 'json',
			success: function(json) {
				if(json == 'true') {
					parentDiv.remove();
				}
			}
		});
	});
	
}); })(jQuery);
</script>

<?php
DM_Wordpress_Admin::js('jquery.file-upload/js/vendor/jquery.ui.widget.js', array('jquery'));
DM_Wordpress_Admin::js('jquery.file-upload/js/jquery.iframe-transport.js', array('jquery'));
DM_Wordpress_Admin::js('jquery.file-upload/js/jquery.fileupload.js', array('jquery'));
DM_Wordpress_Admin::js('tinymce/tinymce.min.js', array('jquery'));
?>