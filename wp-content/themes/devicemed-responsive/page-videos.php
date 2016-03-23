<?php
/*
Template Name: videos
*/
?>
<?php get_header(); ?>
<style>#sidebar #sidebar-issues.cadre-video {display: none !important;}</style>


<div class="row column-content page-search">
	<div class="col-md-9 col-sm-8 column-main">

	<section class="videos">
			<h2 class="title">Archives des vidéos</h2>


			<?php foreach(get_pubs('cadre-video') as $video) {?>

			<div class="bloc-item"><?php echo display_pub($video,array(),'cadre-video');?></div>

			<?php }?>
		</section>

	</div>
<?php get_footer(); ?>

