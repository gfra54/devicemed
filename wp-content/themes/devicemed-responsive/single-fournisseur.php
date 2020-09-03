<?php if($fournisseur = fournisseur_enrichir($wp_query->post)){

	get_header();?>

<div class="row column-content page-supplier">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="results">
		<h2 class="title"><?php echo esc_html($fournisseur['nom']); ?></h2>
		<div class='retour_recherche_fournisseur'>
			<a href='/suppliers/'>
				Retour à la page de recherche d’un fournisseur
			</a>
		</div>
	</section>
	<?php fournisseur_nouveautes($fournisseur);?>
	<?php fournisseur_menu($fournisseur);?>
	<?php fournisseur_sections($fournisseur);?>

</div><!-- .column-main -->
<!-- FOOTER -->
<?php get_footer(); 

}
