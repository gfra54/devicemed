<section id="sidebar-issues" class="agenda-salons">
	<header>
		<div class="right-side">
			<h1 class="title"><a href='/salons'>Salons et manifestations</a></h1>
		</div>
	</header>	
	<article>
		
		<?php 

		foreach(get_salons() as $salon) {?>
			<div class="agenda-salon">
				<a href='<?php echo $salon['url'];?>' target='_blank'><?=svg('fleche-droite');?> <?php echo $salon['titre'];?></a>
				<?php echo $salon['dates'];?> - <?php echo $salon['lieu'];?>
			</div>
		<?php }?>
<!--		<h3 class='title2'><a href='http://www.midest.com/' target='_blank'>MIDEST<br />17-20 novembre 2015/ Paris</a></h3><br />
		<h3 class='title2'><a href='http://www.sofcot-congres.fr/fr' target='_blank'>SOFCOT<br />10-13 novembre 2015/ Paris</a></h3><br />
		<h3 class='title2'><a href='http://www.compamed-tradefair.com/' target='_blank'>COMPAMED <br />16-19 novembre 2015/ Düsseldorf</a></h3>-->
		<center><a href="/salons" class="more">Voir la liste complète</a></center>
	</article>
</section>