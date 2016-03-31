	<section class="videos-fournisseur">
			<?php if(!fournisseur_empty(count($fournisseur['videos']))) {?>
				<?php foreach ($fournisseur['videos'] as $video){ ?>

				<div class="case-video"><?php echo resizeVideo(gestVideo($video['url_de_la_video']),400,300);?></div>
		

				<?php }?>
			<?php }?>

	</section>
