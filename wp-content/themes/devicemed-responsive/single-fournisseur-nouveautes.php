<?php if (afficher_nouveautes($fournisseur) && $fournisseur['nouveautes']) {?>
			<section id="nouveautes">
				<h2 class="title">Nouveautés</h2>
			</section>

			<section class="supplier">
				<?php echo nl2br($fournisseur['nouveautes']); ?>
			</section>

<?php }?>