<?php

class DM_Wordpress_Banniere_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Bannières';
	protected $menu_title = 'Ajouter une bannière';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-bannieres-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$banniere = new DM_Wordpress_Banniere_Model();
		$banniere_id = !empty($_GET['banniere_id']) ? (int) $_GET['banniere_id'] : 0;
		
		$data = array(
			'ID' => $banniere_id,
			'nom_banniere' => '',
			'lien' => '',
			'date_fin' => '',
			'frequence' => 1,
			'affichage' => 1
		);
		$errors = array();

		if ($banniere_id)
		{
			$results = $banniere->admin_edit_get_banniere($banniere_id);

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
			foreach ($data as $field => $value)
			{
				if (isset($_POST[ $field ]))
				{
					if (is_string($_POST[ $field ]))
					{
						$data[ $field ] = trim(stripslashes($_POST[ $field ]));
					}
					else
					{
						$data[ $field ] = $_POST[ $field ];
					}
				}
			}
			
			if (!$data['nom_banniere'])
			{
				$errors['nom_banniere'] = 'Veuillez indiquer un nom à votre banniére.';
			}
			
			if (!$data['lien'])
			{
				$errors['lien'] = 'Veuillez indiquer le lien de votre publicité.';
			}	
			
			if (!$data['date_fin'])
			{
				$errors['date_fin'] = 'Veuillez indiquer une date de fin de publication.';
			}	
			
			if (!$data['frequence'])
			{
				$errors['frequence'] = 'Veuillez indiquer une fréquence d\'apparition.';
			}	
			
			if (!$data['affichage'])
			{
				$errors['affichage'] = 'Veuillez indiquer le type d\'affichage de votre bannière.';
			}	
			
			if($banniere_id == 0) {
				if ($FILES['image']['error'] != 0)
				{
					$errors['nom_banniere'] = 'Veuillez indiquer un nom à votre banniére.';
				}		
			}

			if (!$errors)
			{
				if (!$banniere_id)
				{
					$banniere_id = $banniere->save($data);
				}
				else
				{
					$fields = $data;
					$fields['date_modified'] = date('Y-m-d H:i:s');
					$saved = $banniere->save($fields, $banniere_id);
				}
				
				if ($banniere_id)
				{
					wp_redirect($this->url(array('banniere_id' => $banniere_id ? $banniere_id : $saved)));
				}else {
					echo "<span class='error'>Une erreur est survenue lors de l'ajout de la banniére.</span>";
				}
			}
		}

		DM_Wordpress_Admin::css('admin.scss');

		$this->template = array(
			'page' => $this,
			'data' => $data,
			'errors' => $errors
		);
	}

	public function render()
	{
		DM_Wordpress_Template::load('banniere_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}