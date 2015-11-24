<?php

class DM_Wordpress_Archive_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Archives';
	protected $menu_title = 'Ajouter une archive';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-archives-edit';

	protected $template = array();

	public function load()
	{
		set_time_limit(3600);
		$results = array();
		$archive = new DM_Wordpress_Archive_Model();
		$archive_id = !empty($_GET['archive_id']) ? (int) $_GET['archive_id'] : 0;
		
		$data = array(
			'ID' => $archive_id,
			'titre_archive' => '',
			'apercu_archive' => '',
			'pdf_archive' => '',
			'date_publication' => date('Y-m-d H:i:s'),
			'date_modified' => date('Y-m-d H:i:s')
		);
		$errors = array();

		if ($archive_id)
		{
			$results = $archive->admin_edit_get_archive($archive_id);

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
			
			if (!$data['titre_archive'])
			{
				$errors['titre_archive'] = 'Veuillez indiquer le nom de l\'archive.';
			}		
			
			if($archive_id == 0) {
				if ($data['apercu_archive']['error'] != 0)
				{
					$errors['apercu_archive'] = 'Veuillez ajouter un aperçu à l\'archive.';
				}		
				
				if ($data['pdf_archive']['error'] != 0)
				{
					$errors['pdf_archive'] = 'Veuillez ajouter un fichier pdf à l\'archive.';
				}
			}

			if (!$errors)
			{
				if (!$archive_id)
				{
					$archive_id = $archive->save($data);
				}
				else
				{
					$fields = $data;
					$fields['date_modified'] = date('Y-m-d H:i:s');
					$saved = $archive->save($fields, $archive_id);
					// echo "saved :". $saved;exit();
				}
				
				if ($archive_id)
				{
					wp_redirect($this->url(array('archive_id' => $archive_id ? $archive_id : $saved)));
				}else {
					echo "<span class='error'>Une erreur est survenue lors de l'ajout de l'archive.</span>";
				}
			}
		}

		DM_Wordpress_Admin::css('admin.scss');

		$this->template = array(
			'page' => $this,
			'data' => $data,
			'errors' => $errors,
			'suppliers' => $suppliers
		);
	}

	public function render()
	{
		DM_Wordpress_Template::load('archive_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}