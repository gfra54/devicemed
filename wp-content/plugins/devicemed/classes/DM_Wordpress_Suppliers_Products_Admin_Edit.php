<?php

class DM_Wordpress_Suppliers_Products_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Produit';
	protected $menu_title = 'Ajouter un produit';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-products-edit';

	protected $template = array();

	public function load()
	{
		$supplier_product_id = !empty($_GET['supplier_product_id']) ? (int) $_GET['supplier_product_id'] : 0;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_products = new DM_Wordpress_Suppliers_Products_Model();
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		$suppliers_model = new DM_Wordpress_Suppliers_Model();
		
		$suppliers = array();
		foreach ($suppliers_model->admin_get_suppliers() as $result)
		{
			$suppliers[ $result->ID ] = $result->supplier_name;
		}

		$data = array(
			'ID' => $supplier_product_id,
			'supplier_id' => 0,
			'supplier_user_id' => 0,
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

		if ($supplier_product_id)
		{
			$results = $suppliers_products->admin_edit_get_product($supplier_product_id);

			foreach ($data as $field => $value)
			{
				if (isset($results[ $field ]))
				{
					$data[ $field ] = $results[ $field ];
				}
			}
			$results = $suppliers_medias->get_medias_by_related('Product', $supplier_product_id);
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
				if (!$supplier_product_id)
				{
					$supplier_product_id = $suppliers_products->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_product_modified'] = date('Y-m-d H:i:s');
					$suppliers_products->save($fields, $supplier_product_id);
				}

				if ($supplier_product_id)
				{
					$results = $suppliers_medias->get_medias_by_related('Product', $supplier_product_id);
					foreach ($results as $row)
					{
						$metas = $row['supplier_media_metas'];
						if (!in_array($metas['filename'], $data['supplier_product_files']))
						{
							$suppliers_medias->delete($row['ID']);
							@unlink(DM_Wordpress_Suppliers_Products::get_media_path($supplier_product_id, $metas['filename']));
							@unlink(DM_Wordpress_Suppliers_Products::get_media_thumbnail_path($supplier_product_id, $metas['filename']));
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
						if (!file_exists(DM_Wordpress_Suppliers_Products::get_media_path($supplier_product_id)))
						{
							mkdir(DM_Wordpress_Suppliers_Products::get_media_path($supplier_product_id), 0777, true);
						}
						rename(DM_Wordpress_Suppliers_Products::get_upload_path($file), DM_Wordpress_Suppliers_Products::get_media_path($supplier_product_id, $file));

						if (!file_exists(DM_Wordpress_Suppliers_Products::get_media_thumbnail_path($supplier_product_id)))
						{
							mkdir(DM_Wordpress_Suppliers_Products::get_media_thumbnail_path($supplier_product_id), 0777, true);
						}
						rename(DM_Wordpress_Suppliers_Products::get_upload_thumbnail_path($file), DM_Wordpress_Suppliers_Products::get_media_thumbnail_path($supplier_product_id, $file));

						$suppliers_medias->save(array(
							'supplier_id' => $data['supplier_id'],
							'supplier_user_id' => 0,
							'supplier_media_related_id' => $supplier_product_id,
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
					wp_redirect($this->url(array('supplier_product_id' => $supplier_product_id ? $supplier_product_id : $saved)));
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
		DM_Wordpress_Template::load('suppliers_products_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}