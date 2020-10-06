<article>
	<a href="<?php echo get_permalink($post->ID); ?>">
		<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): ?>
			<figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
				<img src="<?php echo $thumbnail->url; ?>" title="<?php echo $thumbnail->post_title; ?>" />
			</figure>
		<?php endif; ?>
		<header>
			<h2 class="title"><?php echo toUpperSpecial($post->post_title); ?></h2>
		</header>
		<p class="excerpt"><?php echo get_the_excerpt(); ?></p>
		<a class="more" href="<?php echo get_permalink($post->ID); ?>">Lire la suite</a>
	</a>
</article>