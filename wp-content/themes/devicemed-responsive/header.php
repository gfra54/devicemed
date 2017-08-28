<?php 

header( 'Cache-Control: max-age=604800' ); ?><!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title(' – ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link href="/wp-content/themes/devicemed-responsive/images/favicon.ico" rel="SHORTCUT ICON">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<!-- Bootstrap -->
	<?php include_external('css/bootstrap.min.css');?>
	<?php include_external('css/default.css');?>
	<?php include_external('css/extra.css');?>
	<?php include_external('js/colorbox/example1/colorbox.css');?>
	<?php include_external('js/jquery.min.js');?>
	<?php include_external('js/jquery.bxslider.min.js');?>
	<?php include_external('js/fancybox/jquery.fancybox.js');?>
	<?php include_external('js/fancybox/jquery.fancybox.css');?>
	<?php extrajs('pubs');?>
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
		
/*		$("#click_video").click(function() {
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
		});*/
		
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
		<a href='/members/login?uri=<?php echo $_SERVER['REQUEST_URI'];?>'>Se connecter</a>
	</div>
	<div id='close_popup'>X</div>
</div>
<div class='popup_video_home'>
	<iframe id='infos_video' width="670" height="320" src="" frameborder="0" allowfullscreen></iframe>
	<div id='close_popup_video_home'>X</div>
</div>

<?php if(!afficher_pub('site-habillage')) {?>
	<body
	
	> 
<?php }?>

<div class='bloc_cachepopup'></div>
<div class="container">
<div class="bloc_top_header">
	<div class='vogel_logo'><img src='/wp-content/uploads/vogel_logo.png' /></div>
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
<!-- 		<div class='links'>
			<a href='/newsletter/inscription'>Archives de la newsletter</a>
		</div>
 -->		<div class='devicemed_allemand'><a href='http://www.devicemed.de/' target='_blank'><img src='/wp-content/uploads/devicemed_allemand.png' /></a></div>
	</div>
</div>
<header id="header">
	<div class="logo"><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-alpha.png" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" /></a></div>
	<div class="nl-header">

	<form action="http://devicemed.us15.list-manage1.com/subscribe" id="formnl" target="formnl" method="get">      
		<input type="hidden" name="u" value="3e97c5daff9192e3f43c22080">
		<input type="hidden" name="id" value="8b91d09d5c">

		<h2>Recevoir notre newsletter</h2>
		<div class="nl-field">
        	<input placeholder="Adresse mail" type="email" name="EMAIL" value="" size="20" maxlength="80"  />
        	<input type="submit" value="Ok">
        </div>
      	<small><u><a href="/newsletter/inscription">Consulter les archives</a></u></small>
	</form>

	</div>
	<div class="sidebar">
		<div class="search">
			<form role="search" method="get" action="<?php bloginfo('url'); ?>">
				<input type="text" name="s" placeholder="Rechercher dans les articles" value="<?php echo get_search_query();?>" />
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
<section class="ad header-ad">
	<?php afficher_pub_js('site-banniere-horizontale');?>
</section>