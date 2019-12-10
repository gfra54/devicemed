<?php get_header(); ?>

<div class="row column-content page-search">
	<div class="col-md-9 col-sm-8 column-main">

		<section class="results">
			<?php while (have_posts()): the_post(); ?>
				<article>

					<h1 class="title"><?php echo $title = get_the_title(); ?></h1>

					<div class="content">
						<?php //echo wp_get_attachment_image(get_the_ID());?>

						<?php $termes = array_slice(explode('-',sanitize_title($title)),0,1);
						$params = [
							's' => implode(' ',$termes)
						];
						$query = new WP_Query($params);

						if ( $query->have_posts() ) {
							foreach($query->posts as $post) {
								get_template_part( 'content', 'search' );
							}

						}?>

					</div>

				</article>

			</section>
		<?php endwhile; ?>
	</div><!-- .column-main -->
	<?php get_footer(); 

