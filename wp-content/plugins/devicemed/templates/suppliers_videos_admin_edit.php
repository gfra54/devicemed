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
			<th scope="row">Nom de la vidéo <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_video_title" value="<?php echo esc_attr($data['supplier_video_title']); ?>" class="regular-text" />
				<?php if ($errors['supplier_video_title']): ?><span class="description error"><?php echo $errors['supplier_video_title']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Lien de la vidéo <span class="description">(obligatoire)</span></th>
			<td>
				<?php 
					$metas = $data['supplier_video_media'][0]['supplier_media_metas'];
					
					if(isset($_GET['supplier_video_id']) && $_GET['supplier_video_id'] != '') {
						$idVideo = $_GET['supplier_video_id'];
					}else {
						$idVideo = 0;
					}
					
					$mediasTemp = DM_Wordpress_Suppliers_Videos::get_medias($idVideo);
					$media = $mediasTemp[0];
				?>
				<input type="text" name="supplier_video_content" value="<?php echo esc_attr($media); ?>" class="regular-text" />
				<?php if ($errors['supplier_video_content']): ?><span class="description error"><?php echo $errors['supplier_video_content']; ?></span><?php endif; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				if ($data['supplier_video_media']):
					$metas = $data['supplier_video_media'][0]['supplier_media_metas'];
					
					if(isset($_GET['supplier_video_id']) && $_GET['supplier_video_id'] != '') {
						$idVideo = $_GET['supplier_video_id'];
					}else {
						$idVideo = 0;
					}
					
					$mediasTemp = DM_Wordpress_Suppliers_Videos::get_medias($idVideo);
					$media = $mediasTemp[0];
				?>
									<div class="form-row">
									<div class="form-field">
										<iframe width="100%" height="450" src="<?php echo $media; ?>" allowfullscreen></iframe>
									</div>
									</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th scope="row">Statut</th>
			<td>
				<select name="supplier_video_status">
					<option value="0"<?php echo $data['supplier_video_status'] == '0' ? ' selected="selected"' : ''; ?>>Brouillon</option>
					<option value="2"<?php echo $data['supplier_video_status'] == '2' ? ' selected="selected"' : ''; ?>>En attente de relecture</option>
					<option value="1"<?php echo $data['supplier_video_status'] == '1' ? ' selected="selected"' : ''; ?>>Publié</option>
				</select>
			</td>
		</tr>
	</tbody>
</table>
<?php if(isset($_GET['supplier_video_id']) && $_GET['supplier_video_id'] != '') { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour la vidéo" /></p>
<?php }else { ?>
	<p class="submit"><input type="submit" class="button button-primary" value="Ajouter la vidéo" /></p>
<?php } ?>

</form>

</div>