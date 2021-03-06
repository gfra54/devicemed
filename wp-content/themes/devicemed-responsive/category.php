<?php get_header(); ?>
<div class="row column-content page-category">
	<div class="col-md-9 col-sm-8 column-main">

		<section class="results">
			<h2 class="title"><?php echo single_cat_title('', false); ?></h2>
<?php if (have_posts()): $cpt=0?>
<?php while (have_posts()): the_post(); $cpt++;?>
	<?php if($cpt == 3) {?>
		<div class="pub-dans-liste-articles"><?php the_ad_group(4623); ?></div>
	<?php }?>
				<article>
					<a href="<?php echo get_permalink($post->ID); ?>">
						<span class="left">
							<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): ?>
							<figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
								<img src="<?php echo $thumbnail->url; ?>" title="<?php echo $thumbnail->post_title; ?>" />
							</figure>
							<?php else: ?>
							<figure></figure>
							<?php endif; ?>
						</span>
						<span class="right">
							<header>
								<?php if ($categories = get_the_category()): ?>
								<span class="categories">
								<?php
									$items = array();

									foreach ($categories as $category)
									{
										$nomCategorieTemp = $category->cat_name;
											
										$parentcat = $category->category_parent;
										$nomCatParent = get_cat_name($parentcat);

										if($nomCatParent != 'Dossiers') {
											if($nomCatParent) {
												$items[] = '<span class="category_principal">'.$nomCatParent.' &gt; </span><span class="category">'.$category->cat_name.'</span>';
											} else {
												$items[] = '<span class="category_principal">'.$category->cat_name.'';
											}
										}
										
									}
									
									echo implode(' / ', $items);
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
			<div class="navigation">
				<div class="previous"><?php next_posts_link('Articles précedents'); ?></div>
				<div class="next"><?php previous_posts_link('Articles suivants'); ?></div>
			</div>
		</section>
<?php endif; ?>

	</div><!-- .column-main -->
<?php get_footer(); ?>