<?php if(count($fournisseur['gallerie'])) {?>
<section class="gallerie">
	<?php foreach ($fournisseur['gallerie'] as $photo){ ?>
		<a class="gallerie-photo" rel="gallery" href="<?php echo $photo['url'];?>">
			<figure>
				<img src="<?php echo $photo['sizes']['thumbnail'];?>"/>
				<div class="legende"><?php echo $photo['caption'] ? $photo['caption'] : '&nbsp;';?></div>
			</figure>
		</a>

	<?php }?>
</section>
<?php }?>
