<?php if(count($fournisseur['videos'])) {?>
	<section class="videos-fournisseur">
				<?php foreach ($fournisseur['videos'] as $video){ ?>

				<div class="case-video"><?php echo resizeVideo(gestVideo($video['url_de_la_video']),400,300);?></div>
		

				<?php }?>

	</section>
<?php }?>
