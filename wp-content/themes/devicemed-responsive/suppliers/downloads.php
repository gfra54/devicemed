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
		<a href="<?php echo site_url("/suppliers/products/$supplier_id"); ?>">Activités</a>
		<a href="<?php echo site_url("/suppliers/galleries/$supplier_id"); ?>">Présentation</a>
		<a href="<?php echo site_url("/suppliers/posts/$supplier_id"); ?>">Articles</a>
		<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>">Photos et vidéos</a>
		<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>">Evénements</a>
		<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>" class="menu_actif">Documentation PDF</a>
	</section>
<?php if ($downloads && $supplier['supplier_premium'] == 1): ?>
	<!-- section.posts -->
	<section class="downloads">
		<header>
			<h2 class="title">Tous les fichiers</h2>
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/downloads/add'); ?>">Ajouter un fichier</a>
				</div>
			<?php endif; ?>
		</header>
<?php foreach ($downloads as $download): ?>
		<article>
			<div class='icone_acrobat'><a href='<?php echo esc_attr(DM_Wordpress_Suppliers_Download::get_pdf_url($download['ID'], $download['supplier_download_pdf'])); ?>' target='_blank'><img src='/wp-content/uploads/icones_acrobat.png' /></a></div>
			<div class="right">
				<header>
					<h3 class="title"><?php echo esc_html($download['supplier_download_title']); ?></h3>
				</header>
			</div>
			<p class="excerpt"><?php echo $download['supplier_download_description']; ?></p>
		</article>
<?php endforeach; ?>
	</section>
	<!-- /section.posts -->
<?php else: ?>
	<section class="results">
		<header>
			<!--<div class="aucun_article">Aucun fichier.</div>-->
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/posts/add'); ?>">Ajouter un fichier</a>
				</div>
			<?php endif; ?>
		</header>
	</section>
<?php endif; ?>
</div><!-- .column-main -->
<!-- FOOTER -->
<?php get_footer(); ?>
