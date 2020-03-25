<?php
class DM_Wordpress_Suppliers_Galleries
{
	static private $upload_directory;
	static private $upload_url;
	static private $medias_directory;
	static private $medias_url;

	static public function initialize()
	{
		DM_Wordpress_Router::add('/suppliers/galleries/add', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/galleries/edit/@gallery_id', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/galleries/delete/@gallery_id', array(__CLASS__, 'delete'));
		DM_Wordpress_Router::add('/suppliers/galleries/upload', array(__CLASS__, 'upload'));
		DM_Wordpress_Router::add('/suppliers/galleries/@supplier_id', array(__CLASS__, 'display_images'));
		
		$wp_upload_dir = wp_upload_dir();
		self::$upload_directory = $wp_upload_dir['basedir'].'/suppliers/galleries/uploads/';
		self::$upload_url = $wp_upload_dir['baseurl'].'/suppliers/galleries/uploads/';
		self::$medias_directory = $wp_upload_dir['basedir'].'/suppliers/galleries/';
		self::$medias_url = $wp_upload_dir['baseurl'].'/suppliers/galleries/';
	}
	static public function upload($params)
	{
		$upload_dir = wp_upload_dir();
		$handler = new DM_Wordpress_UploadHandler(array(
			'script_url' => site_url('/suppliers/galleries/upload'),
			'upload_dir' => self::$upload_directory,
			'upload_url' => self::$upload_url,
			'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i'
		));
		exit;
	}
	static public function edit($params)
	{
		$session = DM_Wordpress_Members::session();
		$gallery_id = isset($params['gallery_id']) ? (int) $params['gallery_id'] : NULL;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_galleries = new DM_Wordpress_Suppliers_Galleries_Model();
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
			'ID' => $gallery_id,
			'supplier_id' => $session['supplier_id'],
			'supplier_user_id' => $session['ID'],
			'supplier_gallery_title' => '',
			'supplier_gallery_created' => date('Y-m-d H:i:s'),
			'supplier_gallery_modified' => date('Y-m-d H:i:s'),
			'supplier_gallery_status' => 0,
			'supplier_gallery_featured_file' => '',
			'supplier_gallery_files' => array(),
			'supplier_gallery_uploaded_files' => array()
		);
		$errors = array();

		if ($gallery_id)
		{
			$results = $suppliers_galleries->admin_edit_get_gallery($gallery_id);

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
			$results = $suppliers_medias->get_medias_by_related('Gallery', $gallery_id);
			foreach ($results as $row)
			{
				$metas = $row['supplier_media_metas'];
				$data['supplier_gallery_files'][] = $metas['filename'];
				if ($metas['featured'])
				{
					$data['supplier_gallery_featured_file'] = $metas['filename'];
				}
			}
		}

		if (!empty($_POST))
		{
			$data['supplier_gallery_files'] = array();
			$data['supplier_gallery_featured_file'] = '';

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
			
			if (!$data['supplier_gallery_title'])
			{
				$errors['supplier_gallery_title'] = 'Veuillez indiquer le titre de la galerie.';
			}
			if (!$data['supplier_gallery_files'] AND !$data['supplier_gallery_uploaded_files'])
			{
				$errors['supplier_gallery_files'] = 'Veuillez ajouter des images à la galerie.';
			}

			if (!$errors)
			{
				if (!$gallery_id)
				{
					$gallery_id = $suppliers_galleries->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_gallery_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_id'] = $session['ID'];
					$suppliers_galleries->save($fields, $gallery_id);
				}

				if ($gallery_id)
				{
					$results = $suppliers_medias->get_medias_by_related('Gallery', $gallery_id);
					foreach ($results as $row)
					{
						$metas = $row['supplier_media_metas'];
						if (!in_array($metas['filename'], $data['supplier_gallery_files']))
						{
							$suppliers_medias->delete($row['ID']);
							@unlink(self::get_media_path($gallery_id, $metas['filename']));
							@unlink(self::get_media_thumbnail_path($gallery_id, $metas['filename']));
						}
						else
						{
							$featured = $metas['filename'] == $data['supplier_gallery_featured_file'];
							$suppliers_medias->save(array(
								'supplier_media_metas' => serialize(array_merge($metas, array(
									'featured' => $featured
								)))
							), $row['ID']);
						}
					}
					foreach ($data['supplier_gallery_uploaded_files'] as $file)
					{
						if (!file_exists(self::get_media_path($gallery_id)))
						{
							mkdir(self::get_media_path($gallery_id), 0777, true);
						}
						rename(self::get_upload_path($file), self::get_media_path($gallery_id, $file));

						if (!file_exists(self::get_media_thumbnail_path($gallery_id)))
						{
							mkdir(self::get_media_thumbnail_path($gallery_id), 0777, true);
						}
						rename(self::get_upload_thumbnail_path($file), self::get_media_thumbnail_path($gallery_id, $file));

						$suppliers_medias->save(array(
							'supplier_id' => $session['supplier_id'],
							'supplier_user_id' => $session['ID'],
							'supplier_media_related_id' => $gallery_id,
							'supplier_media_related_type' => 'Gallery',
							'supplier_media_metas' => serialize(array(
								'filename' => $file,
								'filetype' => 'image',
								'featured' => $file == $data['supplier_gallery_featured_file']
							)),
							'supplier_media_created' => date('Y-m-d H:i:s'),
							'supplier_media_modified' => date('Y-m-d H:i:s'),
							'supplier_media_status' => 1
						));
					}
					wp_redirect(site_url('/suppliers/galleries/edit/'.$gallery_id));
				}
			}
		}

		DM_Wordpress::title(array('Fournisseurs', $gallery_id ? 'Modifier galerie' : 'Ajouter galerie'));
		DM_Wordpress_Template::theme('suppliers/gallery_edit', array(
			'data' => $data,
			'errors' => $errors
		));
	}
	static public function display_images($params)
	{
		$supplier_id = (int) $params['supplier_id'];
		$supplier = $posts = array();

		$suppliers = new DM_Wordpress_Suppliers_Model();
		if ($supplier = $suppliers->get_supplier($supplier_id))
		{
			if ($supplier['supplier_status'] == 1)
			{
				$suppliers_galleries = new DM_Wordpress_Suppliers_Galleries_Model();
				$galleries = $suppliers_galleries->get_last_galleries_by_supplier_id($supplier['ID'], 10);
				$suppliers_videos = new DM_Wordpress_Suppliers_Videos_Model();
				$videos = $suppliers_videos->get_last_videos_by_supplier_id($supplier['ID'], 10);
				$session = DM_Wordpress_Members::session();
		
				$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
				$category = $suppliers_categories->get_categories($supplier['supplier_category_id']);
				
				DM_Wordpress::title(array('Toutes les images', esc_html($supplier['supplier_name'])));
			}
		}
		
		DM_Wordpress_Template::theme('suppliers/gallery', array(
			'galleries' => $galleries,
			'videos' => $videos,
			'medias' => $medias,
			'supplier' => $supplier,
			'category' => $category,
			'session' => $session
		));
	}
	static public function get_media_path($gallery_id, $filename = '')
	{
		return self::$medias_directory.$gallery_id.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_url($gallery_id, $filename = '')
	{
		return self::$medias_url.$gallery_id.'/'.$filename;
	}

	static public function get_legend_image($gallery_id, $filename)
	{
		$legend_image = DM_Wordpress_Suppliers_Galleries_Model::get_legend_image($gallery_id, $filename);
		return $legend_image;
	}

	static public function get_media_thumbnail_path($gallery_id, $filename = '')
	{
		return self::$medias_directory.$gallery_id.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_thumbnail_url($gallery_id, $filename = '')
	{
		return self::$medias_url.$gallery_id.'/thumbnail/'.$filename;
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

	static public function get_medias($gallery_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_medias_by_related('Gallery', $gallery_id);
	}

	static public function get_featured_media($gallery_id, $gallery_admin = NULL)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		
		if(!$gallery_admin) {
			return $suppliers_medias->get_featured_media_by_related('Gallery', $gallery_id);
		}else {
			return $suppliers_medias->get_featured_media_by_related('Gallery', $gallery_id, 'gallery_admin');
		}
	}
}