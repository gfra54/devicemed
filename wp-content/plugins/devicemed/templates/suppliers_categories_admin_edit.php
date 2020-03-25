<div class="wrap">

<h2><?php echo esc_html($page->page_title()); ?></h2>

<form method="post">

<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Titre <span class="description">(obligatoire)</span></th>
			<td>
				<input type="text" name="supplier_category_title" value="<?php echo esc_attr($data['supplier_category_title']); ?>" class="regular-text" />
				<?php if ($errors['supplier_category_title']): ?><span class="description error"><?php echo $errors['supplier_category_title']; ?></span><?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>

<p class="submit"><input type="submit" class="button button-primary" value="Mettre à jour la catégorie" /></p>

</form>

</div>