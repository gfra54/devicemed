<?php
		$_SESSION['arrayBanniereAfficher'] = '';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title(' – ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/images/favicon.ico" rel="SHORTCUT ICON">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<!-- Bootstrap -->
    <link href="<?php bloginfo('stylesheet_directory'); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php bloginfo('stylesheet_directory'); ?>/css/default.css" rel="stylesheet">
	<link href="<?php bloginfo('stylesheet_directory'); ?>/js/colorbox/example1/colorbox.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-55916994-1', 'auto');
	  ga('send', 'pageview');
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".details_supplier_disabled").click(function() {
				$(".bloc_cachepopup").show();
				$(".popup_informations_premiumsupplier").show();
				// $(window).scrollTop(280);
			});
			
			$("#close_popup_premiumsupplier").click(function() {
				$(".bloc_cachepopup").hide();
				$(".popup_informations_premiumsupplier").hide();
			});
		
			$(".bloc_cachepopup").click(function() {
				$(".bloc_cachepopup").hide();
				$(".popup_informations_premiumsupplier").hide();
			});

			$("#bloc_guide_acheteur").click(function() {
				$(".bloc_cachepopup").show();
				$(".notConnected").show();
			});
		
			$(".bloc_cachepopup").click(function() {
				$(".bloc_cachepopup").hide();
				$(".notConnected").hide();
			});
			
			$("#close_popup").click(function() {
				$(".bloc_cachepopup").hide();
				$(".notConnected").hide();
			});
		
			$("#menu_mobile").click(function() {
				if($("#menu").is(':hidden')) {
					$("#menu").slideDown();
				}else {
					$("#menu").slideUp();
				}
			});
		
			/*var widthWindow = $(window).width();
			
			if(widthWindow < 650) {
				$(".menu-item-has-children a").attr("href","#");
			}*/
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
<div class='popup_informations_premiumsupplier'>
	Informations disponibles uniquement sur les fiches des fournisseurs partenaires.
	<div id='close_popup_premiumsupplier'>X</div>
</div>
<body>
<div class='bloc_cachepopup'></div>
<div class="container">
<div class="bloc_top_header">
	<div class='vogel_logo'><img src='http://www.devicemed.fr/wp-content/uploads/vogel_logo.png' /></div>
	<div class='contenu_droit'>
		<div class="links">
		<?php if ($session = DM_Wordpress_Members::session()): ?>
			<a href="<?php echo site_url('/members/profile'); ?>">Profil de "<?php echo esc_html($session['user_nicename']); ?>"</a>
			<a href="<?php echo site_url('/members/logout'); ?>">Se déconnecter</a>
		<?php else: ?>
			<a href="<?php echo site_url('/members/login'); ?>">Se connecter</a>
		<?php endif; ?>
		</div>
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
				<input type="text" name="s" placeholder="Rechercher..." value="" />
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
			$banniereAfficher = $banniere_model->display_banniere(2, $_SESSION['arrayBanniereAfficher']);

			$banniere_id = $banniereAfficher[0]['ID'];
			$_SESSION['arrayBanniereAfficher'] .= $banniere_id;
			$image = $banniereAfficher[0]['image'];
			$lien = $banniereAfficher[0]['lien'];
			
			echo "<a href='http://www.device-med.fr/?url=$lien&id=$banniere_id' id='$banniere_id' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/$image' /></a>";
		?>
	</section>
<?php 
		// On ajoute un clic au profil payant
		if(isset($_GET['premiere_visite']) && $_GET['premiere_visite'] == 1) {
			// On récupére l'adresse IP
			$adresseIP = $_SERVER["REMOTE_ADDR"];
			$supplier_id = $supplier['ID']; 
			
			// On vérifie que l'adresse IP n'as pas déjà visité cette page
			$sqlAdresseIP = "SELECT * FROM wordpress_dm_supplier_premium_clic WHERE supplier_premium_id=$supplier_id AND adresse_ip='$adresseIP'";
			$resultAdresseIP = mysql_query($sqlAdresseIP);
			$nbAdresseIP = mysql_num_rows($resultAdresseIP);
			$nosAdressesIP = array('82.228.227.218', '217.128.7.96', '86.219.76.20');
			
			if($nbAdresseIP == 0 && !in_array($adresseIP, $nosAdressesIP)) {
				$sqlClicProfilPayant = "INSERT INTO wordpress_dm_supplier_premium_clic(supplier_premium_id, adresse_ip) VALUES($supplier_id, '$adresseIP')";
				$resultClicProfilPayant = mysql_query($sqlClicProfilPayant);
			}
		}
?>
<?php 
	$supplier_id = $supplier['ID']; 
	$supplier_category_id = $supplier['supplier_category_id'];
	$supplier_name = esc_html($supplier['supplier_name']);
?>
<div class="row column-content page-supplier">
	<div class="col-md-9 col-sm-8 column-main">
<?php if (!$supplier): ?>
	<section class="results">
		<h2 class="title">Fournisseur introuvable</h2>
		<div class='retour_recherche_fournisseur'>
			<a href='http://www.devicemed.fr/suppliers/'>
				Retour à la page de recherche d’un fournisseur
			</a>
		</div>
	</section>
<?php else: ?>
	<section class="results">
		<h2 class="title"><?php echo esc_html($supplier['supplier_name']); ?></h2>
		<div class='retour_recherche_fournisseur'>
			<a href='http://www.devicemed.fr/suppliers/'>
				Retour à la page de recherche d’un fournisseur
			</a>
		</div>
	</section>
	<section class="actions">
		<a href="<?php echo site_url('/suppliers/'.esc_attr(sanitize_title($supplier_name)).'/'. $supplier_id); ?>" class="menu_actif">Coordonnées</a>
		<a href="<?php echo site_url("/suppliers/products/$supplier_id"); ?>">Activités</a>
		<?php if($supplier['supplier_premium'] == 1) { ?>
			<a href="<?php echo site_url("/suppliers/galleries/$supplier_id"); ?>">Présentation</a>
			<a href="<?php echo site_url("/suppliers/posts/$supplier_id"); ?>">Articles</a>
			<a href="<?php echo site_url("/suppliers/videos/$supplier_id"); ?>">Photos et vidéos</a>
			<a href="<?php echo site_url("/suppliers/events/$supplier_id"); ?>">Evénements</a>
			<a href="<?php echo site_url("/suppliers/download/$supplier_id"); ?>">Documentation PDF</a>
		<?php }else { ?>
			<span class='details_supplier_disabled'>Présentation et photos</span>
			<span class='details_supplier_disabled'>Articles</span>
			<span class='details_supplier_disabled'>Vidéos</span>
			<span class='details_supplier_disabled'>Evénements</span>
			<span class='details_supplier_disabled'>Documentation PDF</span>
		<?php } ?>
	</section>
	<section class="supplier">
		<div class='info_supplier'>
			<?php if($supplier['supplier_logo'] != '') { ?>
				<div class='logo_supplier'>
					<img src='<?php echo "../../../wp-content/uploads/logo_suppliers/". $supplier['supplier_logo']; ?>' />
				</div>
			<?php } ?>
			<div class="address">
				<b><?php echo esc_html($supplier['supplier_name']); ?></b><br />
				<?php echo esc_html($supplier['supplier_address']); ?>
			</div>
			<div>
				<span class="postalcode"><?php echo esc_html($supplier['supplier_postalcode']); ?></span>
				<span class="city"><?php echo esc_html($supplier['supplier_city']); ?></span><br />
				<span class="country"><?php echo esc_html($supplier['supplier_country']); ?></span>
			</div><br />
			<?php if(stripos($supplier['supplier_website'], 'http://')) { ?>
				<div><a href="<?php echo esc_attr($supplier['supplier_website']); ?>" target='_blank'><?php echo esc_html($supplier['supplier_website']); ?></a></div><br />
			<?php }else { ?>
				<?php $supplierWebsite = str_replace('http://','', $supplier['supplier_website']); ?>
				<div><a href="http://<?php echo esc_attr($supplierWebsite); ?>" target='_blank'><?php echo esc_html($supplier['supplier_website']); ?></a></div><br />
			<?php } ?>
			<p class="about">
				<?php if(isset($supplier['supplier_social_blog']) && $supplier['supplier_social_blog'] != '') { ?><a href='<?php echo $supplier['supplier_social_blog']; ?>'><?php echo $supplier['supplier_social_blog']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_facebook']) && $supplier['supplier_social_facebook'] != '') { ?><a href='<?php echo $supplier['supplier_social_facebook']; ?>'><?php echo $supplier['supplier_social_facebook']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_linkedin']) && $supplier['supplier_social_linkedin'] != '') { ?><a href='<?php echo $supplier['supplier_social_linkedin']; ?>'><?php echo $supplier['supplier_social_linkedin']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_google_plus']) && $supplier['supplier_social_google_plus'] != '') { ?><a href='<?php echo $supplier['supplier_social_google_plus']; ?>'><?php echo $supplier['supplier_social_google_plus']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_twitter']) && $supplier['supplier_social_twitter'] != '') { ?><a href='<?php echo $supplier['supplier_social_twitter']; ?>'><?php echo $supplier['supplier_social_twitter']; ?></a><br /><?php } ?>
				<?php if(isset($supplier['supplier_social_youtube']) && $supplier['supplier_social_youtube'] != '') { ?><a href='<?php echo $supplier['supplier_social_youtube']; ?>'><?php echo $supplier['supplier_social_youtube']; ?></a><br /><?php } ?>
			</p>
			<?php  
				if((isset($supplier['supplier_contact_nom']) && $supplier['supplier_contact_nom'] != '') || (isset($supplier['supplier_contact_tel']) && $supplier['supplier_contact_tel'] != '') || (isset($supplier['supplier_contact_mail']) && $supplier['supplier_contact_mail'] != '')) {
					echo "<b>Contact :</b><br />";
				}
				
				if(isset($supplier['supplier_contact_nom']) && $supplier['supplier_contact_nom'] != '') {
					echo $supplier['supplier_contact_nom'] ."<br />";
				} 

				if(isset($supplier['supplier_contact_tel']) && $supplier['supplier_contact_tel'] != '') {
					echo $supplier['supplier_contact_tel'] ."<br />";
				}

				if(isset($supplier['supplier_contact_mail']) && $supplier['supplier_contact_mail'] != '') {
					$supplierMail = $supplier['supplier_contact_mail'];
					echo "<a href='mailto:$supplierMail'>". $supplier['supplier_contact_mail'] ."</a>";
				}
			?>
		</div>
	</section>
<?php endif; ?>
</div><!-- .column-main -->
<!-- FOOTER -->
	<?php
		if($_GET['inscription_fournisseur'] == 1) {
			$success['general'] = 'L\'inscription a bien été prise en compte.';
		}

		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$supplier_user_id = !empty($_GET['supplier_user_id']) ? (int) $_GET['supplier_user_id'] : 0;
		
		$errors = array();
		$sucess = array();

		$data = array(
			'supplier_id' => 0,
			'supplier_user_id' => $supplier_user_id,
			'supplier_user_login' => '',
			'supplier_user_lastname' => '',
			'supplier_user_firstname' => '',
			'supplier_user_e-mail' => '',
			'supplier_user_sex' => 'M',
			'supplier_user_address' => '',
			'supplier_user_postalcode' => '',
			'supplier_user_city' => '',
			'supplier_user_country' => '',
			'supplier_user_created' => date('Y-m-d H:i:s'),
			'supplier_user_modified' => date('Y-m-d H:i:s'),
			'supplier_user_status' => '1',
			'supplier_user_new_password' => '',
			'supplier_user_new_password_confirm' => '',
			'supplier_user_password' => '',
			'supplier_user_password_confirm' => ''
		);

		if (!empty($_GET))
		{
			foreach ($data as $field => $value)
			{
				if (isset($_GET[ $field ]))
				{
					$data[ $field ] = trim(stripslashes($_GET[ $field ]));
				}
			}
			if (!$data['supplier_user_e-mail'])
			{
				$errors['supplier_user_e-mail'] = 'email manquant.';
			}
			else
			{
				$data['supplier_user_e-mail'] = strtolower($data['supplier_user_e-mail']);
				if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $data['supplier_user_e-mail']))
				{
					$errors['supplier_user_e-mail'] = 'email invalide.';
				}
			}
			if (!$supplier_user_id)
			{
				if (!$data['supplier_user_e-mail'])
				{
					$errors['supplier_user_e-mail'] = 'Identifiant manquant.';
				}
				else
				{
					$duplicate = $suppliers_users->admin_edit_check_duplicate_login($data['supplier_user_e-mail']);
					if ($duplicate)
					{
						$errors['supplier_user_e-mail'] = 'Cet identifiant est déjà utilisé.';
					}
				}
			}
			
			if(!$data['supplier_user_password']) {
				$errors['supplier_user_password'] = 'Mot de passe manquant.';
			}
			
			if (!$errors)
			{
				$data['supplier_user_password'] = md5(md5($data['supplier_user_password']).DM_Wordpress_Config::get('Security.Password.Salt'));
				$data['supplier_user_login'] = $data['supplier_user_e-mail'];

				$saved = $suppliers_users->admin_edit_update_profile($data, $supplier_user_id);

				
				if ($saved)
				{
					$to      = $data['supplier_user_e-mail'];
					$subject = 'DeviceMed.fr - Création d\'un compte fournisseur';
					$message = 'Bonjour ! Bienvenue sur DeviceMed.fr.<br />Votre inscription a bien été prise en compte, vous pouvez désormais vous connecter à votre compte avec les identifiants suivants :<br /><br />';
					$message .= '<a href=\'http://www.device-med.fr/members/login\'>http://www.device-med.fr/members/login</a><br />';
					$message .= 'Identifiant : '. $data['supplier_user_e-mail'] .'<br />Mot de passe : Seul vous le connaissez !<br /><br />';
					$message .= 'Vous pourrez gérer votre société une fois qu\'une société sera assigné à votre compte, par un administrateur.';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					
					if (!mail($to, $subject, $message, $headers))
					{
						$errors['general'] = 'Une erreur est survenue lors de l\'envoi du message de confirmation.';
					}
					else
					{
						header('Location:http://www.device-med.fr/?inscription_fournisseur=1');
						$data['supplier_user_e-mail'] = '';
					}
				}
			}
		}
	?>
	<div id="sidebar" class="column col-md-3 col-sm-4 column-sidebar">
		<!--<section id="sidebar-annual-guide">
			<div class="right-side">
				<h1 class="title">Guide annuel</h1>
				<span class="download">Télécharger</span>
			</div>
			<div class="left-side">
				<img src="<?php echo get_template_directory_uri(); ?>/images/devicemed-issue-sample.png" />
			</div>
		</section>-->
		<?php if ($supplier['supplier_premium'] != 1) { ?>
			<?php
				$banniere_model = new DM_Wordpress_Banniere_Model();
				$banniereAfficher = $banniere_model->display_banniere(1, $_SESSION['arrayBanniereAfficher']);
				
				$banniere_id = $banniereAfficher[0]['ID'];
				$_SESSION['arrayBanniereAfficher'] .= ','. $banniere_id;
				$image = $banniereAfficher[0]['image'];
				$lien = $banniereAfficher[0]['lien'];
				
				if($banniere_id != '') {
			?>
				<section id='sidebar-banniere'>
				<?php
					echo "<a href='http://www.device-med.fr/?url=$lien&id=$banniere_id' id='$banniere_id' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/$image' /></a>";
				?>
				</section>
			<?php } ?>
		<?php } ?>
		<!--<section id="sidebar-supplier-registration">
			<header>
				<div class="left-side">
					<img src="<?php echo get_template_directory_uri(); ?>/images/sidebar-supplier-registration-icon.png"" />
				</div>
				<div class="right-side">
					<h1 class="title">S'inscrire comme fournisseur</h1>
				</div>
			</header>
			<div class="supplier-registration-form">
				<form method='GET' action="http://www.device-med.fr/">
					<input type="text" name="supplier_user_e-mail" value="<?php echo $data['supplier_user_e-mail']; ?>" placeholder="email" />
					<div><?php if($errors['supplier_user_e-mail']) { ?><div class='form-error'><?php echo $errors['supplier_user_e-mail'] ?></div><?php } ?></div>
					<input type="password" name="supplier_user_password" value="" placeholder="Mot de passe" />
					<div><?php if($errors['supplier_user_password']) { ?><div class='form-error'><?php echo $errors['supplier_user_password'] ?></div><?php } ?></div>
					<div><?php if($success['general']) { ?><div class='form-success'><?php echo $success['general'] ?></div><?php } ?><?php if($errors['general']) { ?><div class='form-error'><?php echo $errors['general'] ?></div><?php } ?></div>
					<input type="submit" value="Valider" />
				</form>
			</div>
		</section>-->
		<?php include_once('agenda.php'); ?>
		<section id="sidebar-issues">
			<header>
				<div class="right-side">
					<h1 class="title"><a href='http://www.devicemed.fr/archives'>Dernier numéro</a></h1>
				</div>
			</header>	
			<?php
				$archiveModel = new DM_Wordpress_Archive_Model();
				$archives = array();
				$urlTemp = get_bloginfo('url');
				
				foreach ($archiveModel->get_archives(1) as $archive)
				{
					$titreArchive = $archive['titre_archive'];
					$urlImg = $urlTemp ."/wp-content/uploads/archives/apercu/". $archive['apercu_archive'];
					$lienPdf = $urlTemp ."/wp-content/uploads/archives/pdf/". $archive['pdf_archive'];
					
					echo "<a href='$lienPdf' target='_blank'><article class='article_numero'>";
						echo "<div class='right-side'>";
							echo "<span class='issue'>$titreArchive</span>";
							echo "<span class='download'>Consulter ce numéro</span>";
						echo "</div>";
						echo "<div class='left-side' style=\"background-image:url('$urlImg');\">";
							// echo "<img src='$urlImg' />";
						echo "</div>";
					echo "</article></a>";
				}
			?>
			<a href="<?php echo $urlTemp; ?>/archives" class="more">Consulter d'autres numéros</a>
		</section>
		<!--<section id="sidebar-issues">
			<header>
				<div class="right-side">
					<h1 class="title">Guide de l'acheteur</h1>
				</div>
			</header>	
			<?php
				if ($session = DM_Wordpress_Members::session()):
					echo "<a href='http://www.devicemed.fr/wp-content/uploads/archives/pdf/juillet_aout2014.pdf' target='_blank'><article>";
						echo "<div class='right-side'>";
							echo "<span class='issue'>Guide de l'acheteur</span>";
							echo "<span class='download'>Consulter le guide</span>";
						echo "</div>";
						echo "<div class='left-side' style=\"background-image:url('http://www.devicemed.fr/wp-content/uploads/archives/apercu/juillet_aout2014.PNG');\">";
							// echo "<img src='$urlImg' />";
						echo "</div>";
					echo "</article></a>";
				else:
					echo "<article id='bloc_guide_acheteur'>";
						echo "<div class='right-side'>";
							echo "<span class='issue'>Guide de l'acheteur</span>";
							echo "<span class='download'>Consulter le guide</span>";
						echo "</div>";
						echo "<div class='left-side' style=\"background-image:url('http://www.devicemed.fr/wp-content/uploads/archives/apercu/juillet_aout2014.PNG');\">";
							// echo "<img src='$urlImg' />";
						echo "</div>";
					echo "</article>";
				endif;
			?>
		</section>-->
		<!--<section id="sidebar-video">
			<header>
				<h1 class="title">Vidéo</h1>
			</header>
			<div class="video-wrapper">
				<img src="http://placehold.it/350x250" alt="" />
			</div>
		</section>-->
		<!--<section id="sidebar-agenda">
			<header>
				<div class="left-side">
					<img src="<?php echo get_template_directory_uri(); ?>/images/sidebar-supplier-registration-icon.png"" />
				</div>
				<div class="right-side">
					<h1 class="title">Agenda</h1>
				</div>
			</header>
			<div class="events">Aucun événement à venir</div>
		</section>-->
	</div> 
	</div><!-- .column-content -->

<footer id="footer">
	<div class="copyright">Deviced.fr est une marque de Vogel Business Media. <a href='http://www.devicemed.de/' target='_blank'>Cliquer ici pour découvrir le site de DeviceMed Allemagne</a>.</div>
	<div class="pages"><?php devicemed_footer_menu('Bas de page - Première ligne'); ?></div>
	<div class="credits"><?php devicemed_footer_menu('Bas de page - Deuxième ligne'); ?></div>
</footer>

</div><!-- .container -->
<?php wp_footer(); ?>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.bxslider.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/colorbox/jquery.colorbox-min.js"></script>
</body>
</html>
<!-- FIN FOOTER -->