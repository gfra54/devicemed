<?php if ($fournisseur['nouveautes']) {?>
	<?php if($fournisseur['expiration_nouveautes'] > date('Ymd')) {?>
		<section id="nouveautes">
			<h2 class="title">Nouveautés</h2>
		</section>

		<section class="supplier">
			<?php echo nl2br($fournisseur['nouveautes']);?>

			<br>
			<?php 
			if($fournisseur['categories_nouveautes'] && !is_array($fournisseur['categories_nouveautes'])) {
				$fournisseur['categories_nouveautes'] = unserialize($fournisseur['categories_nouveautes']);
			}
			foreach($fournisseur['categories_nouveautes'] as $categorie) {?>
				<a href="#<?php echo $categorie;?>">Voir <?php echo fournisseurs_menu_pronom($categorie);?></a>
			<?php }?>
		</section>
	<?php }?>
<?php }?>