<?php

class DM_Wordpress_Suppliers_Users_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	//protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Compte fournisseur';
	protected $menu_title = 'Ajouter un compte';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-suppliers-users-edit';

	protected $template = array();

	public function load()
	{
		$results = array();
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_model = new DM_Wordpress_Suppliers_Model();
		$supplier_user_id = !empty($_GET['supplier_user_id']) ? (int) $_GET['supplier_user_id'] : 0;

		$suppliers = array();
		foreach ($suppliers_model->admin_get_suppliers() as $result)
		{
			$suppliers[ $result->ID ] = $result->supplier_name;
		}

		$data = array(
			'supplier_id' => 0,
			'supplier_user_id' => $supplier_user_id,
			'supplier_user_login' => '',
			'supplier_user_lastname' => '',
			'supplier_user_firstname' => '',
			'supplier_user_email' => '',
			'supplier_user_sex' => 'M',
			'supplier_user_address' => '',
			'supplier_user_postalcode' => '',
			'supplier_user_city' => '',
			'supplier_user_country' => '',
			'supplier_user_created' => date('Y-m-d H:i:s'),
			'supplier_user_modified' => date('Y-m-d H:i:s'),
			'supplier_user_status' => '1',
			'supplier_user_new_password' => '',
			'supplier_user_new_password_confirm' => '',
			'supplier_user_password' => '',
			'supplier_user_password_confirm' => ''
		);
		$errors = array();

		if ($supplier_user_id)
		{
			$row = $suppliers_users->admin_edit_get_profile($supplier_user_id);
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
			if (!$supplier_user_id)
			{
				if (!$data['supplier_user_login'])
				{
					$errors['supplier_user_login'] = 'Identifiant manquant.';
				}
				else
				{
					$duplicate = $suppliers_users->admin_edit_check_duplicate_login($data['supplier_user_login']);
					if ($duplicate)
					{
						$errors['supplier_user_login'] = 'Cet identifiant est déjà utilisé.';
					}
				}
			}
			if (!$data['supplier_user_email'])
			{
				$errors['supplier_user_email'] = 'E-Mail manquant.';
			}
			else
			{
				$data['supplier_user_email'] = strtolower($data['supplier_user_email']);
				if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $data['supplier_user_email']))
				{
					$errors['supplier_user_email'] = 'E-Mail invalide.';
				}
			}
			if ($supplier_user_id)
			{
				if ($data['supplier_user_new_password'])
				{
					if (!$data['supplier_user_new_password_confirm'])
					{
						$errors['supplier_user_new_password_confirm'] = 'Veuillez confirmer le nouveau mot de passe.';
						$data['supplier_user_new_password'] = '';
					}
					elseif ($data['supplier_user_new_password'] != $data['supplier_user_new_password_confirm'])
					{
						$errors['supplier_user_new_password_confirm'] = 'Confirmation du nouveau mot de passe incorrect.';
						$data['supplier_user_new_password'] = $data['supplier_user_new_password_confirm'] = '';
					}
				}
			}
			else
			{
				if ($data['supplier_user_password'])
				{
					if (!$data['supplier_user_password_confirm'])
					{
						$errors['supplier_user_password_confirm'] = 'Veuillez confirmer le mot de passe.';
						$data['supplier_user_password'] = '';
					}
					elseif ($data['supplier_user_password'] != $data['supplier_user_password_confirm'])
					{
						$errors['supplier_user_password_confirm'] = 'Confirmation du mot de passe incorrect.';
						$data['supplier_user_password'] = $data['supplier_user_password_confirm'] = '';
					}
				}
			}
			if (!$errors)
			{
				$fields = $data;

				if ($fields['supplier_user_new_password'])
				{
					$fields['supplier_user_new_password'] = md5(md5($fields['supplier_user_new_password']).DM_Wordpress_Config::get('Security.Password.Salt'));
				}
				if ($fields['supplier_user_password'])
				{
					$fields['supplier_user_password'] = md5(md5($fields['supplier_user_password']).DM_Wordpress_Config::get('Security.Password.Salt'));
				}

				if ($supplier_user_id)
				{
					$fields['supplier_user_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_password'] = $fields['supplier_user_new_password'];
					$fields['supplier_user_firstname'] = $suppliers_users->string_sanitize_nicename($fields['supplier_user_firstname']);
					$fields['supplier_user_lastname'] = $suppliers_users->string_sanitize_nicename($fields['supplier_user_lastname']);
					$fields['supplier_user_city'] = $suppliers_users->string_sanitize_nicename($fields['supplier_user_city']);
					$fields['supplier_user_country'] = $suppliers_users->string_sanitize_nicename($fields['supplier_user_country']);
					$fields['supplier_user_nicename'] = $fields['supplier_user_firstname'].' '.$fields['supplier_user_lastname'];
					unset($fields['supplier_user_login']);
					unset($fields['supplier_user_created']);
				}

				$saved = $suppliers_users->admin_edit_update_profile($fields, $supplier_user_id);

				if ($saved)
				{
					wp_redirect($this->url(array('supplier_user_id' => $supplier_user_id ? $supplier_user_id : $saved)));
				}
			}
		}

		$this->template = array(
			'page' => $this,
			'data' => $data,
			'errors' => $errors,
			'suppliers' => $suppliers
		);
	}

	public function render()
	{
		DM_Wordpress_Template::load('suppliers_users_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}