<?php

class DM_Wordpress_Suppliers_Categories_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Catégorie fournisseur';
	protected $menu_title = 'Ajouter une catégorie';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-categories-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
		$supplier_category_id = !empty($_GET['supplier_category_id']) ? (int) $_GET['supplier_category_id'] : 0;

		$data = array(
			'supplier_category_id' => $supplier_category_id,
			'supplier_category_title' => ''
		);
		$errors = array();

		if ($supplier_category_id)
		{
			$row = $suppliers_categories->admin_edit_get_category($supplier_category_id);
			foreach ($data as $field => $value)
			{
				if (isset($row[ $field ]))
				{
					$data[ $field ] = $row[ $field ];
				}
			}
		}

		if (!empty($_POST))
		{
			foreach ($data as $field => $value)
			{
				if (isset($_POST[ $field ]))
				{
					$data[ $field ] = trim(stripslashes($_POST[ $field ]));
				}
			}
			if (!$data['supplier_category_title'])
			{
				$errors['supplier_category_title'] = 'Titre de la catégorie manquante.';
			}
			if (!$errors)
			{
				$fields = $data;

				$saved = $suppliers_categories->admin_edit_update_category($fields, $supplier_category_id);

				if ($saved)
				{
					wp_redirect($this->url(array('supplier_category_id' => $supplier_category_id ? $supplier_category_id : $saved)));
				}
			}
		}

		$this->template = array(
			'page' => $this,
			'data' => $data,
			'errors' => $errors
		);
	}

	public function render()
	{
		DM_Wordpress_Template::load('suppliers_categories_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}