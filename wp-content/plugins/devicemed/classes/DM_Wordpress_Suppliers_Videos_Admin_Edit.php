<?php

class DM_Wordpress_Suppliers_Videos_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	// protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Vidéos';
	protected $menu_title = 'Ajouter une vidéo';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-videos-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$session = DM_Wordpress_Members::session();
		$supplier_video_id = !empty($_GET['supplier_video_id']) ? (int) $_GET['supplier_video_id'] : 0;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_videos = new DM_Wordpress_Suppliers_Videos_Model();
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		$suppliers_model = new DM_Wordpress_Suppliers_Model();
		
		$suppliers = array();
		foreach ($suppliers_model->admin_get_suppliers() as $result)
		{
			$suppliers[ $result->ID ] = $result->supplier_name;
		}

		$data = array(
			'supplier_id'						=> 0,
			'supplier_user_id'					=> 0,
			'supplier_video_title'			=> '',
			'supplier_video_created'			=> date('Y-m-d H:i:s'),
			'supplier_video_modified'			=> date('Y-m-d H:i:s'),
			'supplier_video_status'			=> '0',
			'supplier_video_content' => array(),
			'supplier_video_media' => array()
		);
		$errors = array();

		if ($supplier_video_id)
		{
			$results = $suppliers_videos->admin_edit_get_video($supplier_video_id);
			
			foreach ($data as $field => $value)
			{
				if (isset($results[ $field ]))
				{
					$data[ $field ] = $results[ $field ];
				}
			}
			
			$results = $suppliers_medias->get_medias_by_related('Video', $supplier_video_id);

			foreach ($results as $row)
			{
				$data['supplier_video_media'][] = $row;
			}
			
			$metas = $data['supplier_video_media'][0]['supplier_media_metas'];
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
			
			if(!$data['supplier_id']) {
				$errors['supplier_id'] = 'Veuillez indiquer un fournisseur.';
			}
			if (!$data['supplier_video_title'])
			{
				$errors['supplier_video_title'] = 'Veuillez indiquer le titre de la galerie.';
			}
			if (empty($data['supplier_video_media']))
			{
				if (!$data['supplier_video_content'])
				{
					$errors['supplier_video_content'] = 'Veuillez entrer le code d\'intégration, ou le lien de la vidéo.';
				}
			}
			else if ($data['supplier_video_content'] AND !DM_Wordpress_Suppliers_Videos::detect_provider_video($data['supplier_video_content']))
			{
				$errors['supplier_video_content'] = 'Contenu exportable ou lien de la vidéo incorrect.';
			}

			if (!$errors)
			{
				if (!$supplier_video_id)
				{
					$supplier_video_id = $suppliers_videos->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_video_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_id'] = $session['ID'];
					
					$saved = $suppliers_videos->admin_edit_update_video($fields, $supplier_video_id);
				}

				if ($supplier_video_id)
				{
					if ($data['supplier_video_content'])
					{
						$infos = DM_Wordpress_Suppliers_Videos::detect_provider_video($data['supplier_video_content']);	
						$suppliers_medias->save(array(
							'supplier_id' => $session['supplier_id'],
							'supplier_user_id' => $session['ID'],
							'supplier_media_related_id' => $supplier_video_id,
							'supplier_media_related_type' => 'Video',
							'supplier_media_metas' => serialize(array('filetype' => 'stream') + $infos),
							'supplier_media_created' => date('Y-m-d H:i:s'),
							'supplier_media_modified' => date('Y-m-d H:i:s'),
							'supplier_media_status' => 1
						), !empty($data['supplier_video_media'][0]['ID']) ? $data['supplier_video_media'][0]['ID'] : NULL);
					}
					wp_redirect($this->url(array('supplier_video_id' => $supplier_video_id ? $supplier_video_id : $saved)));
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
		DM_Wordpress_Template::load('suppliers_videos_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}