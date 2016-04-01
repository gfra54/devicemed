<?php if($fournisseur['salons']) {?>
<section class="liste-salons">
	<?php foreach($fournisseur['salons'] as $salon) {?>
		<div class="salon-case">
			<h3><?php 
			if(!link_cond($salon['url'],$salon['nom_du_salon'])) {
				echo $salon['nom_du_salon'];
			}
			?></h3>
			<?php cond('Dates : ',$salon['dates'],'<br>');?>
			<?php cond('Lieu : ',$salon['lieu'],'<br>');?>
			<?php echo $salon['informations_additionelles'];?>
		</div>
	<?php }?>
</section>
<?php }?>