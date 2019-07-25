<?php 
get_header(); 

$main = !isset($_GET['debut']);
$debut=intval($_GET['debut']);
if(!$debut) {
	$debut = date('Y');
}
if($debut) {
	$annee = ''.$debut;
} else {
	$annee = false;
	$debut = date('Y')+1;
}

$target = $main ? $debut : $debut-1;
?>
<style>
	.liste-annees a {
		text-decoration: underline;
		color:#0066b3;
	}
	.liste-annees a.selected {
		text-decoration: none;
	}
</style>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
		<section class="catalogues">
			<h2 class="title">Salons et manifestations <?php echo $annee ? ' en '.$annee : '';?></h2>
			<div id='contenu_archives'>


				<?php 
				$date_ref=false;
				$affiches=0;
				foreach(get_salons(20,$annee) as $salon) { 
					$mois = ((strftime("%B %Y",strtotime($salon['date_debut']))));
					$date_ref=$date_ref ? $date_ref : $salon['date_debut'];
					if($main) {
						$t = strtotime($salon['date_debut']);
						if($t < time()) {
							continue;
						}
						$affiches++;
					}
					?>
					<div class='bloc_manif'>
						<?php if(!isset($mois_prec) || $mois != $mois_prec) {?>
							<div class='mois_salons'><?php echo $mois;?></div>
						<?php }?>
						<div class='bloc_description_salons'>
							<div class='titre_manif'><?=svg('fleche-droite');?> <a href='<?php echo $salon['url'];?>' target='_blank'><?php echo $salon['titre'];?></a></div>
							<div class='description_manif'><?php echo $salon['description'];?></div>
							<div class='date_salon'><?php echo $salon['dates'];?> - <?php echo $salon['lieu'];?></div>
						</div>
					</div>
					<?php $mois_prec=$mois;}?>
					<?php if(!$affiches) {?>
						<p><i>Il n'y a pas d'événements à affiche.</i></p>
					<?php }?>
				</div>
				<hr>
			<div class="liste-annees">Choisir une année :
				<?php 
				$d = date('Y')+1;

				for($i=$d;$i>2015;$i--) {
					$class = $i == $debut ? 'selected' : '';
					?>
					<a class="<?php echo $class;?>" href="?debut=<?php echo $i;?>"><?php 
						echo $i;

					?></a>
				<?php }?>
			</div>
<!-- 				<center><p><a class="lien-classique" href="?debut=<?=$target;?>">
					<?php if($debut) {echo 'Voir les salons passés en '.($target);  } else { echo 'Voir la liste des événements antérieurs'; }?></a></p></center>
 -->				</section>

			</div><!-- .column-main -->
			<?php get_footer(); ?>