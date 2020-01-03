<?php 
get_header(); ?>
<style>#sidebar-fiches {display: none !important;}</style>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="profile">
		<h2 class="title">Liste de nos fournisseurs partenaires</h2>
		<p>
			<div class="mosaique-fournisseurs" id='bloc_supplier_search'>
			<?php foreach(get_fournisseurs(array('premium'=>true)) as $fournisseur) {
				$css='';
				if($lib_mea = fournisseur_mis_en_avant($fournisseur)) {
					$css='mis-en-avant';
				}
				?>
				<div class="case-fournisseur-logo <?php echo $css;?>" data-lib_mea="<?php echo $lib_mea;?>"><a href="<?php echo $fournisseur['permalink'];?>" style="background-image: url(<?php echo $fournisseur['logo'];?>)" title="<?php echo $fournisseur['nom'];?>"><img src="<?php echo $fournisseur['logo'];?>" alt="Logo <?php echo $fournisseur['nom'];?>"></a></div>
			<?php }?>
			</div>
		</p>
					<div class='bloc_infos_fournisseurs'>
				<div class='image_repertoire'><img src='<?php echo get_template_directory_uri(); ?>/images/sidebar-supplier-registration-icon.png' /></div>
				<div class='texte_repertoire'>Vous êtes fournisseur des fabricants de dispositifs médicaux ?<br /><a href='/suppliers/inscription'><b>Figurez, vous aussi dans le répertoire. C'est rapide et gratuit.</b></a></div>
			</div>
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
