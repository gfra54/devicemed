<?php 
	get_header(); ?>
	<div class="row column-content page-single">
		<div class="col-md-9 col-sm-8 column-main">

	<section class="article">
	<?php while (have_posts()): the_post(); ?>
		<article>
			<!--<div class="export">
				<ul>
					<li class="printer"><a href="?export_printer" title="Version imprimable">Imprimer</a></li>
					<li class="printer"><a href="?export_printer" title="Version PDF">PDF</a></li>
					<li class="printer"><a href="?export_printer" title="Partager">Partager</a></li>
				</ul>
			</div>-->
			<?php if ($categories = get_the_category()): ?>
			<?php
	//			$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				
				if(strstr($_SERVER['REQUEST_URI'], 3671)===false) {
			?>
			<div class="categories">

					<?php 
					$cat_sort = array();
					foreach($categories as $cpt=>$categorie){
						if($categorie->category_parent) {
							if(!isset($cat_sort[$categorie->category_parent]))  {
								$cat_sort[$categorie->category_parent] = array();
							}
							$cat_sort[$categorie->category_parent][] = $categorie;
						} else {
							if(!isset($cat_sort[$categorie->term_id]))  {
								$cat_sort[$categorie->term_id] = true;
							}
						}
					}
					foreach($cat_sort as $cat => $scats) {
						$cat = get_term($cat,'category');
						echo '<span class="category_principal">'.$cat->name.'</span>';
						if(is_array($scats)) {
							echo ' > <span class="category">';
							foreach($scats as $cpt=>$scat)  {
								if($cpt) {
									echo ', ';
								}
								echo $scat->name;
							}
							echo '</span>';
						}
						echo '<br>';
					}
				?>
			</div>
			<?php } ?>
			<?php endif; ?>
			<h1 class="title"><?php echo get_the_title(); ?></h1>
			<?php if(strstr($_SERVER['REQUEST_URI'], 3671)===false) { ?>
				<div class="metas">
					<span class="date-wrapper">Publié le <span class="date"><?php echo get_the_date('d F Y'); ?></span></span>
					<span class="author-wrapper">par <span class="author"><?php the_author(); ?> </span></span>
				</div>
			<?php } 
			if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): 

/* 				if($fi = $dynamic_featured_image->get_featured_images()) {
					$url = $fi[0]['full'];
					?>
					<a class="lien-photo" href="<?php echo $thumbnail->url; ?>"><img src="<?php echo $url;?>" style="width:100%"></a>
					<div class='source_photo_horizontale'><div class="source-content">Source : <?php echo esc_attr($thumbnail->post_title); ?></div></div>
					<?php
				} else {*/

			?>
				<div class="article-image">
				<div class='image_clicable'><a href="<?php echo $thumbnail->url; ?>" class="cboxElement"><figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
					<img src="<?php echo $thumbnail->url ?>" title="<?php echo esc_attr($thumbnail->post_title); ?>" />
				</figure></a></div>
				<div class='source_photo'><div class="source-content">Source : <?php echo esc_attr($thumbnail->post_title); ?></div></div>
				</div>
				<?php if($thumbnail->post_excerpt != '') { ?>
					<div class='legende_photo'><?php echo $thumbnail->post_excerpt; ?></div>
				<?php } ?>
			<?php //}

			endif; ?>
			<div class="content">
				<?php 
					the_content(); 
				?>
			</div>

			<?php $images = get_children(array ('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image')); ?>
			<?php if (empty($images)): ?>
			<?php else: ?>
			<!--<div class="images">
				<ul>
			<?php foreach ($images as $attachment_id => $attachment): ?>
					<li><a href="<?php echo wp_get_attachment_url($attachment_id); ?>"><?php echo wp_get_attachment_image($attachment_id, 'thumbnail'); ?></a></li>
			<?php endforeach; ?>
				</ul>
			</div>-->
	<script type="text/javascript">
	/*$(function() {
		$('.image_clicable a').colorbox();
	});*/
	</script>
			<?php endif; ?>

		</article>
	</section>

	<!--<section class="related-articles">
		<h2 class="title">Articles en relation</h2>
	<?php if ($related_articles = devicemed_single_get_related_posts()): ?>
		<ul>
	<?php foreach ($related_articles as $related_article): ?>
			<li><a href="<?php echo get_the_permalink($related_article->ID); ?>" title="<?php echo esc_attr(get_the_title($related_article->ID)); ?>"><?php echo get_the_title($related_article->ID); ?></a></li>
	<?php endforeach; ?>
		</ul>
	<?php else: ?>
		Aucun article en relation.
	<?php endif; ?>
	</section>-->

	<!--<section class="related-category-articles">
		<h2 class="title">Dans la même catégorie</h2>
	<?php if ($related_articles = devicemed_single_get_related_category_posts()): ?>
		<ul>
	<?php foreach ($related_articles as $related_article): ?>
			<li><a href="<?php echo get_the_permalink($related_article->ID); ?>" title="<?php echo esc_attr(get_the_title($related_article->ID)); ?>"><?php echo get_the_title($related_article->ID); ?></a></li>
	<?php endforeach; ?>
		</ul>
	<?php else: ?>
		Aucun autre article dans cette catégorie.
	<?php endif; ?>
	</section>-->
	<?php if(strstr($_SERVER['REQUEST_URI'], 3671)===false) { ?>
		<section class='tags_posts'>
		<?php
			$posttags = get_the_tags();
			if ( $posttags ) {
				$prefix = '<div class="titre_mot_cle">Mots-clés :</div> ';
				foreach( $posttags as $tag ) {

					if(strtolower(substr($tag->name,0,3)) != 'nl-') {
						echo $prefix . '<div class="mot_cle"><a href="' . get_tag_link( $tag->term_id ) . '" target="_blank">' . $tag->name . '</a></div>';
						$prefix = ' ';
					}
				}
			}
		?>
		</section>
		<section class='tags_posts'>
			<!-- Encart afficher titres articles de la même catégorie -->
			<?php
				$related = get_related($post->ID);
			  ?>
			 
			  <h2 class="title">Articles similaires :</h2>
			<ul class="widget-container">
			<?php echo $categoryPosts; ?>
			</ul>
			<!-- fin encart afficher titres articles de la même catégorie en cours -->
		</section>
	<?php } ?>
	<!--<section class="comments">
		<h2 class="title">Commentaires</h2>
		Les commentaires sont fermés pour cet article.
	</section>-->
	<?php /*
	<section class="copyright">
		Ce texte est protégé par les droits d'auteur. Si vous désirez l'utiliser pour des besoins personnels veuillez consulter les conditions suivantes sur www.mycontentfactory.de (ID: 42691422) | Fotos: Source : Solvay Specialty Polymers
	</section>
	*/ ?>
	<?php endwhile; ?>
		</div><!-- .column-main -->
	<?php get_footer(); ?>