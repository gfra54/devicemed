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
		<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>" class="menu_actif">Photos et vidéos</a>
		<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>">Evénements</a>
		<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>">Documentation PDF</a>
	</section>
<?php if (($medias OR $galleries) && $supplier['supplier_premium'] == 1): ?>

	<!-- section.medias -->
	<section class="medias">
		<header>
			<!--<h2 class="title">Dernières vidéos</h2>-->
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/videos/add'); ?>">Ajouter une vidéo</a>
				</div>
			<?php endif; ?>
		</header>
		<div class="Videos-wrapper">
			<?php
				foreach ($videos as $video):
				$mediasTemp = DM_Wordpress_Suppliers_Videos::get_medias($video['ID']);
				$thumbnail = $mediasTemp[1];
			?>
					<a href='<?php echo "/posts/details/video/". $video['ID'] ."?supplier_id=$supplier_id"; ?>'><article>
						<figure style="background-image:url('<?php echo esc_attr($thumbnail); ?>')">
							<img src="<?php echo esc_attr($thumbnail); ?>" />
						</figure>
						<h3 class="title"><?php echo esc_html($video['supplier_video_title']); ?></h3>
						<div class='icone_video'><img src='http://devicemed.fr/wp-content/uploads/play_button.png' /></div>
					</article></a>
			<?php endforeach; ?>
		</div>		
		<?php if($supplier['supplier_social_youtube'] != '') { ?>
			<p class='lien_video_youtube'>Pour davantage de vidéos : <?php echo "<a href='". $supplier['supplier_social_youtube'] ."' target='_blank'>". $supplier['supplier_social_youtube'] ."</a>"; ?></p>
		<?php } ?>
		<div class="Galeries-wrapper">
			<?php foreach ($galleries as $gallery): ?>
				<article>
					<?php
						$gallery_id = $gallery['ID'];
						
						$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
						$arrayMedia = $suppliers_medias->get_medias_by_related('Gallery', $gallery_id);
					?>
					<div class="content">
						<?php
							for($i = 0;$i < count($arrayMedia);$i++) {
								$idMedia = $arrayMedia[$i]['ID'];
								
								$imagePost = $arrayMedia[$i]['supplier_media_metas'];
								$arrayTempImage = explode(';', $imagePost);
								$imagePost = $arrayTempImage[1];
								$posPremierGuillemet = strpos($imagePost, '"');
								$posDernierGuillemet = strripos($imagePost, '"');
								$length = $posDernierGuillemet - $posPremierGuillemet;
								$imagePost = substr($imagePost, ($posPremierGuillemet+1), ($length-1));
								
								$urlGallerie = DM_Wordpress_Suppliers_Galleries::get_media_url($gallery_id, $imagePost);
								$legendImage = DM_Wordpress_Suppliers_Galleries::get_legend_image($gallery_id, $imagePost);
								$legend = $legendImage[0]['supplier_media_legende'];
								$legend = stripslashes($legend);
								
								echo "<a class='fancybox' href='$urlGallerie'><figure style=\"background-image:url('$urlGallerie');width:200px !important;display:inline-block !important;margin: 10px !important\">";
									echo "<img src='$urlGallerie' style='width:200px;' />";
									echo "<div class='legend'>$legend</div>";
								echo "</figure></a>";
							}
						?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
<?php else: ?>
	<section class="results">
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
		<?php if($supplier['supplier_social_youtube'] != '') { ?>
			<p>Pour davantage de vidéos : <?php echo "<a href='". $supplier['supplier_social_youtube'] ."' target='_blank'>". $supplier['supplier_social_youtube'] ."</a>"; ?></p>
		<?php } ?>
	</section>
<?php endif; ?>
</div><!-- .column-main -->
<!-- FOOTER -->
<?php get_footer(); ?>
