<?php

?>
<div id="sidebar" class="column col-md-3 col-sm-4 column-sidebar">
	<?php afficher_pub_js('site-colonne');?>

	<?php afficher_pub('cadre-video');?>

	<?php include_once("agenda.php"); ?>

	<section id="sidebar-issues" class="article_numero_sidebar">
	<?php 
	$args = array( 
		'posts_per_page'=>1,
		'order'=>'DESC',
		'orderby'=>'date',
		'category_name'=> 'magazine'
    );
	if($posts = new WP_Query($args)) {
		foreach($posts->posts as $post) {
    	$cover = get_the_post_thumbnail_url($post->ID,'full'); 
    	$url = get_permalink($post->ID);
    	$titre = get_field('initutle',$post->ID);
		?>

		<header>
			<div class="right-side">
				<h1 class="title"><a href='<?php echo $url;?>'>Dernier numÃÂ©ro</a></h1>
			</div>
		</header>	
		<a href="<?php echo $url;?>" target="_blank" title="<?php echo $titre;?>">
		<article class="article_numero">
			<img class="cta" src="<?php echo get_template_directory_uri(); ?>/images/cta-magazine.png">
			<img src="<?php echo $cover;?>" width=100%/>
		</article></a>
		<?php
			}
		}
		?>
		<a href="/archives" class="more">Consulter d'autres numÃÂ©ros</a>
	</section>
	
	<section id="sidebar-fiches">
		<header>
			<div class="right-side">
				<h1 class="title">Fournisseurs partenaires</h1>
			</div>
		</header>	
		<article>
			<?php
				$cpt=0;
				foreach(get_fournisseurs(array('premium'=>true)) as $fournisseur) {?>
					<a title="<?php echo $fournisseur['nom'];?>" href="<?php echo $fournisseur['permalink'];?>" style="background-image:url(<?php echo $fournisseur['logo'] ?>)" class='logo_supplier'>
						<img src="<?php echo $fournisseur['logo'] ?>" />
					</a>
				<?php $cpt++;}
				if($cpt%2) {?>
					<a title="Voir la liste des fournisseurs" href="/suppliers/" class='logo_supplier'>
						Voir tous les fournisseurs &raquo;
					</a>

				<?php }
			?>
		</article>
	</section>
	<section id="sidebar-tag">
		<header>
			<div class="right-side">
				<h1 class="title">On en parle</h1>
			</div>
		</header>	
		<article>
			<?php
				echo "<h3 class='title2'><a href=\"/tag/implant\" target='_blank'>Implants</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/moulage\" target='_blank'>Moulage</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/medtec\" target='_blank'>Medtec</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/impression-3d\" target='_blank'>Impression 3D</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/iso-13485\" target='_blank'>ISO 13485</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/usinage\" target='_blank'>Usinage</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/pharmapack\" target='_blank'>Pharmapack</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/salle-blanche\" target='_blank'>Salle blanche</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/instrument-chirurgical\" target='_blank'>Instruments chirurgicaux</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/mesure-3d\" target='_blank'>Mesure 3D</a></h3><br />";
				echo "<h3 class='title2'><a href=\"/tag/tracabilite\" target='_blank'>TraÃÂ§abilitÃÂ©</a></h3><br />";
			?>
		</article>
	</section>
	<!--<section id="sidebar-tag">
		<?php wp_tag_cloud('number=10'); ?>
	</section>-->
</div>