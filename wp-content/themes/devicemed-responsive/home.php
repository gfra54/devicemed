<?php 
/*
Template Name: home
*/
	if(isset($_GET['url']) && $_GET['url'] != '') {
		$banniere_model = new DM_Wordpress_Banniere_Model();
		if($banniere_model->clic_banniere($_GET['id'])) {
			if(isset($_GET['no_cache']) && isset($_GET['L'])) {
				$url = $_GET['url'];
				$url = $url .'&no_cache=1&L=2';
			}else {
				$url = $_GET['url'];
			}
			wp_redirect($url);
		}
	}
get_header(); 

$slider = get_posts(array(
	'numberposts'	=> 6,
	'post_type'		=> 'post',
	'post__in'		=> get_option( 'sticky_posts' )
));
?>
<section id="last-posts-featured">
	<div class="slider">
<?php $featured = array(); foreach ($slider as $post): setup_postdata($post); $featured[] = $post->ID; ?>
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
				<a class="more" href="<?php echo get_permalink($post->ID); ?>">Lire la suite</a>
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

<div class="row column-content page-home">
	<div class="col-md-9 col-sm-8 column-main">
			
<?php

$deja = array();
$categories = array(5,8,7,6,4,3,9);

foreach(wp_get_nav_menu_items('page-daccueil') as $menuitem):
	$category_id = $menuitem->object_id;
	$category = get_category($category_id);
	$posts = devicemed_home_get_last_posts_by_category($category_id, 6);
	// $posts_per_column = floor(count($posts) / 2);
?>
<section class="home-last-posts">
	<div class="section-header">
		<h1 class="title"><a href="<?php echo get_category_link($category->cat_ID); ?>"><?php echo $category->name; ?></a></h1>
	</div>
	<div class="section-column-left">
<?php
	$qte=1;
	while((list(,$post) = each($posts)) && $qte) {
		if(empty($deja[$post->ID])) {
			$deja[$post->ID]=true;
			$qte--;
			setup_postdata($post);
			get_template_part('home/last-posts');
		}
	}
?>
	</div>
	<div class="section-column-right">
<?php
	$qte=2;
	while((list(,$post) = each($posts)) && $qte) {
		if(empty($deja[$post->ID])) {
			$deja[$post->ID]=true;
			$qte--;
			setup_postdata($post);
			get_template_part('home/last-posts');
		} 
	}
?>
	</div>
</section>
<?php endforeach; ?>
<section class="home-gallery">
	<div class="section-header">
		<h1 class="title"><a href='/galeries'>Galerie</a></h1>
	</div>
	<div class="section-gallery-wrapper">
		<ul>
<?php
$query = new WP_Query(array('post_status' => 'published', 'post_type' => 'attachment', 'posts_per_page' => 30, 'orderby' => 'rand')); 
foreach ($query->posts as $post) {
	list($image_url, $image_width, $image_height) = wp_get_attachment_image_src($post->ID, 'medium');
	echo '<li><a href="'.get_permalink($post->post_parent).'" style="background-image:url('.$image_url.');"><img src="'.$image_url.'" width="'.$image_width.'" /></a></li>';
}
?>
		</ul>
	</div>
</section>
<script type="text/javascript">
$(document).ready(function() {

$('section.home-gallery .section-gallery-wrapper ul').bxSlider({
	auto: true,
	autoHover: true,
	mode: 'horizontal',
	controls: false,
	minSlides: 4,
	maxSlides: 4,
	slideWidth: '250px',
	slideMargin: 10
});

});
</script>

<section class="home-subscribe">
	<div class="section-header">
		<h1 class="title">Abonnez-vous</h1>
	</div>
	<a href='<?php echo home_url().'/newsletter/inscription'; ?>'><div class="section-newsletter">
		<div class="icon"></div>
		<div class="content">
			<span class="title">Newsletter</span>
		</div>
	</div></a>
	<a href='<?php echo home_url().'/magazine/abonnement'; ?>'><div class="section-magazine">
		<div class="icon"></div>
		<div class="content">
			<span class="title">Magazine</span>
		</div>
	</div></a>
</section>

</div><!-- .column-main -->
<?php 

get_footer(); ?>
