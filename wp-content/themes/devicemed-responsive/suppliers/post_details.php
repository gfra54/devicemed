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
	</section>
	<section class="actions">
		<?php 
			$supplier_id = $_GET['supplier_id']; 

			// On récupére le nom du fournisseur
			$sqlNomSupplier = "SELECT supplier_name FROM wordpress_dm_suppliers WHERE ID=$supplier_id";
			$resultNomSupplier = mysql_query($sqlNomSupplier);

			if($rowNomSupplier = mysql_fetch_array($resultNomSupplier)) {
				$supplier_name = $rowNomSupplier['supplier_name'];
				$supplier_name = esc_attr(sanitize_title($supplier_name));
			}
		?>		
		<a href="<?php echo site_url('/suppliers/'.esc_attr(sanitize_title($supplier_name)).'/'. $supplier_id); ?>" class="menu_actif">Coordonnées</a>
		<a href="<?php echo site_url("/suppliers/products/$supplier_id"); ?>">Activités</a>
		<a href="<?php echo site_url("/suppliers/galleries/$supplier_id"); ?>">Présentation et photos</a>
		<a href="<?php echo site_url("/suppliers/posts/$supplier_id"); ?>">Articles</a>
		<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>">Vidéos</a>
		<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>">Evénements</a>
		<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>">Documentation PDF</a>
	</section>
<?php if ($video): ?>
	<section class="medias">
		<?php if($video) { ?>
			<article>
				<?php
					$video_id = $video[0]['ID'];
					
					$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
					$videoTemp = $suppliers_medias->get_featured_media_by_related('Video', $video_id);
					$lienVideo = $videoTemp[0];
				?>
				<h1 class="title"><?php echo $video[0]['supplier_video_title']; ?></h1>
				<div class="content">
					<div class="form-row">
						<div class="form-field">
							<iframe width="100%" height="450" src="<?php echo $lienVideo; ?>" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</article>
		</section>
		<?php } ?>
	</section>
<?php else: ?>
	<section class="results">
		<header>
			<div class="aucun_article">Aucune galerie.</div>
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/videos/add'); ?>">Ajouter une vidéo</a>
				</div>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/galleries/add'); ?>">Ajouter une gallerie</a>
				</div>
			<?php endif; ?>
		</header>
	</section>
<?php endif; ?>
</div><!-- .column-main -->
<!-- FOOTER -->
<?php get_footer(); ?>
