<?php

class DM_Wordpress_Newsletter_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Newsletter';
	protected $menu_title = 'Ajouter une newsletter';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-newsletter-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$inscrits_id = !empty($_GET['inscrits_id']) ? (int) $_GET['inscrits_id'] : 0;
		$newsletter = new DM_Wordpress_Newsletter_Model();

		$data = array(
			'ID' => $inscrits_id,
			'mail_newsletter' => '',
			'offre_devicemed' => 0,
			'offre_partenaires' => 0,
			'code_temporaire' => '',
			'nom' => '',
			'prenom' => '',
			'ville' => '',
			'cp' => 0,
			'actif' => 0
		);
		$errors = array();
		$success = array();

		if ($inscrits_id)
		{
			$results = $newsletter->admin_edit_get_newsletter($inscrits_id);

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
			$data['mail_newsletter'] = $_POST['mail_newsletter'];
			$data['offre_devicemed'] = $_POST['offre_devicemed'];
			$data['offre_partenaires'] = $_POST['offre_partenaires'];
			$data['nom'] = $_POST['nom'];
			$data['prenom'] = $_POST['prenom'];
			$data['ville'] = $_POST['ville'];
			$data['cp'] = $_POST['cp'];
			$data['actif'] = $_POST['actif'];
			
			if (!$data['mail_newsletter'])
			{
				$errors['mail_newsletter'] = 'Veuillez indiquer une adresse mail.';
			}
			/*if (!$data['offre_devicemed'])
			{
				$errors['offre_devicemed'] = 'Voulez-vous recevoir les offres de devicemed ?';
			}
			if (!$data['offre_partenaires'])
			{
				$errors['offre_partenaires'] = 'Voulez-vous recevoir les offres de nos partenaires ?';
			}
			if (!$data['nom'])
			{
				$errors['nom'] = 'Veuillez indiquer votre nom.';
			}
			if (!$data['prenom'])
			{
				$errors['prenom'] = 'Veuillez indiquer votre prénom.';
			}
			if (!$data['ville'])
			{
				$errors['ville'] = 'Veuillez indiquer votre ville.';
			}
			if (!$data['cp'])
			{
				$errors['cp'] = 'Veuillez indiquer votre code postal.';
			}*/

			if (!$errors)
			{
				if (!$inscrits_id)
				{
					$inscrits_id = $newsletter->save_admin($data);

					if($inscrits_id != '') {
						$success['general'] = 'Le destinataire a bien été ajouté.';
					}
				}
				else
				{
					$fields = $data;
					$fields['date_modified'] = date('Y-m-d H:i:s');
					$destinataireAjout = $newsletter->save_admin($fields, $inscrits_id);

					if($destinataireAjout != '') {
						$success['general'] = 'Le destinataire a bien été modifié.';
					}
				}
			}
		}

		DM_Wordpress_Admin::css('admin.scss');

		$this->template = array(
			'page' => $this,
			'data' => $data,
			'errors' => $errors,
			'success' => $success,
			'suppliers' => $suppliers
		);
	}

	public function render()
	{
		DM_Wordpress_Template::load('newsletter_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}