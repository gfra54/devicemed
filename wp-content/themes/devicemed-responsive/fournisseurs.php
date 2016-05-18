<?php
/*
Template Name: fournisseurs
*/

if(check('excel')) {
	telecharger_fournisseurs();
}
get_header(); 
?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="profile">
		<h2 class="title">Les fournisseurs des fabricants de dispositifs médicaux</h2>

			<b class='title5'><big>Consulter la 
			<a class="link" href="/fournisseurs_partenaires">liste des fournisseurs partenaires</a></big></b>
			<br />
			<br />
			<b class='title5'><big>Comment trouver un fournisseur...</big></b>
			<h3 class='title5'><p class='par_nom_motcle'>1- Par son nom ou par mot-clé :</p> 
			<form name='search_suppliers' method='GET' action='/'>
			<input type='hidden' name='post_type' value="fournisseur" />
			<input type='text' name='s' placeHolder='Rechercher...' />
			<input type='submit' value='Rechercher' />
			</form>
			</h3><br />

			<div id='suppliers_autocomplete'></div>
			<h3 class='title5'>
				2- Par son initiale : <?php fournisseurs_filtre_lettres();?>
			</h3><br />
			<b class='title5'>3- Par la liste alphabétique complète</b>
			<a class="link" href='/fournisseurs-liste'>Voir la liste des fournisseurs</a><br /><br>
			 <h3 class='title52'>4- Par sa catégorie de produits et services</h3>
			<div id='bloc_categories_fournisseurs'>
				<?php
					$categories = fournisseur_categories();
					fournisseurs_filtre_categories($categories);
				?>
			</div>
			<div class='bloc_infos_fournisseurs'>
				<div class='image_repertoire'><img src='<?php echo get_template_directory_uri(); ?>/images/sidebar-issues-icon.png' /></div>
				<div class='texte_repertoire'>
					Le répertoire existe en version papier au sein du Guide de l'acheteur.<br />
					<?php if ($session = DM_Wordpress_Members::session()): ?>
						<a href='/wp-content/uploads/archives/pdf/juillet_aout2014.pdf' target='_blank'><b>Accéder au PDF du guide.</b></a>
					<?php else: ?>
						<span id='bloc_guide_acheteur2'><b>Accéder au PDF du guide.</b></span>
					<?php endif; ?>
				</div>
			</div>
			<div class='bloc_infos_fournisseurs'>
				<div class='image_repertoire'><img src='<?php echo get_template_directory_uri(); ?>/images/sidebar-supplier-registration-icon.png' /></div>
				<div class='texte_repertoire'>Vous êtes fournisseur des fabricants de dispositifs médicaux ?<br /><a href='/suppliers/inscription'><b>Figurez, vous aussi dans le répertoire. C'est rapide et gratuit.</b></a></div>
			</div>
		<!--<p class='noms_suppliers'>
			<a href='/suppliers/accessoires-in-vitro/clippard-europe-s-a/5'>Clippard Europe S.A.</a><br />
			<a href='/suppliers/pompes-et-valves/qosina/6'>Qosina</a>
		</p>-->
	</section>
</div><!-- .column-main -->
<!-- FOOTER -->
<?php get_footer(); ?>
<script>$('#sidebar-fiches').prependTo('#sidebar');</script>
