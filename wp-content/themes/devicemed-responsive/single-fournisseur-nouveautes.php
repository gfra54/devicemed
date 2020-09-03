<?php if ($fournisseur['afficher_nouveautes']) {?>
	<?php if (empty($fournisseur['expiration_nouveautes']) || $fournisseur['expiration_nouveautes'] > date('Ymd')) {?>
		<?php if ($fournisseur['nouveautes']) {?>
			<section id="nouveautes">
				<h2 class="title">Nouveautés</h2>
			</section>

			<section class="supplier">
				<?php echo nl2br($fournisseur['nouveautes']); ?>
			</section>

		<?php }?>
	<?php }?>
<?php }?>