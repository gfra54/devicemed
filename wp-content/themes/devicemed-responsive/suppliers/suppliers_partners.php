<?php 
// On récupére les fournisseurs partenaires (premium)
$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE supplier_premium=1 AND supplier_status=1 ORDER BY supplier_name ASC";
$resultFournisseurs = mysql_query($sqlFournisseurs);
$nbFournisseurs = mysql_num_rows($resultFournisseurs);

if(isset($_GET['ban'])) {
	echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><!--<img src=http://i.snag.gy/En70p.jpg>-->';
	echo '<link rel="stylesheet" id="open-sans-css"  href="/wp-content/themes/devicemed-responsive/fonts/opensans-condbold.css" type="text/css" media="all" />';
	echo '<div style="padding:20px 11px;width:102px;background:#214F8E;"><center style="margin-bottom:8px;font-size:15px;line-height: 1em;color:white;text-transform:uppercase;font-family:opensans-condbold">Fournisseurs partenaires</center>';

	while($rowFournisseurs = mysql_fetch_array($resultFournisseurs)) {
							$idFournisseur = $rowFournisseurs['ID'];
							$nomFournisseur = $rowFournisseurs['supplier_name'];
							$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
							$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
							$nom = wp_trim_words($nomFournisseur,2,'');
							$nom = str_replace('Composites','Comp.',$nom);
							$nom = str_replace('Medical','Med.',$nom);
							$nom = str_replace('Medical','Med.',$nom);
		echo '<div style="padding-top:3px"><a style="font-size:14px;text-decoration:underline;color:white;font-family:opensans-condbold" href="/suppliers/$nomFournisseur2/$idFournisseur" target="_blank"><b>'.$nom.'</b></a></div>';

	}
	exit;
}

get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="profile">
		<h2 class="title">Liste de nos fournisseurs partenaires</h2>
		<p>
			<?php

				// On récupére les fournisseurs partenaires (premium)
				$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE supplier_premium=1 AND supplier_status=1 ORDER BY supplier_name ASC";
				$resultFournisseurs = mysql_query($sqlFournisseurs);
				$nbFournisseurs = mysql_num_rows($resultFournisseurs);
				
				echo "<div id='bloc_supplier_search'>";
					if($nbFournisseurs > 0) {
						while($rowFournisseurs = mysql_fetch_array($resultFournisseurs)) {
							$idFournisseur = $rowFournisseurs['ID'];
							$nomFournisseur = $rowFournisseurs['supplier_name'];
							$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
							$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
							
							echo "<div class='supplier_search'><a href=\"/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></div>";
						}
					}else {
						echo "<p>Nous avons aucun fournisseur partenaire pour le moment.</p>";
					}
				echo "</div>";
			?>
		</p>
	</section>
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


<?php get_footer(); ?>
