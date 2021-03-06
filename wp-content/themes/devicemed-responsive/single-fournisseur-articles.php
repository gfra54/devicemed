<?php if($fournisseur['premium']) {?>
		<section class="posts read-more">
<?php 
$deja=array();
$alternatives = explode("\n",$fournisseur['alternatives_nom']);
$alternatives[] = $fournisseur['nom'];
foreach($alternatives as $alternative) { $alternative = sanitize_title(trim($alternative));if($alternative) {

	query_posts("tag=".$alternative); ?>
	<?php if (have_posts()){ ?>
				<?php while (have_posts()){ the_post(); $pid = get_the_ID();if(!isset($deja[$pid])) { $deja[$pid]=true;?>
					<article>
						<a href="<?php echo get_permalink($pid); ?>">
							<span class="left">
								<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($pid)): ?>
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
										$items=array();
										foreach ($categories as $category){
											$items[] = '<span class="category">'.$category->cat_name.'</span>';
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
				<?php }} ?>
	<?php } ?>
	<?php } ?>
<?php }?>
		</section>
<?php }


