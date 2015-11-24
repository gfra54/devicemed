<?php get_header(); ?>
<div class="row column-content page-search">
	<div class="col-md-9 col-sm-8 column-main">

		<section class="results">
			<h2 class="title">Articles qui ont le mot-clé '<?php echo $tag; ?>'</h2>
<?php query_posts("tag=$tag"); ?>
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

	</div><!-- .column-main -->
<?php get_footer(); ?>