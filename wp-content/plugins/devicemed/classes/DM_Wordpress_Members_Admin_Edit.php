<?php

class DM_Wordpress_Members_Admin_Edit extends DM_Wordpress_Admin_Submenu_Page
{
	protected $parent_slug = 'devicemed-members';
	protected $page_title = 'Profil membre';
	protected $menu_title = 'Ajouter';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-members-edit';

	protected $template = array();
    
	public function load()
	{
		$results = array();
		$members = new DM_Wordpress_Members_Model();
		$user_id = !empty($_GET['user_id']) ? (int) $_GET['user_id'] : 0;

		$data = array(
			'user_id' => $user_id,
			'user_login' => '',
			'user_lastname' => '',
			'user_firstname' => '',
			'user_email' => '',
			'user_sex' => 'M',
			'user_address' => '',
			'user_postalcode' => '',
			'user_city' => '',
			'user_country' => '',
			'user_created' => date('Y-m-d H:i:s'),
			'user_modified' => date('Y-m-d H:i:s'),
			'user_status' => '1',
			'user_new_password' => '',
			'user_new_password_confirm' => '',
			'user_password' => '',
			'user_password_confirm' => ''
		);
		$errors = array();
		
		if ($user_id)
		{
			$row = $members->admin_edit_get_profile($user_id);
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
			if (!$user_id)
			{
				if (!$data['user_login'])
				{
					$errors['user_login'] = 'Identifiant manquant.';
				}
				else
				{
					$duplicate = $members->admin_edit_check_duplicate_login($data['user_login']);
					if ($duplicate)
					{
						$errors['user_login'] = 'Cet identifiant est déjà utilisé.';
					}
				}
			}
			if (!$data['user_email'])
			{
				$errors['user_email'] = 'E-Mail manquant.';
			}
			else
			{
				$data['user_email'] = strtolower($data['user_email']);
				if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $data['user_email']))
				{
					$errors['user_email'] = 'E-Mail invalide.';
				}
			}
			if ($user_id)
			{
				if ($data['user_new_password'])
				{
					if (!$data['user_new_password_confirm'])
					{
						$errors['user_new_password_confirm'] = 'Veuillez confirmer le nouveau mot de passe.';
						$data['user_new_password'] = '';
					}
					elseif ($data['user_new_password'] != $data['user_new_password_confirm'])
					{
						$errors['user_new_password_confirm'] = 'Confirmation du nouveau mot de passe incorrect.';
						$data['user_new_password'] = $data['user_new_password_confirm'] = '';
					}
				}
			}
			else
			{
				if ($data['user_password'])
				{
					if (!$data['user_password_confirm'])
					{
						$errors['user_password_confirm'] = 'Veuillez confirmer le mot de passe.';
						$data['user_password'] = '';
					}
					elseif ($data['user_password'] != $data['user_password_confirm'])
					{
						$errors['user_password_confirm'] = 'Confirmation du mot de passe incorrect.';
						$data['user_password'] = $data['user_password_confirm'] = '';
					}
				}
			}
			if (!$errors)
			{
				$fields = $data;

				if ($fields['user_new_password'])
				{
					$fields['user_new_password'] = md5(md5($fields['user_new_password']).DM_Wordpress_Config::get('Security.Password.Salt'));
				}
				if ($fields['user_password'])
				{
					$fields['user_password'] = md5(md5($fields['user_password']).DM_Wordpress_Config::get('Security.Password.Salt'));
				}

				if ($user_id)
				{
					$fields['user_modified'] = date('Y-m-d H:i:s');
					$fields['user_password'] = $fields['user_new_password'];
					$fields['user_firstname'] = $members->string_sanitize_nicename($fields['user_firstname']);
					$fields['user_lastname'] = $members->string_sanitize_nicename($fields['user_lastname']);
					$fields['user_city'] = $members->string_sanitize_nicename($fields['user_city']);
					$fields['user_country'] = $members->string_sanitize_nicename($fields['user_country']);
					$fields['user_nicename'] = $fields['user_firstname'].' '.$fields['user_lastname'];
					unset($fields['user_login']);
					unset($fields['user_created']);
				}

				$saved = $members->admin_edit_update_profile($fields, $user_id);

				if ($saved)
				{
					wp_redirect($this->url(array('user_id' => $user_id ? $user_id : $saved)));
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
		DM_Wordpress_Template::load('members_admin_edit', $this->template);
	}

	public function scripts()
	{
	}
}