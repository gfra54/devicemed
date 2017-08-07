<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="catalogues">
		<h2 class="title">Tous nos numéros</h2>
		<div id='soustitre_archives'>Pour recevoir gratuitement le magazine papier, <a href="/magazine/abonnement" target="_blank"><b>cliquez ici</b></a>.</div>
		<div id='contenu_archives'>
			<?php 

				$urlTemp = get_bloginfo('url');
				$liste = array();
				$args = array( 
					'order'=>'DESC',
					'orderby'=>'date',
					'category_name'=> 'magazine',
					'meta_key' => 'fichier_pdf',
					'meta_value' => '',
					'meta_compare' => '!=',
				);

				if($posts = new WP_Query($args)) {
					foreach($posts->posts as $post) {
						$liste[] = array(
							'image'=>get_the_post_thumbnail_url($post->ID,'post-thumbnail'),
							'lien'=>get_permalink($post->ID),
							'nom'=>get_field('intitule',$post->ID)
						);
					}
				}

				
				foreach ($archives as $archive) {
					$liste[] = array(
						'image'=>$urlTemp ."/wp-content/uploads/archives/apercu/". $archive['apercu_archive'],
						'lien'=>$urlTemp ."/wp-content/uploads/archives/pdf/". $archive['pdf_archive'],
						'nom'=>$archive['titre_archive']
					);
				}
			?>
			<?php foreach($liste as $magazine){ ?>
				<a href="<?php echo $magazine['lien']; ?>" target="_blank">
					<article class="archive">
						<figure><img src="<?php echo $magazine['image']; ?>" /></figure>
						<div class="nom_catalogue"><?php echo $magazine['nom']; ?></div>
					</article>
				</a>
			<?php }?>
		</div>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>