<?php
/*
Template Name: fournisseurs-liste
*/
$initiale = check('initiale');
$terme = trim(check('terme'));
$voir = trim(check('voir'));
if($initiale) {
	$params = array('initiale'=>$initiale);
} else {
	if($GLOBALS['categorie']) {
		$nb_total = $GLOBALS['categorie']['count'];
	} else {
		$nb_total = fournisseurs_compte();
	}

/*	$parpage=5000;
	$total = ceil($nb_total/$parpage);
	$p=sinon($_GET,'page-fournisseurs','default:1');
	$debut=($p-1)*$parpage;
	$params = array('debut'=>$debut,'parpage'=>$parpage);
	*/
	$params=array();
	if($GLOBALS['categorie']) {
		$params['categorie']=$GLOBALS['categorie']['slug'];
		$params['cache']='liste-fournisseurs-'.$params['categorie'];
	} else {
		$params['cache']='liste-fournisseurs';
	}
}
$fournisseurs = get_fournisseurs($params);

get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="profile">
		<h2 class="title">Les fournisseurs des fabricants de dispositifs médicaux</h2>

					<h3 class='title5' id='retour_fournisseurs'><a href='/fournisseurs/'>Retour à la page de recherche d'un fournisseur</a></h3>

		<?php if($initiale) {?>
			<h3 class='title5'>Liste des fournisseurs dont le nom commence par <?php echo $initiale == '*' ? 'un nombre ou un symbole' : 'la lettre '.htmlspecialchars(strtoupper($initiale));?></h3>
		<?php }else if($GLOBALS['categorie']) {?>
			<h3 class='title5'>Résultat de recherche pour <?php echo $GLOBALS['categorie']['parent']['name'];?> > <?php echo $GLOBALS['categorie']['name'];?> :</h3>
		<?php } else {?>
			<h3 class='title5'>Liste alphabétique complète des fournisseurs :</h3>
		<?php }?></h3>
			<?php fournisseurs_filtre_lettres();?>
				<hr>
					<?php if($total>1) {?>
						<b>
						<?php if($p>1) {?>
							<a href="?page-fournisseurs=<?php echo $p-1;?>">&laquo; Page précédente</a>
						<?php } else echo '&laquo; Page précédente'?></b>
						&nbsp; <?php for($i=1;$i<=$total;$i++){?>
							<a href="?page-fournisseurs=<?php echo $i;?>"><?php echo $i == $p ? ('<u>'.$i.'</u>') : $i;?></a> &nbsp;
						<?php }?> &nbsp;
						<b><?php if($p<$total) {?>
							<a href="?page-fournisseurs=<?php echo $p+1;?>">Page suivante &raquo;</a>
						<?php } else echo 'Page suivante &raquo;'?>
						</b>
						<hr>
					<?php }?>
				
					<label for="terme">
						<h3 class='title5'>Recherche rapide d'un fournisseur</h3>
						<input id="terme" type="text" value="<?php echo htmlspecialchars($terme);?>">
					<label>

				<div class="liste-fournisseurs">
					<div id='bloc_supplier_search'>
						<div class="lettre-groupe">
					<?php 
						$lettre_prec=false;
						foreach($fournisseurs as $fournisseur) { 
							$lettre = strtolower(substr($fournisseur['post_title'], 0,1));
							if(!ctype_alpha($lettre)) {
								$lettre='#';
							}
							?>
								<?php if($lettre!=$lettre_prec) {?>
									</div>
									<div class="lettre-groupe">
									<div class="lettre-fournisseur"><?php echo strtoupper($lettre);?></div>
								<?php }?>
								<?php if(get_field('premium',$fournisseur['ID'])) {?>
									<div class='supplier_search'><a href="<?php echo get_permalink($fournisseur['ID']);?>"><b><?php echo $fournisseur['post_title'];?></b></a></div>
								<?php }else {?>
									<div class='supplier_search'><a href="<?php echo get_permalink($fournisseur['ID']);?>"><?php echo $fournisseur['post_title'];?></a></div>
								<?php }?>

					
					<?php $lettre_prec = $lettre;}?>
						</div>
					</div>
					<?php if($total>1) {?>
						<hr><b>
						<?php if($p>1) {?>
							<a href="?page-fournisseurs=<?php echo $p-1;?>">&laquo; Page précédente</a>
						<?php } else echo '&laquo; Page précédente'?></b>
						&nbsp; <?php echo 'page '.$p.' sur '.$total;?> &nbsp;
						<b><?php if($p<$total) {?>
							<a href="?page-fournisseurs=<?php echo $p+1;?>">Page suivante &raquo;</a>
						<?php } else echo 'Page suivante &raquo;'?>
						</b>
					<?php }?>
				</div>
	</section>
	</div>
<?php get_footer(); ?>

