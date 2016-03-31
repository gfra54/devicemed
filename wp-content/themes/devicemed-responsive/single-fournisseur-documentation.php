	<section class="liste-documents">
			<?php foreach ($fournisseur['documentation'] as $url => $titre){ ?>
				<a class="liste-document-item"  href="<?php echo $url;?>">
						<img src="<?php echo get_template_directory_uri();?>/images/pdf.png"/>
						<div class="legende"><?php echo $titre;?></div>
					</figure>
				</a>

			<?php }?>

	</section>
