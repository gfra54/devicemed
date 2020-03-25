<?php
class DM_Wordpress_Suppliers_Posts
{
	static private $upload_directory;
	static private $upload_url;
	static private $medias_directory;
	static private $medias_url;

	static public function initialize()
	{
		DM_Wordpress_Router::add('/suppliers/posts/add', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/posts/edit/@post_id', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/posts/delete/@post_id', array(__CLASS__, 'delete'));
		DM_Wordpress_Router::add('/suppliers/posts/upload', array(__CLASS__, 'upload'));
		DM_Wordpress_Router::add('/suppliers/posts/@supplier_id', array(__CLASS__, 'display_posts'));
		DM_Wordpress_Router::add('/posts/details/@type/@post_id', array(__CLASS__, 'post_details'));
		
		$wp_upload_dir = wp_upload_dir();
		self::$upload_directory = $wp_upload_dir['basedir'].'/suppliers/posts/uploads/';
		self::$upload_url = $wp_upload_dir['baseurl'].'/suppliers/posts/uploads/';
		self::$medias_directory = $wp_upload_dir['basedir'].'/suppliers/posts/';
		self::$medias_url = $wp_upload_dir['baseurl'].'/suppliers/posts/';
	}
	static public function upload($params)
	{
		$upload_dir = wp_upload_dir();
		$handler = new DM_Wordpress_UploadHandler(array(
			'script_url' => site_url('/suppliers/posts/upload'),
			'upload_dir' => self::$upload_directory,
			'upload_url' => self::$upload_url,
			'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i'
		));
		exit;
	}
	static public function edit($params)
	{
		$session = DM_Wordpress_Members::session();
		$post_id = isset($params['post_id']) ? (int) $params['post_id'] : NULL;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_posts = new DM_Wordpress_Suppliers_Posts_Model();
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
			'ID' => $post_id,
			'supplier_id' => $session['supplier_id'],
			'supplier_user_id' => $session['ID'],
			'supplier_post_title' => '',
			'supplier_post_content' => '',
			'supplier_post_created' => date('Y-m-d H:i:s'),
			'supplier_post_modified' => date('Y-m-d H:i:s'),
			'supplier_post_status' => 0,
			'supplier_post_featured_file' => '',
			'supplier_post_files' => array(),
			'supplier_post_uploaded_files' => array()
		);
		$errors = array();

		if ($post_id)
		{
			$results = $suppliers_posts->admin_edit_get_post($post_id);

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
			$results = $suppliers_medias->get_medias_by_related('Post', $post_id);
			foreach ($results as $row)
			{
				$metas = $row['supplier_media_metas'];
				$data['supplier_post_files'][] = $metas['filename'];
				if ($metas['featured'])
				{
					$data['supplier_post_featured_file'] = $metas['filename'];
				}
			}
		}

		if (!empty($_POST))
		{
			$data['supplier_post_files'] = array();
			$data['supplier_post_featured_file'] = '';

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
			
			if (!$data['supplier_post_title'])
			{
				$errors['supplier_post_title'] = 'Veuillez indiquer le titre de l\'article.';
			}
			if (!$data['supplier_post_content'])
			{
				$errors['supplier_post_content'] = 'Veuillez indiquer le contenu de l\'article.';
			}

			if (!$errors)
			{
				if (!$post_id)
				{
					$post_id = $suppliers_posts->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_post_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_id'] = $session['ID'];
					$suppliers_posts->save($fields, $post_id);
				}

				if ($post_id)
				{
					$results = $suppliers_medias->get_medias_by_related('Post', $post_id);
					foreach ($results as $row)
					{
						$metas = $row['supplier_media_metas'];
						if (!in_array($metas['filename'], $data['supplier_post_files']))
						{
							$suppliers_medias->delete($row['ID']);
							@unlink(self::get_media_path($post_id, $metas['filename']));
							@unlink(self::get_media_thumbnail_path($post_id, $metas['filename']));
						}
						else
						{
							$featured = $metas['filename'] == $data['supplier_post_featured_file'];
							$suppliers_medias->save(array(
								'supplier_media_metas' => serialize(array_merge($metas, array(
									'featured' => $featured
								)))
							), $row['ID']);
						}
					}
					foreach ($data['supplier_post_uploaded_files'] as $file)
					{
						if (!file_exists(self::get_media_path($post_id)))
						{
							mkdir(self::get_media_path($post_id), 0777, true);
						}
						rename(self::get_upload_path($file), self::get_media_path($post_id, $file));

						if (!file_exists(self::get_media_thumbnail_path($post_id)))
						{
							mkdir(self::get_media_thumbnail_path($post_id), 0777, true);
						}
						rename(self::get_upload_thumbnail_path($file), self::get_media_thumbnail_path($post_id, $file));

						$arraySave = array(
							'supplier_id' => $session['supplier_id'],
							'supplier_user_id' => $session['ID'],
							'supplier_media_related_id' => $post_id,
							'supplier_media_related_type' => 'Post',
							'supplier_media_metas' => serialize(array(
								'filename' => $file,
								'filetype' => 'image',
								'featured' => $file == $data['supplier_post_featured_file']
							)),
							'supplier_media_created' => date('Y-m-d H:i:s'),
							'supplier_media_modified' => date('Y-m-d H:i:s'),
							'supplier_media_status' => 1
						);
						
						$suppliers_medias->save($arraySave);
					}
					wp_redirect(site_url('/suppliers/posts/edit/'.$post_id));
				}
			}
		}

		DM_Wordpress::title(array('Fournisseurs', $post_id ? 'Modifier un article' : 'Ajouter un article'));
		DM_Wordpress_Template::theme('suppliers/post_edit', array(
			'data' => $data,
			'errors' => $errors
		));
	}
	static public function post_details($params) {
		$type = $params['type'];
		
		if($type == 'post') {
			$post_id = (int) $params['post_id'];
			$post_model = new DM_Wordpress_Suppliers_Posts_Model();
			
			$post = $post_model->get_post($post_id);
			$media = $post_model->get_media_post($post_id, 'Post');
			
			DM_Wordpress_Template::theme('suppliers/post_details', array(
				'post' => $post,
				'media' => $media
			));
		}elseif($type == 'product') {
			$post_id = (int) $params['post_id'];
			$post_model = new DM_Wordpress_Suppliers_Posts_Model();
			$product_model = new DM_Wordpress_Suppliers_Products_Model();
			
			$product = $product_model->get_product($post_id);
			$mediaProduct = $post_model->get_media_post($post_id, 'Product');
			
			DM_Wordpress_Template::theme('suppliers/post_details', array(
				'product' => $product,
				'media' => $mediaProduct
			));
		}elseif($type == 'event') {
			$post_id = (int) $params['post_id'];
			$post_model = new DM_Wordpress_Suppliers_Posts_Model();
			$event_model = new DM_Wordpress_Suppliers_Event_Model();
			
			$event = $event_model->get_event($post_id);
			
			DM_Wordpress_Template::theme('suppliers/post_details', array(
				'event' => $event
			));
		}elseif($type == 'video') {
			$post_id = (int) $params['post_id'];
			$post_model = new DM_Wordpress_Suppliers_Posts_Model();
			$video_model = new DM_Wordpress_Suppliers_Videos_Model();
			
			$video = $video_model->get_video($post_id);

			DM_Wordpress_Template::theme('suppliers/post_details', array(
				'video' => $video
			));
		}elseif($type == 'gallery') {
			$post_id = (int) $params['post_id'];
			$post_model = new DM_Wordpress_Suppliers_Posts_Model();
			$gallery_model = new DM_Wordpress_Suppliers_Galleries_Model();
			
			$gallery = $gallery_model->get_galleries($post_id);
			
			DM_Wordpress_Template::theme('suppliers/post_details', array(
				'gallery' => $gallery
			));
		}
	}
	static public function display_posts($params)
	{
		$supplier_id = (int) $params['supplier_id'];
		$supplier = $posts = $session = array();
		
		$suppliers = new DM_Wordpress_Suppliers_Model();
		if ($supplier = $suppliers->get_supplier($supplier_id))
		{
			if ($supplier['supplier_status'] == 1)
			{
				$suppliers_posts = new DM_Wordpress_Suppliers_Posts_Model();
				$posts = $suppliers_posts->get_last_posts_by_supplier_id($supplier['ID'], 10);
				$session = DM_Wordpress_Members::session();
		
				$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
				$category = $suppliers_categories->get_categories($supplier['supplier_category_id']);
				
				DM_Wordpress::title(array('Tous les Articles', esc_html($supplier['supplier_name'])));
			}
		}
		
		DM_Wordpress_Template::theme('suppliers/posts', array(
			'posts' => $posts,
			'supplier' => $supplier,
			'session' => $session,
			'category' => $category
		));
	}
	static public function get_media_path($post_id, $filename = '')
	{
		return self::$medias_directory.$post_id.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_url($post_id, $filename = '')
	{
		return self::$medias_url.$post_id.'/'.$filename;
	}

	static public function get_media_thumbnail_path($post_id, $filename = '')
	{
		return self::$medias_directory.$post_id.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_thumbnail_url($post_id, $filename = '')
	{
		return self::$medias_url.$post_id.'/thumbnail/'.$filename;
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

	static public function get_medias($post_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_medias_by_related('Post', $post_id);
	}

	static public function get_featured_media($post_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_featured_media_by_related('Post', $post_id);
	}
}