<?php if(count($fournisseur['categories'])) {?>
<section class="products read-more">
	<?php foreach($fournisseur['categories'] as $categorie){?>
		<?php if($categorie['niveau'] == 1) {?>
			<h2><a href="<?php echo $categorie['url'];?>"><?php echo $categorie['nom'];?></a></h2>
		<?php } else {?>
			<h4><a href="<?php echo $categorie['url'];?>"><?php echo $categorie['nom'];?></a></h4>
		<?php }?>
		<?php foreach($categorie['categories'] as $sous_categorie) {?>
			<a href="<?php echo $sous_categorie['url'];?>"><?php echo $sous_categorie['nom'];?></a><br>
		<?php }?>
	<?php }?>

</section>
<?php }?>