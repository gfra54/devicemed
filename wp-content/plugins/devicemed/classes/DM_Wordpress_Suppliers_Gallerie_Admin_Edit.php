<?php

class DM_Wordpress_Suppliers_Gallerie_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Produit';
	protected $menu_title = 'Ajouter un produit';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-gallerie-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$supplier_gallery_id = !empty($_GET['supplier_gallery_id']) ? (int) $_GET['supplier_gallery_id'] : 0;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_gallery = new DM_Wordpress_Suppliers_Galleries_Model();
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		$suppliers_model = new DM_Wordpress_Suppliers_Model();
		
		$suppliers = array();
		foreach ($suppliers_model->admin_get_suppliers() as $result)
		{
			$suppliers[ $result->ID ] = $result->supplier_name;
		}

		$data = array(
			'ID' => $supplier_gallery_id,
			'supplier_id' => 0,
			'supplier_user_id' => 0,
			'supplier_gallery_title' => '',
			'supplier_gallery_created' => date('Y-m-d H:i:s'),
			'supplier_gallery_modified' => date('Y-m-d H:i:s'),
			'supplier_gallery_status' => 0,
			'supplier_gallery_featured_file' => array(),
			'supplier_gallery_files' => array(),
			'supplier_gallery_uploaded_files' => array()
		);
		$errors = array();

		if ($supplier_gallery_id)
		{
			$results = $suppliers_gallery->admin_edit_get_gallery($supplier_gallery_id);
			
			foreach ($data as $field => $value)
			{
				if (isset($results[ $field ]))
				{
					$data[ $field ] = $results[ $field ];
				}
			}
			$results = $suppliers_medias->get_medias_by_related('Gallery', $supplier_gallery_id);
			foreach ($results as $row)
			{
				$idTemp = $row['ID'];
				$metas = $row['supplier_media_metas'];
				$media = DM_Wordpress_Suppliers_Galleries::get_featured_media($idTemp, 'gallery_admin');
				$mediaFinal = $this->get_medias($idTemp);
				
				$data['supplier_gallery_files'][] = $media;
				if ($metas['featured'])
				{
					$data['supplier_gallery_featured_file'] = $media;
				}
			}
		}
		
		if (!empty($_POST))
		{
			// On mets à jour les légendes des images
			$supplier_id = $data['supplier_id'];
			$sql_media_supplier = "SELECT * FROM `wordpress_dm_suppliers_medias` WHERE supplier_id='$supplier_id'";
			$result_media_supplier = mysql_query($sql_media_supplier);
			
			while($media_array = mysql_fetch_array($result_media_supplier)) {
				$supplier_media_metas = $media_array['supplier_media_metas'];
				$arrayTempImage = explode(';', $supplier_media_metas);
				$imagePost = $arrayTempImage[1];
				$posPremierGuillemet = strpos($imagePost, '"');
				$posDernierGuillemet = strripos($imagePost, '"');
				$length = $posDernierGuillemet - $posPremierGuillemet;
				$imagePostTemp = substr($imagePost, ($posPremierGuillemet+1), ($length-1));
				$image_array = explode('.', $imagePostTemp);
				$imagePost = $image_array[0];
				
				// On récupére l'id de l'image
				$sql_id_image = "SELECT ID FROM wordpress_dm_suppliers_medias WHERE supplier_media_metas LIKE '%$imagePostTemp%' AND supplier_id='$supplier_id'";
				$result_id_image = mysql_query($sql_id_image);
				$id_image_array = mysql_fetch_array($result_id_image);
				$id_image = $id_image_array['ID'];
				
				$legend_image = $_POST['legend_'. $imagePost];
				$legend_image = addslashes($legend_image);
				
				// On mets à jour les légendes
				$sql_update_legend_image = "UPDATE wordpress_dm_suppliers_medias SET supplier_media_legende='$legend_image' WHERE ID='$id_image'";
				$result_update_legend_image = mysql_query($sql_update_legend_image);
			}
			
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
				$errors['supplier_gallery_title'] = 'Veuillez indiquer le nom du produit.';
			}
			
			if (!$errors)
			{
				if (!$supplier_gallery_id)
				{
					$supplier_gallery_id = $suppliers_gallery->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_gallery_modified'] = date('Y-m-d H:i:s');
					$suppliers_gallery->admin_edit_update_gallery($fields, $supplier_gallery_id);
				}

				if ($supplier_gallery_id)
				{
					if(!empty($data['supplier_gallery_uploaded_files'])) {
						// $results = $suppliers_medias->get_medias_by_related('Gallery', $supplier_gallery_id);
						// foreach ($results as $row)
						// {
							// $metas = $row['supplier_media_metas'];
							// if (!in_array($metas['filename'], $data['supplier_gallery_files']))
							// {
								// $suppliers_medias->delete($row['ID']);
								// @unlink(DM_Wordpress_Suppliers_Galleries::get_media_path($supplier_gallery_id, $metas['filename']));
								// @unlink(DM_Wordpress_Suppliers_Galleries::get_media_thumbnail_path($supplier_gallery_id, $metas['filename']));
							// }
							// else
							// {
								// $featured = $metas['filename'] == $data['supplier_gallery_featured_file'];
								// $suppliers_medias->save(array(
									// 'supplier_media_metas' => serialize(array_merge($metas, array(
										// 'featured' => $featured
									// )))
								// ), $row['ID']);
							// }
						// }
						
						foreach ($data['supplier_gallery_uploaded_files'] as $file)
						{
							if (!file_exists(DM_Wordpress_Suppliers_Galleries::get_media_path($supplier_gallery_id)))
							{
								mkdir(DM_Wordpress_Suppliers_Galleries::get_media_path($supplier_gallery_id), 0777, true);
							}
							
							// $tabFile = DM_Wordpress_Suppliers_Galleries::get_upload_path($file);
							$baseFile = DM_Wordpress_Suppliers_Galleries::get_upload_path($file);
							$baseFile = str_replace("/home/devicemedr/www","http://www.device-med.fr/", $baseFile);
							$destinationFile = DM_Wordpress_Suppliers_Galleries::get_media_path($supplier_gallery_id, $file);
							$destinationFile = str_replace("/home/devicemedr/www","http://www.device-med.fr/", $destinationFile);
							
							// echo "baseFile : ". $baseFile ."<br />";
							// echo "destinationFile : ". $destinationFile ."<br />";exit();
							
							rename(DM_Wordpress_Suppliers_Galleries::get_upload_path($file), DM_Wordpress_Suppliers_Galleries::get_media_path($supplier_gallery_id, $file));
							
							// echo "test : ". $test;exit();

							if (!file_exists(DM_Wordpress_Suppliers_Galleries::get_media_thumbnail_path($supplier_gallery_id)))
							{
								mkdir(DM_Wordpress_Suppliers_Galleries::get_media_thumbnail_path($supplier_gallery_id), 0777, true);
							}
							rename(DM_Wordpress_Suppliers_Galleries::get_upload_thumbnail_path($file), DM_Wordpress_Suppliers_Galleries::get_media_thumbnail_path($supplier_gallery_id, $file));
							
							// echo "path upload : ". DM_Wordpress_Suppliers_Galleries::get_upload_path($file);
							// echo "path media : ". DM_Wordpress_Suppliers_Galleries::get_media_path($supplier_gallery_id, $file);exit();

							$suppliers_medias->save(array(
								'supplier_id' => $data['supplier_id'],
								'supplier_user_id' => 0,
								'supplier_media_related_id' => $supplier_gallery_id,
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
					}
					wp_redirect($this->url(array('supplier_gallery_id' => $supplier_gallery_id ? $supplier_gallery_id : $saved)));
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

	static public function get_medias($id_image)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		$results = $suppliers_medias->get_medias_by_related('Gallery', $id_image, 'gallery_admin');
		$arrayResult = array();

		// On récupére l'image
		$imagePost = $results[0]['supplier_media_metas'];
		$arrayTempImage = explode(';', $imagePost);
		$imagePost = $arrayTempImage[1];
		$posPremierGuillemet = strpos($imagePost, '"');
		$posDernierGuillemet = strripos($imagePost, '"');
		$length = $posDernierGuillemet - $posPremierGuillemet;
		$media = substr($imagePost, ($posPremierGuillemet+1), ($length-1));
		
		array_push($arrayResult, $media);
		
		return $arrayResult[0];
	}

	public function render()
	{
		DM_Wordpress_Template::load('suppliers_galleries_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}