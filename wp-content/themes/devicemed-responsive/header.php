<?php header( 'Cache-Control: max-age=604800' ); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title(' – ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/images/favicon.ico" rel="SHORTCUT ICON">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<!-- Bootstrap -->
	<link href="<?php bloginfo('stylesheet_directory'); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php bloginfo('stylesheet_directory'); ?>/css/default.css" rel="stylesheet">
	<link href="<?php bloginfo('stylesheet_directory'); ?>/js/colorbox/example1/colorbox.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.bxslider.min.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-55916994-1', 'auto');
	  ga('send', 'pageview');
	  $(document).ready(function() {
		$(".archive_notConnected").click(function() {
			$(".bloc_cachepopup").show();
			$(".notConnected").show();
			// $(window).scrollTop(280);
		});
		
		$("#click_video").click(function() {
			$.ajax({
				url: 'http://www.devicemed.fr/wp-content/themes/devicemed-responsive/ajout_clic_video.php?banniere_id=50',
				dataType: 'json',
				success: function(json) {
					if(json != 'false') {
						$(".bloc_cachepopup").show();
						$("#infos_video").attr("src","https://www.youtube.com/embed/8J6pTmegit0");
						$(".popup_video_home").show();
					}
				}
			});
			// $(window).scrollTop(280);
		});
		
		$(".bloc_cachepopup").click(function() {
			$(".bloc_cachepopup").hide();
			$(".notConnected").hide();
			$(".bloc_cachepopup").hide();
			$("#close_popup_video_home").click();
		});
		
		$("#close_popup").click(function() {
			$(".bloc_cachepopup").hide();
			$(".notConnected").hide();
		});
		
		$("#close_popup_video_home").click(function() {
			$(".bloc_cachepopup").hide();
			$(".popup_video_home").hide();
			$("#infos_video").attr("src","");
		});
		
		$("#bloc_guide_acheteur").click(function() {
			$(".bloc_cachepopup").show();
			$(".notConnected").show();
		});
		
		$("#bloc_guide_acheteur2").click(function() {
			$(".bloc_cachepopup").show();
			$(".notConnected").show();
		});
		
		/*var widthWindow = $(window).width();
		
		if(widthWindow < 650) {
			$(".menu-item-has-children a").attr("href","#");
		}*/
		
		$("#menu_mobile").click(function() {
			if($("#menu").is(':hidden')) {
				$("#menu").slideDown();
			}else {
				$("#menu").slideUp();
			}
		});
	  });
	</script>
	<?php wp_head(); ?>
</head>
<div class='notConnected'>
	Vous devez être connecté pour accéder à cette archive.
	<br /><br />
	<div id='lien_notConnected_connecter'>
		<a href='http://www.devicemed.fr/members/login'>Se connecter</a>
	</div>
	<div id='close_popup'>X</div>
</div>
<div class='popup_video_home'>
	<iframe id='infos_video' width="670" height="320" src="" frameborder="0" allowfullscreen></iframe>
	<div id='close_popup_video_home'>X</div>
</div>
<body>
<div class='bloc_cachepopup'></div>
<div class="container">
<div class="bloc_top_header">
	<div class='vogel_logo'><img src='http://www.devicemed.fr/wp-content/uploads/vogel_logo.png' /></div>
	<div class='contenu_droit'>
			<div class="links">
				<a href="/">Accueil</a>
			</div>
			<div class="links">
				<a href="/feed/">RSS</a>
			</div>
		<?php if ($session = DM_Wordpress_Members::session()): ?>
			<div class="links">
				<a href="<?php echo site_url('/members/profile'); ?>">Profil de "<?php echo esc_html($session['user_nicename']); ?>"</a>
			</div>
			<div class="links">
				<a href="<?php echo site_url('/members/logout'); ?>">Se déconnecter</a>
			</div>
		<?php else: ?>
			<div class="links">
				<a href="<?php echo site_url('/members/login'); ?>">Se connecter</a>
			</div>
		<?php endif; ?>
		<div class='links'>
			<a href='http://www.devicemed.fr/newsletter/inscription'>Recevoir la newsletter</a>
		</div>
		<div class='devicemed_allemand'><a href='http://www.devicemed.de/' target='_blank'><img src='http://www.devicemed.fr/wp-content/uploads/devicemed_allemand.png' /></a></div>
	</div>
</div>
<header id="header">
	<div class="logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" /></a></div>
	<div class="sidebar">
		<div class="search">
			<form role="search" method="get" action="<?php bloginfo('url'); ?>">
				<input type="text" name="s" placeholder="Rechercher dans les articles" value="" />
				<input type="submit" value="Rechercher" />
			</form>
		</div>
		<div class="language"></div>
		<div class="social">
		<!--
			<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/header-icon-facebook.png" /></a>
			<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/header-icon-twitter.png" /></a>
		-->
		</div>
	</div><!-- #sidebar -->
	<li id="menu_mobile"><span>MENU</span></li>
	<nav id="menu">
		<?php devicemed_header_menu('menu-principal'); ?>
	</nav><!-- #menu -->
</header><!-- #header -->
<?php
	// On vérifies si on est sur une page fournisseur
	$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	// echo "monUrl : ". $monUrl;
	$supplier_id = $supplier['ID'];
	// echo "supplier_id : ". $supplier_id;
?>
<section class="ad header-ad">
	<?php
		$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$_SESSION['arrayBanniereAfficher'] = '';
		
		// On récupére les bannières qui ont une date de fin dépassé
		$current_date = date("Y-m-d");
		$sql_banniere_date_limite = "SELECT ID FROM `wordpress_dm_banniere` WHERE date_fin <= '$current_date'";
		$result_banniere_date_limite = mysql_query($sql_banniere_date_limite);
		$i_baniere_id = 0;
		
		while($row_banniere = mysql_fetch_array($result_banniere_date_limite)) {
			$banniere_id = $row_banniere['ID'];
			if($i_baniere_id == 0) {
				$_SESSION['arrayBanniereAfficher'] .= "$banniere_id";
			}else {
				$_SESSION['arrayBanniereAfficher'] .= ",$banniere_id";
			}
			$i_baniere_id++;
		}
		
		if($monUrl != 'http://www.devicemed.fr/') {
			if($_SESSION['arrayBanniereAfficher'] == '') {
				$_SESSION['arrayBanniereAfficher'] .= '53,54';
			}else {
				$_SESSION['arrayBanniereAfficher'] .= ',53,54';
			}
		}
		
		$banniere_model = new DM_Wordpress_Banniere_Model();
		
		if($monUrl == 'http://www.devicemed.fr/salons') {
			$banniereAfficher = $banniere_model->display_banniere(2, $_SESSION['arrayBanniereAfficher'], 'true');
		}elseif($monUrl == 'http://www.devicemed.fr/category/dossiers/equipements-de-production-et-techniques-de-fabrication/metrologie_controle') {
			$banniereAfficher = $banniere_model->display_banniere(2, $_SESSION['arrayBanniereAfficher'], 'false', 'true');
		}else {
			$banniereAfficher = $banniere_model->display_banniere(2, $_SESSION['arrayBanniereAfficher'], 'false');
		}

		$banniere_id = $banniereAfficher[0]['ID'];
		$_SESSION['arrayBanniereAfficher'] .= $banniere_id;
		$image = $banniereAfficher[0]['image'];
		$lien = $banniereAfficher[0]['lien'];
		
		if($monUrl == 'http://www.devicemed.fr/category/dossiers/composants-oem/mecaniques') {
			echo "<a href='http://www.device-med.fr/?url=http://www.balseal.com/medical-devices&id=19' id='19' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/bal_seal.gif' /></a>";
		}elseif($monUrl == 'http://www.devicemed.fr/category/dossiers/equipements-de-production-et-techniques-de-fabrication/metrologie_controle') {
			echo "<a href='http://www.device-med.fr/?url=http://www.precitec.fr&id=30' id='30' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/precitec.gif' /></a>";
		}elseif($monUrl == 'http://www.devicemed.fr/category/dossiers/sous-traitance-et-services/plasturgie-sous-traitance-et-services') {
			echo "<a href='http://www.device-med.fr/?url=http://www.thieme.eu/fr/polyurethane&id=38' id='38' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/WEB Banner.jpg' /></a>";
		}elseif($monUrl == 'http://www.devicemed.fr/category/dossiers/reglementation') {
			echo "<a href='https://urldefense.proofpoint.com/v2/url?u=http-3A__www.dm-2Dexperts.fr&d=AwMFAw&c=swZ-Xf1X63pRFsfLwqPxeIkAR_Uj073mmqakB_XXmeg&r=y8cCPPeAINua2ICvxy0PPu4yd--gsabdzZ9rwDhHBtU&m=CukLFzw90wFwqRT2jv7xZfKZ31tg0ihu_w1zkLhCbi0&s=bnTYno-7r9Q2fQkac7pTcm66rcCDB7W6QVXZJ4xIy1k&e=' id='64' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/banniere-devicemed-2015.gif' /></a>";
		}else {
			echo "<a href='http://www.device-med.fr/?url=$lien&id=$banniere_id' id='$banniere_id' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/$image' /></a>";
		}
	?>
</section>