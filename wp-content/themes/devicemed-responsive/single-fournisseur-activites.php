<section class="products read-more">
	<?php foreach($fournisseur['categories'] as $categorie){?>
		<h2><a href="<?php echo $categorie['url'];?>"><?php echo $categorie['nom'];?></a></h2>
		<?php foreach($categorie['categories'] as $sous_categorie) {?>
			<a href="<?php echo $sous_categorie['url'];?>"><?php echo $sous_categorie['nom'];?></a><br>
		<?php }?>
	<?php }?>

</section>