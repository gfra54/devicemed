<?php

class DM_Wordpress_Gabarit_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Gabarits';
	protected $menu_title = 'Ajouter un gabarit';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-gabarit-edit';

	protected $template = array();

	public function load()
	{
		if(isset($_GET['dynamique']) && $_GET['dynamique'] == 1) {
			$dynamique = 1;
		}else {
			$dynamique = 0;
		}
		
		$results = array();
		$gabarit_id = !empty($_GET['gabarit_id']) ? (int) $_GET['gabarit_id'] : 0;
		$gabarit = new DM_Wordpress_Gabarit_Model();

		$data = array(
			'ID' => $gabarit_id,
			'nom_gabarit'			=> '',
			'contenu_gabarit' => '',
			'mail_test' => '',
			'nom_pub' => '',
			'nom_entreprise_pub' => '',
			'lien_pub' => '',
			'image_pub' => '',
			'contenu_pub' => '',
			'date_created' => date('Y-m-d H:i:s'),
			'date_modified' => date('Y-m-d H:i:s')
		);
		$errors = array();

		if ($gabarit_id)
		{
			$results = $gabarit->admin_edit_get_gabarit($gabarit_id);

			foreach ($data as $field => $value)
			{
				if (isset($results[ $field ]))
				{
					$data[ $field ] = $results[ $field ];
				}
			}
		}
		
		if (!empty($_POST))
		{
			if($dynamique == 0) {
				$data['nom_gabarit'] = $_POST['nom_gabarit'];
				$data['contenu_gabarit'] = stripslashes($_POST['contenu_gabarit']);
				$data['mail_test'] = $_POST['mail_test'];
				
				if (!$data['nom_gabarit'])
				{
					$errors['nom_gabarit'] = 'Veuillez indiquer un nom au gabarit.';
				}
				if (!$data['contenu_gabarit'])
				{
					$errors['contenu_gabarit'] = 'Veuillez indiquer le contenu du gabarit.';
				}
				if (!$data['mail_test'])
				{
					$errors['mail_test'] = 'Veuillez indiquer le mail pour tester la newsletter.';
				}elseif(!filter_var($data['mail_test'], FILTER_VALIDATE_EMAIL)){
					$errors['mail_test'] = 'Veuillez indiquer une adresse mail valide.';
				}

				if (!$errors)
				{
					if (!$gabarit_id)
					{
						$gabarit_id = $gabarit->save($data);
					}
					else
					{
						$fields = $data;
						$fields['date_modified'] = date('Y-m-d H:i:s');
						$gabarit->save($fields, $gabarit_id);
					}
					
					wp_redirect($this->url(array('gabarit_id' => $gabarit_id ? $gabarit_id : $saved)));
				}
			}else {
				$data['nom_gabarit'] = $_POST['nom_gabarit'];
				$data['mail_test'] = $_POST['mail_test'];
				$data['nom_pub'] = $_POST['nom_pub'];
				$data['nom_entreprise_pub'] = $_POST['nom_entreprise_pub'];
				$data['lien_pub'] = $_POST['lien_pub'];
				$data['contenu_pub'] = stripslashes($_POST['contenu_pub']);
				
				if (!$data['nom_gabarit'])
				{
					$errors['nom_gabarit'] = 'Veuillez indiquer un nom au gabarit.';
				}
				if (!$data['mail_test'])
				{
					$errors['mail_test'] = 'Veuillez indiquer le mail pour tester la newsletter.';
				}elseif(!filter_var($data['mail_test'], FILTER_VALIDATE_EMAIL)){
					$errors['mail_test'] = 'Veuillez indiquer une adresse mail valide.';
				}
		
				if(!$_FILES['image_pub']['error']) {
					$dossierImagePub = '../wp-content/uploads/newsletter/';
					$fichierImagePub = $_FILES['image_pub']['name'];
					$data['image_pub'] = $fichierImagePub;

					if(!file_exists($dossierImagePub . $fichierImagePub)) {
						$resultatPdf = move_uploaded_file($_FILES['image_pub']['tmp_name'], $dossierImagePub . $fichierImagePub);
					}
				}

				if (!$errors)
				{
					if (!$gabarit_id)
					{
						$gabarit_id = $gabarit->save($data, '', 1);
					}
					else
					{
						$fields = $data;
						$fields['date_modified'] = date('Y-m-d H:i:s');
						$gabarit->save($fields, $gabarit_id, 1);
					}
					
					wp_redirect($this->url(array('gabarit_id' => $gabarit_id ? $gabarit_id : $saved, 'dynamique' => 1)));
				}
			}
		}
		
		if($_GET['action'] && $_GET['action'] == 'envoyer') {
			if($_GET['mail']) {
				$resultEnvoi = $gabarit->envoyer_newsletter($gabarit_id, $_GET['mail']);
			}else {
				$resultEnvoi = $gabarit->envoyer_newsletter($gabarit_id);
			}
			
			if($resultEnvoi != false) {
				if($_GET['mail'] != '') {
					$success['general'] = 'La newsletter test a bien été envoyé.';
				}else {
					$success['general'] = 'La newsletter a bien été envoyé.';
				}
			}else {
				if($_GET['mail'] != '') {
					$errors['general'] = 'Une erreur est survenue lors de l\'envoi de newsletter test. Veuillez contacter un administrateur.';
				}else {
					$errors['general'] = 'Une erreur est survenue lors de l\'envoi de newsletter. Veuillez contacter un administrateur.';
				}
			}
		}
		
		if($_GET['action'] && $_GET['action'] == 'envoyerDynamique') {
			if(isset($_GET['mail']) && $_GET['mail'] != '') {
				if($gabarit->envoi_mail_newsletter_dynamique($gabarit_id, $_GET['mail'])) {
					header("Refresh: 5; url=admin.php?page=devicemed-gabarit-edit&gabarit_id=21&dynamique=1");
					
					if($_GET['mail'] != '') {
						$success['general'] = 'La newsletter test a bien été envoyé.';
					}else {
						$success['general'] = 'La newsletter a bien été envoyé.';
					}
				}else {
					if($_GET['mail'] != '') {
						$errors['general'] = 'Une erreur est survenue lors de l\'envoi de newsletter test. Veuillez contacter un administrateur.';
					}else {
						$errors['general'] = 'Une erreur est survenue lors de l\'envoi de newsletter. Veuillez contacter un administrateur.';
					}
				}
			}else {
				if($gabarit->envoi_mail_newsletter_dynamique($gabarit_id)) {
					header("Refresh: 5; url=admin.php?page=devicemed-gabarit-edit&gabarit_id=21&dynamique=1");
					
					if($_GET['mail'] != '') {
						$success['general'] = 'La newsletter test a bien été envoyé.';
					}else {
						$success['general'] = 'La newsletter a bien été envoyé.';
					}
				}else {
					if($_GET['mail'] != '') {
						$errors['general'] = 'Une erreur est survenue lors de l\'envoi de newsletter test. Veuillez contacter un administrateur.';
					}else {
						$errors['general'] = 'Une erreur est survenue lors de l\'envoi de newsletter. Veuillez contacter un administrateur.';
					}
				}
			}

			// if($resultEnvoi != FALSE) {
				// if($_GET['mail'] != '') {
					// $success['general'] = 'La newsletter test a bien été envoyé.';
				// }else {
					// $success['general'] = 'La newsletter a bien été envoyé.';
				// }
			// }else {
				// if($_GET['mail'] != '') {
					// $errors['general'] = 'Une erreur est survenue lors de l\'envoi de newsletter test. Veuillez contacter un administrateur.';
				// }else {
					// $errors['general'] = 'Une erreur est survenue lors de l\'envoi de newsletter. Veuillez contacter un administrateur.';
				// }
			// }
		}

		DM_Wordpress_Admin::css('admin.scss');

		$this->template = array(
			'page' => $this,
			'data' => $data,
			'errors' => $errors,
			'suppliers' => $suppliers,
			'success' => $success
		);
	}

	public function render()
	{
		DM_Wordpress_Template::load('gabarit_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}