
<?php get_header(); ?>

<?php 
	$session_supplier_id = $session['supplier_id'];
	$supplier_id = $supplier['ID'];
	$supplier_name = esc_attr(sanitize_title($supplier['supplier_name']));
?>
<div class="row column-content page-supplier">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="results">
		<h2 class="title"><?php echo esc_html($supplier['supplier_name']); ?></h2>
		<div class='retour_recherche_fournisseur'>
			<a href='/suppliers/'>
				Retour à la page de recherche d’un fournisseur
			</a>
		</div>
	</section>
	<section class="actions">
		<a href="<?php echo site_url('/suppliers/'.esc_attr(sanitize_title($supplier_name)).'/'. $supplier_id); ?>">Coordonnées</a>
		<a href="<?php echo site_url("/suppliers/products/$supplier_id"); ?>" class="menu_actif">Activités</a>
		<?php if($supplier['supplier_premium'] == 1) { ?>
			<a href="<?php echo site_url("/suppliers/galleries/$supplier_id"); ?>">Présentation</a>
			<a href="<?php echo site_url("/suppliers/posts/$supplier_id"); ?>">Articles</a>
			<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>">Photos et vidéos</a>
			<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>">Evénements</a>
			<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>">Documentation PDF</a>
		<?php }else { ?>
			<span class='details_supplier_disabled'>Présentation et photos</span>
			<span class='details_supplier_disabled'>Articles</span>
			<span class='details_supplier_disabled'>Vidéos</span>
			<span class='details_supplier_disabled'>Evénements</span>
			<span class='details_supplier_disabled'>Documentation PDF</span>
		<?php } ?>
	</section>
	<section class="products">
		<?php
			// On récupére les catégories du fournisseur
			$sqlCategoriesSupplier = "SELECT supplier_category_id FROM wordpress_dm_suppliers WHERE ID=$supplier_id";
			$resultCategoriesSupplier = mysql_query($sqlCategoriesSupplier);

			if($rowCategoriesSupplier = mysql_fetch_array($resultCategoriesSupplier)) {
				$categorieId = $rowCategoriesSupplier['supplier_category_id'];
			}

			if($categorieId != '') {
				$tabCategories = explode(',', $categorieId);

				for($i = 0; $i < sizeOf($tabCategories); $i++) {
					$idCategorie = $tabCategories[$i];

					// On récupére le nom de la catégorie
					$sqlNomCategorie = "SELECT ID, supplier_category_parent, supplier_category_title, supplier_souscategorie_parent FROM wordpress_dm_suppliers_categories WHERE ID=$idCategorie";
					$resultNomCategorie = mysql_query($sqlNomCategorie);

					if($rowNomCategorie = mysql_fetch_array($resultNomCategorie)) {
						$idCategorie = $rowNomCategorie['ID'];
						$nomCategorie = $rowNomCategorie['supplier_category_title'];
						$categorieParentId = $rowNomCategorie['supplier_category_parent'];
						$sousCategorieParent = $rowNomCategorie['supplier_souscategorie_parent'];
					}

					// On récupére le nom de la catégorie parente
					$sqlNomCategorie2 = "SELECT supplier_category_title FROM wordpress_dm_suppliers_categories WHERE ID=$categorieParentId";
					$resultNomCategorie2 = mysql_query($sqlNomCategorie2);

					if($rowNomCategorie2 = mysql_fetch_array($resultNomCategorie2)) {
						$nomCategorieParent = $rowNomCategorie2['supplier_category_title'];
					}

					// On récupére le nom de la sous catégorie intermédiaire
					$sqlNomCategorie3 = "SELECT supplier_souscategorie_name FROM wordpress_dm_suppliers_souscategories WHERE ID=$sousCategorieParent";
					$resultNomCategorie3 = mysql_query($sqlNomCategorie3);

					if($rowNomCategorie3 = mysql_fetch_array($resultNomCategorie3)) {
						$nomsousCategorieParent = $rowNomCategorie3['supplier_souscategorie_name'];
					}

					if($nomCategorie != '' && $nomCategorieParent != '') {
						echo "<a href='/suppliers/?categorie=$categorieParentId' target='_blank'>$nomCategorieParent</a> >";

						if($sousCategorieParent != 0) {
							echo " <a href='/suppliers/?souscat=$sousCategorieParent' target='_blank'>$nomsousCategorieParent</a> >";
						}

						echo " <a href='/suppliers/?categorie=$idCategorie' target='_blank'>$nomCategorie</a><br />";
					}
				}
			}else {
				echo "Aucune catégorie n'a été renseignée.";
			}
		?>
	</section>
</div><!-- .column-main -->
<!-- FOOTER -->
<?php get_footer(); ?>
