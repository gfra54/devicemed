<section id="sidebar-issues" class="agenda-salons">
	<header>
		<div class="right-side">
			<h1 class="title"><a href='/salons'>Salons et manifestations</a></h1>
		</div>
	</header>	
	<article>
		
		<?php 

		$cpt=0;foreach(get_salons() as $salon) {$cpt++;if($cpt<6) {?>
			<div class="agenda-salon">
				<a href='<?php echo $salon['url'];?>' target='_blank'><?=svg('fleche-droite');?> <?php echo $salon['titre'];?></a>
				<?php echo $salon['dates'];?> - <?php echo $salon['lieu'];?>
			</div>
		<?php }}?>
		<center><a href="/salons" class="more">Voir la liste complète</a></center>
	</article>
</section>