<?php if(count($fournisseur['categories'])) {?>
<section class="products read-more">
	<?php foreach($fournisseur['categories'] as $categorie){?>
		<h2><a href="<?php echo $categorie['url'];?>"><?php echo $categorie['nom'];?></a></h2>
		<?php foreach($categorie['categories'] as $sous_categorie) {?>
			<?php if($sous_categorie['categories']){?>
				<b><a href="<?php echo $sous_categorie['url'];?>"><?php echo $sous_categorie['nom'];?></a></b><br>
				<?php foreach($sous_categorie['categories'] as $sous_sous_categorie) {?>
					&nbsp; &nbsp; &nbsp; <a href="<?php echo $sous_sous_categorie['url'];?>"><?php echo $sous_sous_categorie['nom'];?></a><br>
				<?php }?>
			<?php } else {?>
				<a href="<?php echo $sous_categorie['url'];?>"><?php echo $sous_categorie['nom'];?></a><br>
			<?php }?>
		<?php }?>
	<?php }?>

</section>
<?php }?>