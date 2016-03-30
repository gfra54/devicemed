<?php
/*
Template Name: fournisseurs
*/
$count_posts = wp_count_posts('fournisseur');

$parpage=50;
$total = ceil($count_posts->publish/$parpage);
$p=sinon($_GET,'page-fournisseurs','default:1');
$debut=($p-1)*$parpage;
$fournisseurs = get_fournisseurs(array('debut'=>$debut,'parpage'=>$parpage));

get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="profile">
		<h2 class="title">Les fournisseurs des fabricants de dispositifs médicaux</h2>

					<h3 class='title5' id='retour_fournisseurs'><a href='/suppliers/'>Retour à la page de recherche d'un fournisseur</a></h3>
					<h3 class='title5'>Liste alphabétique complète des fournisseurs :</h3>

					<hr><b>
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
					<div id='bloc_supplier_search'>
					<?php foreach($fournisseurs as $fournisseur) { ?>

								<?php if(get_field('premium',$fournisseur['ID'])) {?>
									<div class='supplier_search'><a href="<?php echo get_permalink($fournisseur['ID']);?>" target='_blank'><b><?php echo $fournisseur['post_title'];?></b></a></div>
								<?php }else {?>
									<div class='supplier_search'><a href="<?php echo get_permalink($fournisseur['ID']);?>" target='_blank'><?php echo $fournisseur['post_title'];?></a></div>
								<?php }?>

					
					<?php }?>
					</div>
					<hr><b>
					<?php if($p>1) {?>
						<a href="?page-fournisseurs=<?php echo $p-1;?>">&laquo; Page précédente</a>
					<?php } else echo '&laquo; Page précédente'?></b>
					&nbsp; <?php echo 'page '.$p.' sur '.$total;?> &nbsp;
					<b><?php if($p<$total) {?>
						<a href="?page-fournisseurs=<?php echo $p+1;?>">Page suivante &raquo;</a>
					<?php } else echo 'Page suivante &raquo;'?>
					</b>
	</section>
	</div>
<?php get_footer(); ?>

