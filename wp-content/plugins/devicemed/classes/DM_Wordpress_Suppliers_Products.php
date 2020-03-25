<?php
class DM_Wordpress_Suppliers_Products
{
	static private $upload_directory;
	static private $upload_url;
	static private $medias_directory;
	static private $medias_url;

	static public function initialize()
	{
		DM_Wordpress_Router::add('/suppliers/products/add', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/products/edit/@product_id', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/products/delete/@product_id', array(__CLASS__, 'delete'));
		DM_Wordpress_Router::add('/suppliers/products/upload', array(__CLASS__, 'upload'));
		DM_Wordpress_Router::add('/suppliers/products/@supplier_id', array(__CLASS__, 'display_products'));
		
		$wp_upload_dir = wp_upload_dir();
		self::$upload_directory = $wp_upload_dir['basedir'].'/suppliers/products/uploads/';
		self::$upload_url = $wp_upload_dir['baseurl'].'/suppliers/products/uploads/';
		self::$medias_directory = $wp_upload_dir['basedir'].'/suppliers/products/';
		self::$medias_url = $wp_upload_dir['baseurl'].'/suppliers/products/';
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
		$product_id = isset($params['product_id']) ? (int) $params['product_id'] : NULL;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_products = new DM_Wordpress_Suppliers_Products_Model();
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
			'ID' => $product_id,
			'supplier_id' => $session['supplier_id'],
			'supplier_user_id' => $session['ID'],
			'supplier_product_title' => '',
			'supplier_product_content' => '',
			'supplier_product_created' => date('Y-m-d H:i:s'),
			'supplier_product_modified' => date('Y-m-d H:i:s'),
			'supplier_product_status' => 0,
			'supplier_product_featured_file' => '',
			'supplier_product_files' => array(),
			'supplier_product_uploaded_files' => array()
		);
		$errors = array();

		if ($product_id)
		{
			$results = $suppliers_products->admin_edit_get_product($product_id);

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
			$results = $suppliers_medias->get_medias_by_related('Product', $product_id);
			foreach ($results as $row)
			{
				$metas = $row['supplier_media_metas'];
				$data['supplier_product_files'][] = $metas['filename'];
				if ($metas['featured'])
				{
					$data['supplier_product_featured_file'] = $metas['filename'];
				}
			}
		}

		if (!empty($_POST))
		{
			$data['supplier_product_files'] = array();
			$data['supplier_product_featured_file'] = '';

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
			
			if (!$data['supplier_product_title'])
			{
				$errors['supplier_product_title'] = 'Veuillez indiquer le nom du produit.';
			}
			if (!$data['supplier_product_content'])
			{
				$errors['supplier_product_content'] = 'Veuillez indiquer le contenu de la fiche produit.';
			}

			if (!$errors)
			{
				if (!$product_id)
				{
					$product_id = $suppliers_products->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_product_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_id'] = $session['ID'];
					$suppliers_products->save($fields, $product_id);
				}

				if ($product_id)
				{
					$results = $suppliers_medias->get_medias_by_related('Product', $product_id);
					foreach ($results as $row)
					{
						$metas = $row['supplier_media_metas'];
						if (!in_array($metas['filename'], $data['supplier_product_files']))
						{
							$suppliers_medias->delete($row['ID']);
							@unlink(self::get_media_path($product_id, $metas['filename']));
							@unlink(self::get_media_thumbnail_path($product_id, $metas['filename']));
						}
						else
						{
							$featured = $metas['filename'] == $data['supplier_product_featured_file'];
							$suppliers_medias->save(array(
								'supplier_media_metas' => serialize(array_merge($metas, array(
									'featured' => $featured
								)))
							), $row['ID']);
						}
					}
					foreach ($data['supplier_product_uploaded_files'] as $file)
					{
						if (!file_exists(self::get_media_path($product_id)))
						{
							mkdir(self::get_media_path($product_id), 0777, true);
						}
						rename(self::get_upload_path($file), self::get_media_path($product_id, $file));

						if (!file_exists(self::get_media_thumbnail_path($product_id)))
						{
							mkdir(self::get_media_thumbnail_path($product_id), 0777, true);
						}
						rename(self::get_upload_thumbnail_path($file), self::get_media_thumbnail_path($product_id, $file));

						$suppliers_medias->save(array(
							'supplier_id' => $session['supplier_id'],
							'supplier_user_id' => $session['ID'],
							'supplier_media_related_id' => $product_id,
							'supplier_media_related_type' => 'Product',
							'supplier_media_metas' => serialize(array(
								'filename' => $file,
								'filetype' => 'image',
								'featured' => $file == $data['supplier_product_featured_file']
							)),
							'supplier_media_created' => date('Y-m-d H:i:s'),
							'supplier_media_modified' => date('Y-m-d H:i:s'),
							'supplier_media_status' => 1
						));
					}
					wp_redirect(site_url('/suppliers/products/edit/'.$product_id));
				}
			}
		}

		DM_Wordpress::title(array('Fournisseurs', $product_id ? 'Modifier la fiche produit' : 'Ajouter la fiche produit'));
		DM_Wordpress_Template::theme('suppliers/product_edit', array(
			'data' => $data,
			'errors' => $errors
		));
	}
	static public function display_products($params)
	{
		$supplier_id = (int) $params['supplier_id'];
		$supplier = $posts = array();

		$suppliers = new DM_Wordpress_Suppliers_Model();
		if ($supplier = $suppliers->get_supplier($supplier_id))
		{
			if ($supplier['supplier_status'] == 1)
			{
				$suppliers_products = new DM_Wordpress_Suppliers_Products_Model();
				$products = $suppliers_products->get_last_products_by_supplier_id($supplier['ID'], '');
				$session = DM_Wordpress_Members::session();
		
				$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
				$category = $suppliers_categories->get_categories($supplier['supplier_category_id']);
				
				DM_Wordpress::title(array('Tous les produits', esc_html($supplier['supplier_name'])));
			}
		}
		
		DM_Wordpress_Template::theme('suppliers/products', array(
			'products' => $products,
			'supplier' => $supplier,
			'category' => $category,
			'session' => $session
		));
	}
	static public function get_media_path($product_id, $filename = '')
	{
		return self::$medias_directory.$product_id.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_url($product_id, $filename = '')
	{
		return self::$medias_url.$product_id.'/'.$filename;
	}

	static public function get_media_thumbnail_path($product_id, $filename = '')
	{
		return self::$medias_directory.$product_id.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_thumbnail_url($product_id, $filename = '')
	{
		return self::$medias_url.$product_id.'/thumbnail/'.$filename;
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

	static public function get_medias($product_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_medias_by_related('Product', $product_id);
	}

	static public function get_featured_media($product_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		return $suppliers_medias->get_featured_media_by_related('Product', $product_id);
	}
}