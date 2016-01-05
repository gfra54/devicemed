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
		<a href="<?php echo site_url("/suppliers/posts/$supplier_id"); ?>" class="menu_actif">Articles</a>
		<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>">Photos et vidéos</a>
		<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>">Evénements</a>
		<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>">Documentation PDF</a>
	</section>
<?php if ($supplier['supplier_premium'] == 1): ?>
	<!-- section.posts -->
	<section class="posts">
		<?php 
			function cleanCut($string,$length,$cutString = ' [...]')
			{
				if(strlen($string) <= $length)
				{
					return $string;
				}
				$str = substr($string,0,$length-strlen($cutString)+1);
				return substr($str,0,strrpos($str,' ')).$cutString;
			}
		?>
		<?php query_posts("tag=$supplier_name"); ?>
		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
				<article>
					<a href="<?php echo get_permalink($post->ID); ?>">
						<span class="left">
							<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): ?>
							<figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
								<img src="<?php echo $thumbnail->url; ?>" title="<?php echo $thumbnail->post_title; ?>" />
							</figure>
							<?php endif; ?>
						</span>
						<span class="right">
							<header>
								<?php if ($categories = get_the_category()): ?>
								<span class="categories">
								<?php
									// On récupére les catégories
									$arrayCategorie = array();
									$sqlCategories = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=0";
									$resultCategories = mysql_query($sqlCategories);

									while($rowCategories = mysql_fetch_array($resultCategories)) {
										$nomCategorie = $rowCategories['supplier_category_title'];

										array_push($arrayCategorie, $nomCategorie);
									}

									$items = array();
									foreach ($categories as $category)
									{
										$nomCategorieTemp = $category->cat_name;
										if(in_array($nomCategorieTemp, $arrayCategorie)) {
											$items[] = '<span class="category">'.$category->cat_name.'</span>';
										}else {
											$items[] = '<span class="sous_category">'.$category->cat_name.'</span>';
										}
									}
									echo implode(', ', $items);
								?>
								</span>
								<?php endif; ?>
								<h2 class="title"><?php the_title(); ?></h2>
							</header>
							<p class="excerpt"><?php echo devicemed_get_post_excerpt(); ?></p>
							<span class="metas">
								<span class="date-wrapper">Le <span class="date"><?php echo get_the_date('l d F Y'); ?></span></span>
								<span class="author-wrapper">par <span class="author"><?php echo get_the_author(); ?></span></span>
							</span>
						</span>
					</a>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>
	</section>
	<!-- /section.posts -->
<?php else: ?>
	<section class="results">
		<header>
			<!--<div class="aucun_article">Aucun article.</div>-->
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/posts/add'); ?>">Ajouter un article</a>
				</div>
			<?php endif; ?>
		</header>
	</section>
<?php endif; ?>
</div><!-- .column-main -->
<!-- FOOTER -->
<?php get_footer(); ?>
