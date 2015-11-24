<section id="last-posts-featured">
	<div class="slider">
<?php $featured = array(); foreach (devicemed_home_get_featured_posts(6) as $post): setup_postdata($post); $featured[] = $post->ID; ?>
		<article>
			<a href="<?php echo get_permalink($post->ID); ?>">
			<div class="col-md-8 col-sm-8 column-right">
<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): ?>
				<figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
					<img src="<?php echo $thumbnail->url; ?>" title="<?php echo $thumbnail->post_title; ?>" />
				</figure>
<?php endif; ?>
			</div>
			<div class="col-md-4 col-sm-4 column-left">
				<header>
					<h1 class="title"><?php the_title(); ?></h1>
				</header>
				<p class="excerpt"><?php echo get_the_excerpt(); ?></p>
				<a class="more" href="#">Lire la suite</a>
			</div>
			</a>
		</article>
<?php endforeach; ?>
	</div>
</section>
<script type="text/javascript">
$(document).ready(function() {

$('#last-posts-featured .slider').bxSlider({
	auto: true,
	autoHover: true,
	mode: 'horizontal',
	controls: false
});

});
</script>