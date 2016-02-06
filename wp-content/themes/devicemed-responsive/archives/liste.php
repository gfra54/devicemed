<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="catalogues">
		<h2 class="title">Tous nos numéros</h2>
		<div id='soustitre_archives'>Pour recevoir gratuitement le magazine papier, <a href="/magazine/abonnement" target="_blank"><b>cliquez ici</b></a>.</div>
		<div id='contenu_archives'>
			<?php if ($session = DM_Wordpress_Members::session()) { ?>
				<?php 
					$urlTemp = get_bloginfo('url');
					
					foreach ($archives as $archive):
						$urlImg = $urlTemp ."/wp-content/uploads/archives/apercu/". $archive['apercu_archive'];
						$lienPdf = $urlTemp ."/wp-content/uploads/archives/pdf/". $archive['pdf_archive'];
				?>
				<a href='<?php echo $lienPdf; ?>' target='_blank'>
					<article class='archive'>
						<figure><img src='<?php echo $urlImg; ?>' /></figure>
						<div class='nom_catalogue'><?php echo $archive['titre_archive']; ?></div>
					</article>
				</a>
				<?php
					endforeach;
				?>
			<?php }else { ?>
				<?php 
					$urlTemp = get_bloginfo('url');
					
					foreach ($archives as $archive):
						$urlImg = $urlTemp ."/wp-content/uploads/archives/apercu/". $archive['apercu_archive'];
						$lienPdf = $urlTemp ."/wp-content/uploads/archives/pdf/". $archive['pdf_archive'];
				?>
					<a href='<?php echo $lienPdf; ?>' target='_blank'>
						<article class='archive'>
							<figure><img src='<?php echo $urlImg; ?>' /></figure>
							<div class='nom_catalogue'><?php echo $archive['titre_archive']; ?></div>
						</article>
					</a>
				<?php
					endforeach;
				?>
			<?php } ?>
		</div>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>