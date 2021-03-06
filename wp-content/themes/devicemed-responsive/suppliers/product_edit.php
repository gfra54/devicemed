<?php
		$_SESSION['arrayBanniereAfficher'] = '';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title(' – ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link href="/wp-content/themes/devicemed-responsive/images/favicon.ico" rel="SHORTCUT ICON">
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
	<?php wp_head(); ?>
</head>
<body>

<div class="container">
<div class="bloc_top_header">
	<div class='vogel_logo'><img src='/wp-content/uploads/vogel_logo.png' /></div>
	<div class='contenu_droit'>
		<div class="links">
		<?php if ($session = DM_Wordpress_Members::session()): ?>
			<a href="<?php echo site_url('/members/profile'); ?>">Bienvenue <?php echo esc_html($session['user_nicename']); ?></a>
			<a href="<?php echo site_url('/members/logout'); ?>">Se déconnecter</a>
		<?php else: ?>
			<a href="<?php echo site_url('/members/login'); ?>">Se connecter</a>
		<?php endif; ?>
		</div>
		<div class='links'>
			<a href='/newsletter/inscription'>Archives de la newsletter</a>
		</div>
		<div class='devicemed_allemand'><a href='http://www.devicemed.de/' target='_blank'><img src='/wp-content/uploads/devicemed_allemand.png' /></a></div>
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
<?php if ($supplier['supplier_premium'] != 1) { ?>
	<section class="ad header-ad">
		<?php
			$_SESSION['arrayBanniereAfficher'] = '';
			
			$banniere_model = new DM_Wordpress_Banniere_Model();
			$banniereAfficher = $banniere_model->display_banniere(2, $_SESSION['arrayBanniereAfficher']);

			$banniere_id = $banniereAfficher[0]['ID'];
			$_SESSION['arrayBanniereAfficher'] .= $banniere_id;
			$image = $banniereAfficher[0]['image'];
			$lien = $banniereAfficher[0]['lien'];
			
			echo "<a href='http://www.device-med.fr/?url=$lien&id=$banniere_id' id='$banniere_id' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/$image' /></a>";
		?>
	</section>
<?php } ?>
<div class="row column-content page-suppliers page-suppliers-products page-suppliers-products-edit">
	<div class="col-md-9 col-sm-8 column-main">
		<section>
			<h2 class="title"><?php echo $data['ID'] ? 'Modifier une fiche produit' : 'Ajouter une fiche produit'; ?></h2>
			<div class="form-fieldset">
				<form method="post">
					<div class="form-row form-row-title">
						<div class="form-label"><label for="supplier_product_title">Nom du produit</label></div>
						<div class="form-field"><input type="text" id="supplier_product_title" name="supplier_product_title" value="<?php echo esc_attr($data['supplier_product_title']); ?>" placeholder="Nom du produit" /></div>
						<div class="form-message"><?php if (!empty($errors['supplier_product_title'])): ?><div class="form-error"><?php echo $errors['supplier_product_title']; ?></div><?php endif; ?></div>
					</div>
					<div class="form-row form-row-content">
						<div class="form-label"><label for="supplier_product_content">Contenu de la fiche produit</label></div>
						<div class="form-field"><textarea class="editable" name="supplier_product_content"><?php echo $data['supplier_product_content']; ?></textarea></div>
						<div class="form-message"><?php if (!empty($errors['supplier_product_content'])): ?><div class="form-error"><?php echo $errors['supplier_product_content']; ?></div><?php endif; ?></div>
					</div>
					<div class="form-row">
						<div class="form-label"><label>Images</label></div>
						<div class="form-field form-field-files">
							<input type="hidden" name="supplier_product_featured_file" value="<?php echo esc_attr($data['supplier_product_featured_file']); ?>" />
							<div id="files" class="upload-file-list upload-file-list-selectable">
<?php foreach ($data['supplier_product_files'] as $file): ?>
	<div class="uploaded-file upload-file-selectable">
		<input type="hidden" name="supplier_product_files[]" value="<?php echo esc_attr($file); ?>" />
		<img src="<?php echo site_url('/wp-content/uploads/suppliers/products/'.$data['ID'].'/thumbnail/'.esc_attr($file)); ?>" />
		<p><?php echo esc_html($file); ?></p>
		<button class="button-delete" data-url="<?php echo site_url('/suppliers/products/upload?file='.esc_attr($file)); ?>" data-type="DELETE">Delete</button>
	</div>
<?php endforeach; ?>
<?php foreach ($data['supplier_product_uploaded_files'] as $file): ?>
	<div class="uploaded-file">
		<input type="hidden" name="supplier_product_uploaded_files[]" value="<?php echo esc_attr($file); ?>" />
		<img src="<?php echo site_url('/wp-content/uploads/suppliers/products/uploads/thumbnail/'.esc_attr($file)); ?>" />
		<p><?php echo esc_html($file); ?></p>
		<button class="button-delete" data-url="<?php echo site_url('/suppliers/products/upload?file='.esc_attr($file)); ?>" data-type="DELETE">Delete</button>
	</div>
<?php endforeach; ?>
							</div>
							<div class="note">Cliquez sur une image dans la liste pour définir une image principale.</div>
							<div class="fileupload-wrapper">
								<label for="fileupload">Ajouter un fichier : </label><input id="fileupload" type="file" name="files[]" accept="image/*" multiple>
							</div>
						</div>
					</div>
					<div class="form-submit"><input type="submit" value="<?php if ($data['ID']): ?>Modifier la fiche produit<?php else: ?>Ajouter la fiche produit<?php endif; ?>" /></div>
				</form>
			</div>
		</section>
	</div><!-- .column-main -->

<script type="text/javascript">
/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';

	tinymce.init({
		language: 'fr_FR',
		selector: ".editable",
		plugins: "paste autolink link lists",
		menubar: false,
		toolbar: "bold italic formatselect bullist numlist link unlink",
		valid_elements: "a[href|target=_blank],strong,em,h1,h2,p,ul,ol,li,br",
		block_formats: "Paragraph=p;Titre=h1;Sous-titre=h2",
		placeholder: 'Contenu de l\'product'
	});

	var fileUploadTriggers = function() {
		var wrapper = $(this);
		var button = wrapper.find('button');
		var input = wrapper.find('input[type=hidden]');
		var featured = $('input[name=supplier_product_featured_file]');
		var image = wrapper.find('img');
		button.on('click', function(event) {
			event.preventDefault();
			$.ajax({
				url: $(this).data('url'),
				type: $(this).data('type')
			}).done(function(data) {
				if (wrapper.hasClass('selected')) {
					wrapper.siblings().first().addClass('selected');
				}
				wrapper.css({opacity: 1}).animate({opacity: 0}, function() {
					wrapper.remove();
				});
			});
		});
		image.on('click', function(event) {
			event.preventDefault();
			wrapper.siblings().removeClass('selected');
			wrapper.addClass('selected');
			featured.val(input.val());
		});
		if (!wrapper.siblings().size() || input.val() == featured.val()) {
			image.click();
		}
	}

    var url = '<?php echo site_url('/suppliers/products/upload'); ?>';
    $('#fileupload').fileupload({
		maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
				if (!file.error) {
					var wrapper = $('<div />').addClass('uploaded-file');
					$('<input type="hidden" name="supplier_product_uploaded_files[]" />')
						.val(file.name)
						.appendTo(wrapper);
					$('<img />')
						.attr('src', file.thumbnailUrl)
						.appendTo(wrapper);
					$('<p />')
						.text(file.name)
						.appendTo(wrapper);
					$('<button />')
						.addClass('button-delete')
						.text('Delete')
						.data('url', file.deleteUrl)
						.data('type', file.deleteType)
						.appendTo(wrapper);
					wrapper.appendTo('#files');
					fileUploadTriggers.apply(wrapper);
				}
            });
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
	
	$('#files > .uploaded-file').each(function() {
		fileUploadTriggers.apply(this);
	});

});
</script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.file-upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.file-upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.file-upload/js/jquery.fileupload.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/tinymce/tinymce.min.js"></script>
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
			<section id='sidebar-banniere'>
			<?php
				$banniere_model = new DM_Wordpress_Banniere_Model();
				$banniereAfficher = $banniere_model->display_banniere(1, $_SESSION['arrayBanniereAfficher']);
				
				$banniere_id = $banniereAfficher[0]['ID'];
				$_SESSION['arrayBanniereAfficher'] .= ','. $banniere_id;
				$image = $banniereAfficher[0]['image'];
				$lien = $banniereAfficher[0]['lien'];
				
				echo "<a href='http://www.device-med.fr/?url=$lien&id=$banniere_id' id='$banniere_id' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/$image' /></a>";
			?>
			</section>
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
		<section id="sidebar-issues">
			<header>
				<div class="right-side">
					<h1 class="title"><a href='/salons'>Salons et manifestations</a></h1>
				</div>
			</header>	
			<article>
				<h3 class='title2'><a href='/dossiers/actualites/pharmapack-europe-les-11-et-22-fevrier-2015/1539' target='_blank'>Pharmapack Europe<br />11-12 Février 2015/ Paris</a></h3><br />
				<h3 class='title2'><a href='/dossiers/actualites/contaminexpo-contaminexpert-du-31-mars-au-2-avril-2015-a-paris/1456' target='_blank'>Contamin'expo - contamin'expert<br />31 mars-2 avril 2015/ Paris</a></h3><br />
				<h3 class='title2'><a href='/dossiers/actualites/le-salon-industrie-retrouve-lyon-du-7-au-10-avril-prochains/2113' target='_blank'>Industrie Lyon<br />7-10 Avril 2015/ Lyon</a></h3>
			</article>
		</section>
		<section id="sidebar-issues">
			<header>
				<div class="right-side">
					<h1 class="title"><a href='/archives'>Dernier numéro</a></h1>
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
					
					echo "<a href='$lienPdf' target='_blank'><article>";
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
		<section id="sidebar-issues">
			<header>
				<div class="right-side">
					<h1 class="title">Guide de l'acheteur</h1>
				</div>
			</header>	
			<?php
				echo "<a href='/wp-content/uploads/archives/pdf/juillet_aout2014.pdf' target='_blank'><article>";
					echo "<div class='right-side'>";
						echo "<span class='issue'>Guide de l'acheteur</span>";
						echo "<span class='download'>Consulter le guide</span>";
					echo "</div>";
					echo "<div class='left-side' style=\"background-image:url('/wp-content/uploads/archives/apercu/juillet_aout2014.PNG');\">";
						// echo "<img src='$urlImg' />";
					echo "</div>";
				echo "</article></a>";
			?>
		</section>
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