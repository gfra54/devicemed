<?php
/*
Template Name: fournisseurs
*/
if($GLOBALS['categorie']) {
	$nb_total = $GLOBALS['categorie']['count'];
} else {
	$nb_total = fournisseurs_compte();
}

$parpage=50;
$total = ceil($nb_total/$parpage);
$p=sinon($_GET,'page-fournisseurs','default:1');
$debut=($p-1)*$parpage;

$params = array('debut'=>$debut,'parpage'=>$parpage);
if($GLOBALS['categorie']) {
	$params['categorie']=$GLOBALS['categorie']['slug'];
}
$fournisseurs = get_fournisseurs($params);

get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="profile">
		<h2 class="title">Les fournisseurs des fabricants de dispositifs médicaux</h2>

					<h3 class='title5' id='retour_fournisseurs'><a href='/suppliers/'>Retour à la page de recherche d'un fournisseur</a></h3>

		<h3 class='title5'><?php if($GLOBALS['categorie']) {?>
			Résultat de recherche pour <?php echo $GLOBALS['categorie']['parent']['name'];?> > <?php echo $GLOBALS['categorie']['name'];?> :
		<?php } else {?>
			Liste alphabétique complète des fournisseurs :
		<?php }?></h3>

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
					<div id='bloc_supplier_search'>
					<?php foreach($fournisseurs as $fournisseur) { ?>

								<?php if(get_field('premium',$fournisseur['ID'])) {?>
									<div class='supplier_search'><a href="<?php echo get_permalink($fournisseur['ID']);?>"><b><?php echo $fournisseur['post_title'];?></b></a></div>
								<?php }else {?>
									<div class='supplier_search'><a href="<?php echo get_permalink($fournisseur['ID']);?>"><?php echo $fournisseur['post_title'];?></a></div>
								<?php }?>

					
					<?php }?>
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
	</section>
	</div>
<?php get_footer(); ?>

