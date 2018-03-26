<?php 
get_header(); 

$debut=intval($_GET['debut']);
if($debut) {
	$annee = ''.$debut;
} else {
	$annee = false;
	$debut = date('Y')+1;
}
?>

<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="catalogues">
		<h2 class="title">Salons et manifestations <?php echo $annee ? ' en '.$annee : '';?></h2>
		<div id='contenu_archives'>
			
		
			<?php 
				$date_ref=false;
				foreach(get_salons(20,$annee) as $salon) { 
				$mois = ((strftime("%B %Y",strtotime($salon['date_debut']))));
				$date_ref=$date_ref ? $date_ref : $salon['date_debut'];
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
<!--			<div class='bloc_manif'>
				<div class='mois_salons'>Novembre 2015</div>
				<div class='bloc_description_salons'>
					<div class='titre_manif'><a href='http://www.midest.com/' target='_blank'>Midest</a></div>
					<div class='description_manif'>Exposition dédiée à la sous-traitance industrielle.</div>
					<div class='date_salon'>17-20 novembre - Paris</div>
				</div>
			</div>
			<div class='bloc_manif'>
				<div class='bloc_description_salons'>
					<div class='titre_manif'><a href='http://www.sofcot-congres.fr/fr' target='_blank'>Sofcot</a></div>
					<div class='description_manif'>Congrès annuel de la Société Française de chirurgie orthopédique et traumatologique.</div>
					<div class='date_salon'>10-13 novembre - Paris</div>
				</div>
			</div>
			<div class='bloc_manif'>
				<div class='bloc_description_salons'>
					<div class='titre_manif'><a href='http://www.compamed-tradefair.com/' target='_blank'>Compamed</a></div>
					<div class='description_manif'>Exposition sur les solutions high tech pour le médical.</div>
					<div class='date_salon'>16-19 novembre - Düsseldorf</div>
				</div>
			</div>
			<div class='bloc_manif'>
				<div class='bloc_description_salons'>
					<div class='titre_manif'><a href='http://www.medica-tradefair.com/' target='_blank'>Medica</a></div>
					<div class='description_manif'>Foire internationale des technologies médicales.</div>
					<div class='date_salon'>16-19 novembre - Düsseldorf</div>
				</div>
			</div>-->
		</div>
		<hr>
		<center><p><a class="lien-classique" href="?debut=<?=$debut-1;?>">
			<?php if($debut) {echo 'Voir les salons en '.($debut-1);  } else { echo 'Voir la liste des événements antérieurs'; }?></a></p></center>
	</section>

	</div><!-- .column-main -->
<?php get_footer(); ?>