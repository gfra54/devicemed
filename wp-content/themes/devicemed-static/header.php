<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title('-', true, 'right'); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/reset.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/fonts/opensans-condbold.css" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.bxslider.min.js"></script>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body>

<div id="viewport">

<header id="header">
	<div class="logo"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-recolor.png" alt="DeviceMed.fr" /></div>
	<div class="sidebar">
		<div class="links">
			<a href="#">Espace client</a>
		</div>
		<div class="search">
			<input type="text" name="search" value="Recherche" />
			<img src="http://placehold.it/20x20/ffffff/00008b" />
		</div>
		<div class="language"></div>
		<div class="social">
			<a href="#"><img src="http://placehold.it/30x30/00008b/ffffff" /></a>
			<a href="#"><img src="http://placehold.it/30x30/00008b/ffffff" /></a>
		</div>
	</div><!-- #sidebar -->
</header><!-- #header -->

<nav id="menu">
	<div class="primary">
		<?php devicemed_menu('Menu principal'); ?>
	</div>
	<div class="secondary">
		<?php devicemed_menu('Menu secondaire'); ?>
	</div>
</nav><!-- #menu -->

<section class="ad-728-90">
	<img src="http://placehold.it/728x90" />
</section>

<div id="main">

<section id="last-posts-featured">
	<div class="slider">
<?php foreach (devicemed_homepage_get_featured_posts() as $post): setup_postdata($post); ?>
		<article>
			<div class="left-side">
				<header>
					<h1 class="title"><?php the_title(); ?></h1>
				</header>
				<span class="title-divider"></span>
				<p class="excerpt"><?php echo get_the_excerpt(); ?></p>
				<a class="more" href="#">Lire la suite</a>
			</div>
			<div class="right-side">
<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): ?>
				<figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
					<img src="<?php echo $thumbnail->url; ?>" title="<?php echo $thumbnail->post_title; ?>" />
				</figure>
<?php endif; ?>
			</div>
		</article>
<?php endforeach; ?>
	</div>
</section>
<script type="text/javascript">
$(document).ready(function() {

$('#last-posts-featured .slider').bxSlider({
	auto: true,
	autoHover: true,
	mode: 'horizontal',
	controls: false
});

});
</script>

<style type="text/css">
#column-content {width:720px;float:left;margin-top:10px;}
#column-content .column {width:350px;background:#fff;float:left;margin-right:10px;}
#column-content section {background:#eee;margin-bottom:10px;}
#column-sidebar {width:260px;float:right;margin-top:10px;}
#column-sidebar section {background:#ddd;margin-bottom:10px;}

#news {background:transparent !important;padding:15px;padding-right:15px;}
#news > header {margin-bottom:20px;}
#news > header .title {text-transform:uppercase;font-size:30px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:1em;}
#news article {overflow:auto;margin-bottom:20px;}
#news article.last {margin-bottom:0;}
#news article .left-side {width:75px;float:left;}
#news article .right-side {width:235px;float:right;}
#news article .title {text-transform:uppercase;font-size:16px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:1em;}
#news article .excerpt {font-size:12px;line-height:1.25em;margin-bottom:10px;}
#news article .more {font-size:10px;color:white;background:darkblue;padding:5px 10px 5px 10px;float:left;text-transform:uppercase;display:none;}
#news article figure {background:silver;width:75px;height:75px;position:relative;overflow:hidden;background-size:cover;background-position:50% 50%;background-repeat:no-repeat;}
#news article figure img {display:block;opacity:0;position:absolute;top:0;left:0;}

#white-papers {padding:15px;}
#white-papers > header {margin-bottom:20px;}
#white-papers > header .title {text-transform:uppercase;font-size:30px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:1em;}
#white-papers article {overflow:auto;margin-bottom:20px;}
#white-papers article.last {margin-bottom:0;}
#white-papers article .left-side {width:75px;float:left;}
#white-papers article .right-side {width:235px;float:right;}
#white-papers article .title {text-transform:uppercase;font-size:16px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:1em;}
#white-papers article .excerpt {font-size:12px;line-height:1.25em;margin-bottom:10px;}
#white-papers article .more {font-size:10px;color:white;background:darkblue;padding:5px 10px 5px 10px;float:left;text-transform:uppercase;display:none;}
#white-papers article figure {background:silver;width:75px;height:75px;position:relative;overflow:hidden;background-size:cover;background-position:50% 50%;background-repeat:no-repeat;}
#white-papers article figure img {display:block;opacity:0;position:absolute;top:0;left:0;}

#videos {padding:15px;}
#videos > header {margin-bottom:20px;}
#videos > header .title {text-transform:uppercase;font-size:30px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:1em;}
#videos article {overflow:auto;margin-bottom:20px;}
#videos article.last {margin-bottom:0;}
#videos article .left-side {width:75px;float:left;}
#videos article .right-side {width:235px;float:right;}
#videos article .title {text-transform:uppercase;font-size:16px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:1em;}
#videos article .excerpt {font-size:12px;line-height:1.25em;margin-bottom:10px;}
#videos article .more {font-size:10px;color:white;background:darkblue;padding:5px 10px 5px 10px;float:left;text-transform:uppercase;display:none;}
#videos article figure {background:silver;width:75px;height:75px;position:relative;overflow:hidden;background-size:cover;background-position:50% 50%;background-repeat:no-repeat;}
#videos article figure img {display:block;opacity:0;position:absolute;top:0;left:0;}

#annual-guide {padding:15px;overflow:auto;}
#annual-guide .left-side {width:100px;float:left;}
#annual-guide .right-side {width:120px;float:right;}
#annual-guide .title {text-transform:uppercase;font-size:30px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:1em;}

#issues {padding:15px;overflow:auto;}
#issues header {overflow:hidden;}
#issues header .left-side {float:left;width:75px;}
#issues header .right-side {float:right;width:145px;}
#issues header .title {text-transform:uppercase;font-size:30px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:1em;}
#issues article {overflow:hidden;margin-bottom:10px;}
#issues article.last {margin-bottom:0;}
#issues article .left-side {width:75px;float:left;}
#issues article .right-side {width:145px;float:right;}
#issues article .issue {font-weight:bold;}
#issues article .download {font-size:10px;}
#issues .more {display:block;color:darkblue;text-align:center;padding:5px;}
#issues .more:hover {background:darkblue;color:white;}

#supplier-registration {padding:15px;overflow:auto;}
#supplier-registration header {overflow:hidden;}
#supplier-registration header .left-side {float:left;width:75px;}
#supplier-registration header .right-side {float:right;width:145px;}
#supplier-registration header .title {text-transform:uppercase;font-size:24px;margin:0;padding:0;color:darkblue;font-family:'opensans-condbold';line-height:0.9em;}
#supplier-registration .supplier-registration-form {}
#supplier-registration .supplier-registration-form input[type=text] {width:100%;padding:5px;margin-bottom:5px;background:#eee;color:gray;border:none;}
#supplier-registration .supplier-registration-form input[type=submit] {width:100%;padding:5px;background:darkblue;color:white;border:none;}
</style>
<div id="column-content">
	<div class="column">
		<section id="news">
			<header>
				<h1 class="title">Derniers articles</h1>
				<span class="title-divider"></span>
			</header>
<?php foreach (devicemed_homepage_get_news_posts() as $post): setup_postdata($post); ?>
			<article<?php if ($post->last): ?> class="last"<?php endif; ?>>
				<div class="right-side">
					<header>
						<h1 class="title"><?php the_title(); ?></h1>
					</header>
					<span class="title-divider-small"></span>
					<p class="excerpt"><?php echo get_the_excerpt(); ?></p>
					<a class="more" href="#">Lire la suite</a>
				</div>
				<div class="left-side">
<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): ?>
				<figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
					<img src="<?php echo $thumbnail->url; ?>" title="<?php echo $thumbnail->post_title; ?>" />
				</figure>
<?php endif; ?>
				</div>
			</article>
<?php endforeach; ?>
		</section>
	</div>
	<div class="column">
		<section id="white-papers">
			<header>
				<h1 class="title">Livres blancs</h1>
				<span class="title-divider"></span>
			</header>
<?php foreach (devicemed_homepage_get_whitepapers_posts() as $post): setup_postdata($post); ?>
			<article<?php if ($post->last): ?> class="last"<?php endif; ?>>
				<div class="right-side">
					<header>
						<h1 class="title"><?php the_title(); ?></h1>
					</header>
					<span class="title-divider-small"></span>
					<p class="excerpt"><?php echo get_the_excerpt(); ?></p>
					<a class="more" href="#">Lire la suite</a>
				</div>
				<div class="left-side">
<?php if ($thumbnail = devicemed_get_post_featured_thumbnail($post->ID)): ?>
				<figure style="background-image:url('<?php echo $thumbnail->url; ?>')">
					<img src="<?php echo $thumbnail->url; ?>" title="<?php echo $thumbnail->post_title; ?>" />
				</figure>
<?php endif; ?>
				</div>
			</article>
<?php endforeach; ?>
		</section>
		<section>
			<img src="http://placehold.it/350x250" />
		</section>
		<section id="videos">
			<header>
				<h1 class="title">Video</h1>
				<span class="title-divider"></span>
			</header>
			<iframe width="320" height="247" src="//www.youtube.com/embed/5AuYusSYpCg" frameborder="0" allowfullscreen></iframe>
		</section>
	</div>
</div>
<div id="column-sidebar">
	<section id="annual-guide">
		<div class="right-side">
			<h1 class="title">Guide annuel</h1>
			<span class="title-divider"></span>
			<span class="download">Télécharger</span>
		</div>
		<div class="left-side">
			<img src="http://placehold.it/100x142" />
		</div>
	</section>
	<section id="issues">
		<header>
			<div class="left-side">
				<img src="http://placehold.it/75x75/00008b/ffffff" />
			</div>
			<div class="right-side">
				<h1 class="title">Tous nos numéros</h1>
				<span class="title-divider"></span>
			</div>
		</header>
<?php for ($i = 0; $i < 3; $i++): ?>
		<article>
			<div class="right-side">
				<span class="issue">DMF 04/03/2014</span>
				<span class="download">Consulter ce numéro</span>
			</div>
			<div class="left-side">
				<img src="http://placehold.it/75x105" />
			</div>
		</article>
<?php endfor; ?>
		<a href="#" class="more">Consulter d'autres numéros</a>
	</section>
	<section id="supplier-registration">
		<header>
			<div class="left-side">
				<img src="http://placehold.it/75x75/00008b/ffffff" />
			</div>
			<div class="right-side">
				<h1 class="title">S'inscrire comme fournisseur</h1>
				<span class="title-divider"></span>
			</div>
		</header>
		<div class="supplier-registration-form">
			<input type="text" value="Nom" />
			<input type="text" value="Prénom" />
			<input type="text" value="Société" />
			<input type="text" value="E-mail" />
			<input type="submit" value="Valider" />
		</div>
	</section>
	<section id="jobs">
	</section>
	<section id="updates">
	</section>
</div>