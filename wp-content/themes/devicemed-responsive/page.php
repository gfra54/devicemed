<?php get_header(); ?>
<div class="row column-content page-page">
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
		<h1 class="title"><?php echo get_the_title(); ?></h1>
		<!--<div class="metas">
			<span class="date-wrapper">Le <span class="date"><?php echo get_the_date('l d F Y'); ?></span></span>
			<span class="author-wrapper">par <span class="author"><?php echo get_the_author(); ?></span></span>
		</div>-->
		<div class="content"><?php echo $post->post_content; ?></div>
	</article>
</section>
<?php endwhile; ?>
	</div><!-- .column-main -->
<?php get_footer(); ?>