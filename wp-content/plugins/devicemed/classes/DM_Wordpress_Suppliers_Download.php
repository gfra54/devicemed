<?php
class DM_Wordpress_Suppliers_Download
{
	static private $upload_directory;
	static private $upload_url;
	static private $medias_directory;
	static private $medias_url;

	static public function initialize()
	{
		DM_Wordpress_Router::add('/suppliers/downloads/add', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/downloads/edit/@download_id', array(__CLASS__, 'edit'));
		// DM_Wordpress_Router::add('/suppliers/products/delete/@product_id', array(__CLASS__, 'delete'));
		// DM_Wordpress_Router::add('/suppliers/products/upload', array(__CLASS__, 'upload'));
		DM_Wordpress_Router::add('/suppliers/download/@supplier_id', array(__CLASS__, 'display_download'));
		
		$wp_upload_dir = wp_upload_dir();
		self::$upload_directory = $wp_upload_dir['basedir'].'/suppliers/downloads/uploads/';
		self::$upload_url = $wp_upload_dir['baseurl'].'/suppliers/downloads/uploads/';
		self::$medias_directory = $wp_upload_dir['basedir'].'/suppliers/downloads/';
		self::$medias_url = $wp_upload_dir['baseurl'].'/suppliers/downloads/';
	}
	static public function upload($params)
	{
		$upload_dir = wp_upload_dir();
		$handler = new DM_Wordpress_UploadHandler(array(
			'script_url' => site_url('/suppliers/products/upload'),
			'upload_dir' => self::$upload_directory,
			'upload_url' => self::$upload_url,
			'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i'
		));
		exit;
	}
	static public function edit($params)
	{
		$session = DM_Wordpress_Members::session();
		$download_id = isset($params['download_id']) ? (int) $params['download_id'] : NULL;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_downloads = new DM_Wordpress_Suppliers_Download_Model();

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
			'ID' => $download_id,
			'supplier_id' => $session['supplier_id'],
			'supplier_user_id' => $session['ID'],
			'supplier_download_title' => '',
			'supplier_download_apercu' => '',
			'supplier_download_pdf' => '',
			'supplier_download_created' => date('Y-m-d H:i:s'),
			'supplier_download_modified' => date('Y-m-d H:i:s'),
			'supplier_download_status' => 0
		);
		$errors = array();

		if ($download_id)
		{
			$results = $suppliers_downloads->admin_edit_get_download($download_id);

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
			
			if (!$data['supplier_download_title'])
			{
				$errors['supplier_download_title'] = 'Veuillez indiquer le titre de l\'évènement.';
			}

			if (!$errors)
			{
				$fichierApercu= $_FILES['image_download']['name'];
				$data['supplier_download_apercu'] = $fichierApercu;
				
				$fichierPdf = $_FILES['pdf_download']['name'];
				$data['supplier_download_pdf'] = $fichierPdf;
						
				if (!$download_id)
				{
					$download_id = $suppliers_downloads->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_download_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_id'] = $session['ID'];
					$suppliers_downloads->save($fields, $download_id);
				}
				
				if ($download_id)
				{
					if (!file_exists(self::get_media_path($download_id)))
					{
						mkdir(self::get_media_path($download_id), 0777, true);
					}
					
					if (!file_exists(self::get_pdf_path($download_id)))
					{
						mkdir(self::get_pdf_path($download_id), 0777, true);
					}
					
					if($_FILES['image_download']) {
						$dossierApercu = self::get_media_path($download_id);
						$resultatApercu = move_uploaded_file($_FILES['image_download']['tmp_name'], $dossierApercu . $fichierApercu);
					}
					
					if($_FILES['pdf_download']) {
						$dossierPdf = self::get_pdf_path($download_id);
						$resultatPdf = move_uploaded_file($_FILES['pdf_download']['tmp_name'], $dossierPdf . $fichierPdf);
					}
					
					if($resultatApercu && $resultatPdf) {
						wp_redirect(site_url('/suppliers/downloads/edit/'.$download_id));
					}
				}
			}
		}

		DM_Wordpress::title(array('Fournisseurs', $download_id ? 'Modifier la documentation PDF' : 'Ajouter la documentation PDF'));
		DM_Wordpress_Template::theme('suppliers/download_edit', array(
			'data' => $data,
			'errors' => $errors
		));
	}
	static public function display_download($params)
	{
		$supplier_id = (int) $params['supplier_id'];
		$supplier = $downloads = $category = array();

		$suppliers = new DM_Wordpress_Suppliers_Model();
		if ($supplier = $suppliers->get_supplier($supplier_id))
		{
			if ($supplier['supplier_status'] == 1)
			{
				$suppliers_downloads = new DM_Wordpress_Suppliers_Download_Model();
				$downloads = $suppliers_downloads->get_last_downloads_by_supplier_id($supplier['ID'], 10);
				$session = DM_Wordpress_Members::session();
		
				$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
				$category = $suppliers_categories->get_categories($supplier['supplier_category_id']);
				
				DM_Wordpress::title(array('Toutes les documentations PDF', esc_html($supplier['supplier_name'])));
			}
		}
		
		DM_Wordpress_Template::theme('suppliers/downloads', array(
			'downloads' => $downloads,
			'supplier' => $supplier,
			'category' => $category,
			'session' => $session
		));
	}
	static public function get_media_path($download_id, $filename = '')
	{
		return self::$medias_directory.'apercu/'.$download_id.DIRECTORY_SEPARATOR.$filename;
	}
	static public function get_pdf_path($download_id, $filename = '')
	{
		return self::$medias_directory.'pdf/'.$download_id.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_url($download_id, $filename = '')
	{
		return self::$medias_url.'apercu/'.$download_id.'/'.$filename;
	}

	static public function get_pdf_url($download_id, $filename = '')
	{
		return self::$medias_url.'pdf/'.$download_id.'/'.$filename;
	}

	static public function get_media_thumbnail_path($download_id, $filename = '')
	{
		return self::$medias_directory.$download_id.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_thumbnail_url($download_id, $filename = '')
	{
		return self::$medias_url.$download_id.'/thumbnail/'.$filename;
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

	static public function get_medias($download_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_medias_by_related('Product', $download_id);
	}

	static public function get_featured_media($download_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_featured_media_by_related('Product', $download_id);
	}
}