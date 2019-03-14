<?php if($fournisseur['documentation']) {?>
	<section class="liste-documents">
		<?php foreach ($fournisseur['documentation'] as $url => $titre){ 
			$icone = gen_icone_pdf(urlToPath($url));
			?>
			<a class="liste-document-item"  href="<?php echo $url;?>">
					<img src="<?php echo $icone;?>"/>
					<div class="legende"><?php echo $titre;?></div>
				</figure>
			</a>

		<?php }?>

	</section>
<?php }?>