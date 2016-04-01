<?php if($fournisseur['post_content']) {?>
	<section class="read-more">
		<?php if($fournisseur['logo']) { ?>
			<div class='logo_supplier'>
				<img src='<?php echo $fournisseur['logo']; ?>' />
			</div>
		<?php } ?>
		<p class="about"><?php echo $fournisseur['post_content']; ?></p>
		<header>
			<!--<div class="aucun_article">Aucune galerie.</div>-->
			<?php if ($session = DM_Wordpress_Members::session() && $session_supplier_id == $supplier_id): ?>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/videos/add'); ?>">Ajouter une vidéo</a>
				</div>
				<div class="buttons">
					<a href="<?php echo site_url('/suppliers/galleries/add'); ?>">Ajouter une gallerie</a>
				</div>
			<?php endif; ?>
		</header>
	</section>
<?php }?>