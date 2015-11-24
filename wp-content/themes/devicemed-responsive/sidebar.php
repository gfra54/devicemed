<?php
	$supplier_premium = $supplier['supplier_premium'];

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
		$banniereAfficher = $banniere_model->display_banniere(1, $_SESSION['arrayBanniereAfficher']);
		
		$banniere_id = $banniereAfficher[0]['ID'];
		$_SESSION['arrayBanniereAfficher'] .= ','. $banniere_id;
		$image = $banniereAfficher[0]['image'];
		$lien = $banniereAfficher[0]['lien'];

		if(stristr($_SERVER['SCRIPT_URL'],'plasturgie')!==false) {

			echo '<section id="sidebar-banniere"><a href="http://www.psbindus.com" target="_blank"><img src="http://i.imgur.com/TYQ1NkA.gif"></a></section>';

//		echo '<section id="sidebar-banniere"><a href="http://www.device-med.fr/?url=http://www.psbindus.com&amp;id=67" id="67" target="_blank"><img src="http://www.device-med.fr/wp-content/uploads/banniere/banniere_animée.gif"></a></section>';
		} else if($banniere_id != '') {
	?>
		<section id='sidebar-banniere'>
		<?php
			echo "<a href='http://www.device-med.fr/?url=$lien&id=$banniere_id' id='$banniere_id' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/$image' /></a>";
		?>
		</section>
	<?php } ?>
	<!--<section id='sidebar-banniere'>
	<?php
		// $banniere_model = new DM_Wordpress_Banniere_Model();
		// $banniereAfficher = $banniere_model->display_banniere(1, $_SESSION['arrayBanniereAfficher']);
		
		// $banniere_id = $banniereAfficher[0]['ID'];
		// $_SESSION['arrayBanniereAfficher'] .= ','. $banniere_id;
		// $image = $banniereAfficher[0]['image'];
		// $lien = $banniereAfficher[0]['lien'];
		
		// echo "<a href='http://www.device-med.fr/?url=$lien&id=$banniere_id' id='$banniere_id' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/$image' /></a>";
	?>
	</section>-->
	<?php include_once("agenda.php"); ?>
	<!--<section id="sidebar-issues">
		<header>
			<div class="right-side">
				<h1 class="title"><a href='http://www.devicemed.fr/salons'>Salons et manifestations</a></h1>
			</div>
		</header>	
		<article>
			<h3 class='title2'><a href='http://www.ephj.ch/' target='_blank'>SMT<br />2-5 juin 2015/ Genève</a></h3><br />
			<h3 class='title2'><a href='http://www.parts2clean.de/' target='_blank'>PARTS2 CLEAN<br />9-11 juin 2015/ Stuttgart</a></h3><br />
			<h3 class='title2'><a href='http://www.medteceurope.com/france' target='_blank'>Medtec France<br />10-11 juin 2015/ Besançon</a></h3>
		</article>
	</section>-->
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
	<?php
	$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	if($monUrl == "http://www.devicemed.fr/") {
	?>
		<section id="sidebar-issues">
			<header>
				<div class="right-side">
					<h1 class="title">L’INFO EN VIDÉO</h1>
				</div>
			</header>
			<!--<iframe width="230" height="150" src="https://www.youtube.com/embed/8J6pTmegit0" frameborder="0" allowfullscreen></iframe>-->				
			<img src='http://www.devicemed.fr/wp-content/uploads/videos/video_dmexperts.png' style="padding-top:12px;" id="click_video" width='230px' />
		</section>
	<?php } ?>
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
			$loop=true;			
			foreach ($archiveModel->get_archives(2) as $archive)
			{
				if($loop && !empty($archive['apercu_archive']) && !empty($archive['pdf_archive'])) {
					$loop=false;
					$titreArchive = $archive['titre_archive'];
					$urlImg = $urlTemp ."/wp-content/uploads/archives/apercu/". $archive['apercu_archive'];
					$lienPdf = $urlTemp ."/wp-content/uploads/archives/pdf/". $archive['pdf_archive'];
					
					echo "<a href='$lienPdf' target='_blank'><article class='article_numero'>";
						echo "<div class='right-side'>";
							echo "<span class='issue'>$titreArchive</span>";
							echo "<span class='download'>Consulter ce numéro</span>";
						echo "</div>";
						//echo "<div class='left-side' style=\"background-image:url('$urlImg');\">";
							echo "<img src='$urlImg' width=100%/>";
						//echo "</div>";
					echo "</article></a>";
				}
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
	<section id="sidebar-fiches">
		<header>
			<div class="right-side">
				<h1 class="title">Fournisseurs partenaires</h1>
			</div>
		</header>	
		<article>
			<?php
				// On récupére les fournisseurs partenaires
				$sqlPartners = "SELECT * FROM wordpress_dm_suppliers WHERE supplier_premium=1";
				// echo "sqlPartners : ". $sqlPartners;
				$resultPartners = mysql_query($sqlPartners);
				$nbPartners = mysql_num_rows($resultPartners);
				$j = 1;

				while($rowPartners = mysql_fetch_array($resultPartners)) {
					$idFournisseur = $rowPartners['ID'];
					$nomFournisseur = $rowPartners['supplier_name'];
					$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
					$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
					
					if($j == $nbPartners) {
						echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></h3>";
					}else {
						echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></h3><br />";
					}

					$j++;
				}
			?>
		</article>
	</section>
	<section id="sidebar-tag">
		<header>
			<div class="right-side">
				<h1 class="title">On en parle</h1>
			</div>
		</header>	
		<article>
			<?php
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/implant\" target='_blank'>Implants</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/moulage\" target='_blank'>Moulage</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/medtec\" target='_blank'>Medtec</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/impression-3d\" target='_blank'>Impression 3D</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/iso-13485\" target='_blank'>ISO 13485</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/usinage\" target='_blank'>Usinage</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/pharmapack\" target='_blank'>Pharmapack</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/salle-blanche\" target='_blank'>Salle blanche</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/instrument-chirurgical\" target='_blank'>Instruments chirurgicaux</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/mesure-3d\" target='_blank'>Mesure 3D</a></h3><br />";
				echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/tag/tracabilite\" target='_blank'>Traçabilité</a></h3><br />";
			?>
		</article>
	</section>
	<!--<section id="sidebar-tag">
		<?php wp_tag_cloud('number=10'); ?>
	</section>-->
</div>