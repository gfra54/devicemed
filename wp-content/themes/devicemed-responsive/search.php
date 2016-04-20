<?php
/**
 * Template Name: recherche
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>
<style>
.screen-reader-text {
	display: none;
}
</style>

		

<div class="row column-content page-search">
	<div class="col-md-9 col-sm-8 column-main">

		<section class="results">

		<?php
		if(isset($_GET['s'])) {
			if ( have_posts() ) {?>
				<h2 class="title">Résultats trouvés pour "<span id="search_query"><?php echo get_search_query(); ?></span>"</h2>
				<?php 
				// Start the loop.
				while ( have_posts() ) : the_post(); ?>

					<?php
					/*
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'content', 'search' );

				// End the loop.
				endwhile;

				// Previous/next page navigation.
				the_posts_pagination( array(
					'mid_size'			=> 10,
					'show_all'			=>true,
					'prev_text'          => 'Retour &nbsp;',
					'next_text'          => '&nbsp; Suite',
					'before_page_number' => '',
				) );

			// If no content, include the "No posts found" template.
			} else {?>
				<center>

				<p><i>Aucun résultat trouvé.</i></p>

				<h3 class="title5">Faire une nouvelle recherche</h3>
				<div class="search">
				<form role="search" method="get" action="/">
					<input type="text" name="s" placeholder="Rechercher dans les articles" value="<?php echo htmlspecialchars($_GET['s']);?>">
					<input type="submit" value="Rechercher">
				</form>
				</div>
				</center>
			<?php }
			} else {?>
				<center>
				<h3 class="title5">Faire une recherche</h3>
				<div class="search">
				<form role="search" method="get" action="/">
					<input type="text" name="s" placeholder="Rechercher dans les articles" value="<?php echo htmlspecialchars($_GET['s']);?>">
					<input type="submit" value="Rechercher">
				</form>
				</div>
				</center>
			<?php }
		?>
		</section>
	</div>

<?php get_footer(); ?>

<script>
$('.results ARTICLE').each(function(){
	if(_href = $(this).find('a').attr('href')) {
		if(_href.indexOf('/pubs/')>-1) {
			$(this).remove();
		}
	}
});


$('.results .right').each(function(){
		var src_str = $(this).html();
		var term = $('#search_query').html();
		term = term.replace(/(\s+)/,"(<[^>]+>)*$1(<[^>]+>)*");
		var pattern = new RegExp("("+term+")", "gi");

		src_str = src_str.replace(pattern, "<strong>$1</strong>");
		src_str = src_str.replace(/(<strong>[^<>]*)((<[^>]+>)+)([^<>]*<\/strong>)/,"$1</strong>$2<strong>$4");

		$(this).html(src_str);
})
</script>