<?php
class DM_Wordpress_Suppliers_Event
{
	static private $upload_directory;
	static private $upload_url;
	static private $medias_directory;
	static private $medias_url;

	static public function initialize()
	{
		DM_Wordpress_Router::add('/suppliers/events/add', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/events/edit/@event_id', array(__CLASS__, 'edit'));
		// DM_Wordpress_Router::add('/suppliers/products/delete/@product_id', array(__CLASS__, 'delete'));
		// DM_Wordpress_Router::add('/suppliers/products/upload', array(__CLASS__, 'upload'));
		DM_Wordpress_Router::add('/suppliers/events/@supplier_id', array(__CLASS__, 'display_events'));
		
		$wp_upload_dir = wp_upload_dir();
		self::$upload_directory = $wp_upload_dir['basedir'].'/suppliers/events/uploads/';
		self::$upload_url = $wp_upload_dir['baseurl'].'/suppliers/events/uploads/';
		self::$medias_directory = $wp_upload_dir['basedir'].'/suppliers/events/';
		self::$medias_url = $wp_upload_dir['baseurl'].'/suppliers/events/';
	}
	// static public function upload($params)
	// {
		// $upload_dir = wp_upload_dir();
		// $handler = new DM_Wordpress_UploadHandler(array(
			// 'script_url' => site_url('/suppliers/products/upload'),
			// 'upload_dir' => self::$upload_directory,
			// 'upload_url' => self::$upload_url,
			// 'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i'
		// ));
		// exit;
	// }
	static public function edit($params)
	{
		$session = DM_Wordpress_Members::session();
		$event_id = isset($params['event_id']) ? (int) $params['event_id'] : NULL;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_event = new DM_Wordpress_Suppliers_Event_Model();
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();

		if (!$session['ID'])
		{
			wp_redirect(site_url('/members/login'));
			exit;
		}

		if (!$session['user_group'] == 'suppliers')
		{
			wp_redirect(site_url('/403'));
			exit;
		}

		$data = array(
			'ID' => $event_id,
			'supplier_id' => $session['supplier_id'],
			'supplier_user_id' => $session['ID'],
			'supplier_event_title' => '',
			'supplier_event_apercu' => '',
			'supplier_event_created' => date('Y-m-d H:i:s'),
			'supplier_event_modified' => date('Y-m-d H:i:s'),
			'supplier_event_debut' => '',
			'supplier_event_fin' => '',
			'supplier_event_lieu' => '',
			'supplier_event_description' => '',
			'supplier_event_status' => 0,
			'supplier_event_featured_file' => '',
			'supplier_event_files' => array(),
			'supplier_event_uploaded_files' => array()
		);
		$errors = array();

		if ($event_id)
		{
			$results = $suppliers_event->admin_edit_get_event($event_id);

			if ($session['supplier_id'] != $results['supplier_id'])
			{
				wp_redirect(site_url('/403'));
				exit;
			}

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
			$data['supplier_event_files'] = array();
			$data['supplier_event_featured_file'] = '';

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
			
			if (!$data['supplier_event_title'])
			{
				$errors['supplier_event_title'] = 'Veuillez indiquer le titre de l\'évènement.';
			}
			if (!$data['supplier_event_description'])
			{
				$errors['supplier_event_description'] = 'Veuillez indiquer la description de l\'évènement.';
			}
			if (!$data['supplier_event_debut'])
			{
				$errors['supplier_event_debut'] = 'Veuillez indiquer le début de l\'évènement.';
			}
			if (!$data['supplier_event_fin'])
			{
				$errors['supplier_event_fin'] = 'Veuillez indiquer la fin de l\'évènement.';
			}
			if (!$data['supplier_event_lieu'])
			{
				$errors['supplier_event_lieu'] = 'Veuillez indiquer le lieu de l\'évènement.';
			}

			if (!$errors)
			{
				$fichierApercu = $_FILES['image_event']['name'];
				$data['supplier_event_apercu'] = $fichierApercu;
				
				if (!$event_id)
				{
					$event_id = $suppliers_event->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_event_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_id'] = $session['ID'];
					$suppliers_event->save($fields, $event_id);
				}
				
				if (!file_exists(self::get_media_path($event_id)))
				{
					mkdir(self::get_media_path($event_id), 0777, true);
				}
				
				if($_FILES['image_event']) {
					$dossier_apercu = self::get_media_path($event_id);
					$resultatPdf = move_uploaded_file($_FILES['image_event']['tmp_name'], $dossier_apercu . $fichierApercu);
				}
				
				if ($event_id)
				{
					wp_redirect(site_url('/suppliers/events/edit/'.$event_id));
				}
			}
		}

		DM_Wordpress::title(array('Fournisseurs', $event_id ? 'Modifier l\'évènement' : 'Ajouter l\'évènement'));
		DM_Wordpress_Template::theme('suppliers/event_edit', array(
			'data' => $data,
			'errors' => $errors
		));
	}
	static public function display_events($params)
	{
		$supplier_id = (int) $params['supplier_id'];
		$supplier = $events = $category = array();

		$suppliers = new DM_Wordpress_Suppliers_Model();
		if ($supplier = $suppliers->get_supplier($supplier_id))
		{
			if ($supplier['supplier_status'] == 1)
			{
				$suppliers_events = new DM_Wordpress_Suppliers_Event_Model();
				$events = $suppliers_events->get_last_events_by_supplier_id($supplier['ID'], '');
				$session = DM_Wordpress_Members::session();
		
				$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
				$category = $suppliers_categories->get_categories($supplier['supplier_category_id']);
				
				DM_Wordpress::title(array('Tous les événements', esc_html($supplier['supplier_name'])));
			}
		}
		
		DM_Wordpress_Template::theme('suppliers/events', array(
			'events' => $events,
			'supplier' => $supplier,
			'category' => $category,
			'session' => $session
		));
	}
	static public function get_media_path($event_id, $filename = '')
	{
		return self::$medias_directory.$event_id.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_url($event_id, $filename = '')
	{
		return self::$medias_url.$event_id.'/'.$filename;
	}

	static public function get_pdf_url($download_id, $filename = '')
	{
		return self::$medias_url.'pdf/'.$download_id.'/'.$filename;
	}

	static public function get_media_thumbnail_path($event_id, $filename = '')
	{
		return self::$medias_directory.$event_id.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_thumbnail_url($event_id, $filename = '')
	{
		return self::$medias_url.$event_id.'/thumbnail/'.$filename;
	}

	static public function get_upload_path($filename = '')
	{
		return self::$upload_directory.$filename;
	}

	static public function get_upload_url($filename = '')
	{
		return self::$upload_url.$filename;
	}

	static public function get_upload_thumbnail_path($filename = '')
	{
		return self::$upload_directory.'thumbnail'.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_upload_thumbnail_url($filename = '')
	{
		return self::$upload_url.'thumbnail/'.$filename;
	}

	static public function get_medias($event_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_medias_by_related('Event', $event_id);
	}

	static public function get_featured_media($event_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_featured_media_by_related('Event', $event_id);
	}
}