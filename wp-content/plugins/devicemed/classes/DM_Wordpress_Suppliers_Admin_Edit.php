<?php

class DM_Wordpress_Suppliers_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Ajouter un fournisseur';
	protected $menu_title = 'Ajouter un fournisseur';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$suppliers = new DM_Wordpress_Suppliers_Model();
		$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
		$supplier_id = !empty($_GET['supplier_id']) ? (int) $_GET['supplier_id'] : 0;

		$categories = array();
		foreach ($suppliers_categories->admin_get_categories() as $result)
		{
			$categories[ $result->ID ] = $result->supplier_category_title;
		}

		$data = array(
			'supplier_id' => $supplier_id,
			'supplier_category_id' => 0,
			'supplier_name' => '',
			'supplier_address' => '',
			'supplier_postalcode' => '',
			'supplier_telephone' => '',
			'supplier_city' => '',
			'supplier_country' => '',
			'supplier_website' => '',
			'supplier_social_blog' => '',
			'supplier_social_facebook' => '',
			'supplier_social_twitter' => '',
			'supplier_social_youtube' => '',
			'supplier_social_google_plus' => '',
			'supplier_social_linkedin' => '',
			'supplier_about' => '',
			'supplier_created' => date('Y-m-d H:i:s'),
			'supplier_modified' => date('Y-m-d H:i:s'),
			'supplier_status' => '1',
			'supplier_premium' => 0,
			'supplier_contact_nom' => '',
			'supplier_contact_mail' => '',
			'supplier_contact_tel' => '',
			'supplier_events' => '',
			'souhait_contact' => 0,
			'supplier_logo' => ''
		);
		$errors = array();

		if ($supplier_id)
		{
			$row = $suppliers->admin_edit_get_supplier($supplier_id);
			foreach ($data as $field => $value)
			{
				//if($field != 'supplier_premium') {
					if (isset($row[ $field ]))
					{
						$data[ $field ] = $row[ $field ];
					}
				//}
			}
		}

		if (!empty($_POST))
		{
			$arrayCategorie = $_POST['supplier_category_id'];
			$categoriesTemp = '';
			
			for($i = 0;$i<sizeOf($arrayCategorie);$i++) {
				$idCategorie = $arrayCategorie[$i];
			
				if($i != (sizeOf($arrayCategorie)-1)) {
					$categoriesTemp .= "$idCategorie,";
				}else {
					$categoriesTemp .= "$idCategorie";
				}
			}
			
			foreach ($data as $field => $value)
			{
				if (isset($_POST[ $field ]))
				{
					$data[ $field ] = trim(stripslashes($_POST[ $field ]));
				}
			}
			
			$data['supplier_category_id'] = $categoriesTemp;
			
			if (!$data['supplier_name'])
			{
				$errors['supplier_name'] = 'Nom du fournisseur manquant.';
			}
			if (!$errors)
			{
				$fields = $data;
				
				if ($supplier_id)
				{
					$fields['supplier_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_city'] = $suppliers->string_sanitize_nicename($fields['supplier_city']);
					$fields['supplier_country'] = $suppliers->string_sanitize_nicename($fields['supplier_country']);
					unset($fields['supplier_created']);
				}

				$saved = $suppliers->admin_edit_update_supplier($fields, $supplier_id);

				if ($saved)
				{
					wp_redirect($this->url(array('supplier_id' => $supplier_id ? $supplier_id : $saved)));
				}
			}
		}

		$this->template = array(
			'page' => $this,
			'data' => $data,
			'categories' => $categories,
			'errors' => $errors
		);
	}

	public function render()
	{
		DM_Wordpress_Template::load('suppliers_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}
