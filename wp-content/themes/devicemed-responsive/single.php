<?php 
	get_header(); ?>


	<div class="row column-content page-single">
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
			<?php if ($categories = get_the_category()): ?>
			<?php
	//			$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				
				if(strstr($_SERVER['REQUEST_URI'], 3671)===false) {
			?>
			<div class="categories">

					<?php 
					$cat_sort = array();
					foreach($categories as $cpt=>$categorie){
						if($categorie->category_parent) {
							if(!isset($cat_sort[$categorie->category_parent]))  {
								$cat_sort[$categorie->category_parent] = array();
							}
							$cat_sort[$categorie->category_parent][] = $categorie;
						} else {
							if(!isset($cat_sort[$categorie->term_id]))  {
								$cat_sort[$categorie->term_id] = true;
							}
						}
					}
					foreach($cat_sort as $cat => $scats) {
						$cat = get_term($cat,'category');
						echo '<span class="category_principal">'.$cat->name.'</span>';
						if(is_array($scats)) {
							echo ' > <span class="category">';
							foreach($scats as $cpt=>$scat)  {
								if($cpt) {
									echo ', ';
								}
								echo $scat->name;
							}
							echo '</span>';
						}
						echo '<br>';
					}
				?>
			</div>
			<?php } ?>
			<?php endif; 
			if($is_magazine=in_category('magazine',$post->ID)) {
				$url_pdf = get_field('fichier_pdf',$post->ID);?>
				<style>.article_numero_sidebar {display:none;}</style>
				<h1 class="title"><?php echo get_field('intitule',$post->ID); ?></h1>
				<div class="content">
					<p><?php echo get_field('libelle_de_publication',$post->ID); ?></p>
				</div>

				<?php
					$thumbnail = get_post(get_post_thumbnail_id($post->ID));
					?>
					<a href="<?php echo $url_pdf;?>" class="magazine-cover-big">
					<img class="cta" src="<?php echo get_template_directory_uri(); ?>/images/cta-magazine.png">
					<img class="cover" src="<?php echo wp_get_attachment_url($thumbnail->ID);?>">
					</a>
					<center><a href="<?php echo $url_pdf;?>">Cliquez sur la couverture pour consulter le magazine</a></center>
					<?php
			} else {?>
				<h1 class="title"><?php echo get_the_title(); ?></h1>
				<?php if(strstr($_SERVER['REQUEST_URI'], 3671)===false) { ?>
					<div class="metas">
						<span class="date-wrapper">Publié le <span class="date"><?php echo get_the_date('d F Y'); ?></span></span>
						<span class="author-wrapper">par <span class="author"><?php the_author(); ?> </span></span>
					</div>
				<?php } 
					if(!masquer_image_a_la_une($post->ID)) {
					$image_au_clic = image_au_clic($post->ID);
					if($image_non_recadree = image_non_recadree($post->ID)) {
						$image_au_clic =  $image_au_clic ? $image_au_clic['url'] : $image_non_recadree['url'];?>
						<div class="article-image article-image-non-recadree">
							<a href="<?php echo $image_au_clic;?>"><img src="<?php echo $image_non_recadree['url'] ?>" title="<?php echo esc_attr(sinon($image_non_recadree,'description','caption')); ?>" /></a>
							<div class='source_photo'>
								<div class="source-content">Source : <?php echo esc_attr(sinon($image_non_recadree,'title')); ?></div>
							</div>
							<?php if($legende = sinon($image_non_recadree,'caption')) { ?>
								<div class='legende_photo'><?php echo $legende; ?></div>
							<?php } ?>
						</div>
						<?php } else
					if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)) { 
						$image_au_clic =  $image_au_clic ? $image_au_clic['url'] : $thumbnail->url;
		/* 				if($fi = $dynamic_featured_image->get_featured_images()) {
							$url = $fi[0]['full'];
							?>
							<a class="lien-photo" href="<?php echo $thumbnail->url; ?>"><img src="<?php echo $url;?>" style="width:100%"></a>
							<div class='source_photo_horizontale'><div class="source-content">Source : <?php echo esc_attr($thumbnail->post_title); ?></div></div>
							<?php
						} else {*/

					?>
						<div class="article-image">
						<div class='image_clicable'><a href="<?php echo $image_au_clic; ?>"><figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
							<img src="<?php echo $thumbnail->url ?>" title="<?php echo esc_attr($thumbnail->post_title); ?>" />
						</figure></a></div>
						<div class='source_photo'><div class="source-content">Source : <?php echo esc_attr($thumbnail->post_title); ?></div></div>
						<?php if($thumbnail->post_excerpt != '') { ?>
							<div class='legende_photo'><?php echo $thumbnail->post_excerpt; ?></div>
						<?php } ?>
						</div>
					<?php //}
					}
				}
			} ?>
			<div class="content">
				<?php 
					the_content(); 
				?>
			<?php if($is_magazine) {?>
				<p>Pour recevoir notre magazine papier gratuitement chez vous, <a href="/magazine/abonnement">abonnez-vous sur cette page</a>. Le magazine est aussi <a href="<?php echo $url_pdf;?>">téléchargeable en PDF à cette adresse</a>.</p>
				<p>Vous pouvez aussi consulter <a href="/archives">les archives de nos anciens numéros</a>.
			<?php }?>
			</div>
			<?php $images = get_children(array ('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image')); ?>
			<?php if (empty($images)): ?>
			<?php else: ?>
			<?php endif; ?>

		</article>
	</section>

	<?php if(strstr($_SERVER['REQUEST_URI'], 3671)===false) { ?>
		
		<?php
			$posttags = get_the_tags();
			if ( $posttags ) {
				$tags='';
				foreach( $posttags as $tag ) {

					if(strtolower(substr($tag->name,0,3)) != 'nl-') {
						if($tag->name != 'reseaux-sociaux') {
							$tags.=$prefix . '<div class="mot_cle"><a href="' . get_tag_link( $tag->term_id ) . '" target="_blank">' . $tag->name . '</a></div>';
						}
					}
				}
				if($tags) {
					echo '<section class="tags_posts"><div class="titre_mot_cle">Mots-clés :</div> '.$tags.'</section>';
				}

			}
		?>
		
		<section class="social">
				Suivez l'actualité de DeviceMed sur les réseaux sociaux :
				<div class="social-boutons">
				<a href="https://twitter.com/DeviceMedFr"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-couleur.png"> Twitter</a>
				<a href="https://fr.linkedin.com/company/devicemed-france"><img src="<?php echo get_template_directory_uri(); ?>/images/linkedin-couleur.png"> LinkedIn</a>
				</div>
		</section>
		<?php if(!$is_magazine) {?>
		<section class="relateds">
			<!-- Encart afficher titres articles de la même catégorie -->
			<?php
				$relateds = get_related($post->ID);
			  ?>
			 
			  <h2 class="title">A lire aussi</h2>
			  <div class="related-articles">
			  <?php foreach($relateds as $related) {
			  	list($image) = wp_get_attachment_image_src(get_post_thumbnail_id($related->ID),'large');
			  	?>
			  <a class="related-article" href="<?php echo get_the_permalink($related->ID);?>" style="background-image:url(<?php echo $image;?>)">
			  	<span class="related-titre"><?php 
			  	$titre = $related->post_title;
			  	$pre = wp_trim_words( $titre,8, '' );
			  	echo $pre;
			  	if(strlen($titre)>strlen($pre)) {
			  		echo '<span class="ellipsis">&hellip;</span>';
			  		echo '<span class="reste">'.str_replace($pre,'',$titre).'</span>';
			  	}
			  	?></span>
			  </a>
			  <?php }?>
			  </div>
			<!-- fin encart afficher titres articles de la même catégorie en cours -->
		</section>
		<?php } ?>
	<?php } ?>
	<?php endwhile; ?>
		</div><!-- .column-main -->
	<?php get_footer(); ?>