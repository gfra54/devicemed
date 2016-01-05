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
		<a href="<?php echo site_url("/suppliers/galleries/$supplier_id"); ?>" class="menu_actif">Présentation</a>
		<a href="<?php echo site_url("/suppliers/posts/$supplier_id"); ?>">Articles</a>
		<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>">Photos et vidéos</a>
		<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>">Evénements</a>
		<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>">Documentation PDF</a>
	</section>
<?php if (($medias OR $galleries) && $supplier['supplier_premium'] == 1): ?>
	<!-- section.medias -->
	<section class="medias">
		<?php if($supplier['supplier_logo'] != '') { ?>
			<div class='logo_supplier'>
				<img src='<?php echo "../../../wp-content/uploads/logo_suppliers/". $supplier['supplier_logo']; ?>' />
			</div>
		<?php } ?>
		<p class="about"><?php echo html_entity_decode($supplier['supplier_about']); ?></p>
		<header>
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/galleries/add'); ?>">Ajouter une gallerie</a>
				</div>
			<?php endif; ?>
		</header>
	</section>
	<!-- /section.medias -->
	<!-- section.medias -->
	<!--<section class="medias">
		<header>
			<h2 class="title">Dernières vidéos</h2>
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/videos/add'); ?>">Ajouter une vidéo</a>
				</div>
			<?php endif; ?>
		</header>
		<div class="Galeries-wrapper">
<?php
foreach ($videos as $video):
$mediasTemp = DM_Wordpress_Suppliers_Videos::get_medias($video['ID']);
$thumbnail = $mediasTemp[1];
?>
		<a href='<?php echo "http://www.device-med.fr/posts/details/video/". $video['ID']; ?>'><article>
			<figure style="background-image:url('<?php echo esc_attr($thumbnail); ?>')">
				<img src="<?php echo esc_attr($thumbnail); ?>" />
			</figure>
			<h3 class="title"><?php echo esc_html($video['supplier_video_title']); ?></h3>
		</article></a>
<?php endforeach; ?>
		</div>
	</section>-->
<?php else: ?>
	<section class="results">
		<?php if($supplier['supplier_logo'] != '') { ?>
			<div class='logo_supplier'>
				<img src='<?php echo "../../../wp-content/uploads/logo_suppliers/". $supplier['supplier_logo']; ?>' />
			</div>
		<?php } ?>
		<p class="about"><?php echo html_entity_decode($supplier['supplier_about']); ?></p>
		<header>
			<!--<div class="aucun_article">Aucune galerie.</div>-->
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
