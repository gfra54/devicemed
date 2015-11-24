<?php
class DM_Wordpress_Members
{
	static private $session_referer = 'wordpress_dm_referer';
	static private $session_key = 'wordpress_dm_userdata';
	static private $session_expiration_key = 'wordpress_dm_expiration_time';
	static private $session_expiration_delay = 900;

	/**
	 * Initialize section
	 * @return void
	 */
	static public function initialize()
	{
		require_once implode(DIRECTORY_SEPARATOR, array(dirname(dirname(__FILE__)), 'vendors', 'phpmailer', 'PHPMailerAutoload.php'));

		// ----------------------------------------------------------
		// Register Wordpress Routes

		DM_Wordpress_Router::add('/members/confirm/@key', array(__CLASS__, 'confirm'));
		DM_Wordpress_Router::add('/members/register', array(__CLASS__, 'register'));
		DM_Wordpress_Router::add('/members/profile', array(__CLASS__, 'profile'));
		DM_Wordpress_Router::add('/members/login', array(__CLASS__, 'login'));
		DM_Wordpress_Router::add('/members/inscription', array(__CLASS__, 'inscription'));
		DM_Wordpress_Router::add('/members/logout', array(__CLASS__, 'logout'));
		DM_Wordpress_Router::add('/members/lost_password/@key', array(__CLASS__, 'lost_password'));
		DM_Wordpress_Router::add('/members/get_password', array(__CLASS__, 'lost_password2'));

		// ----------------------------------------------------------
		// Check Member Session

		if ($delay = (int) DM_Wordpress_Config::get('Security.Session.Expiration'))
		{
			self::$session_expiration_delay = $delay;
		}

		if ($session = DM_Wordpress_Session::get(self::$session_key)) // We do have a member session
		{
			if (DM_Wordpress_Session::get(self::$session_expiration_key) < time()) // Has session expired?
			{
				DM_Wordpress_Session::clear(self::$session_key); // Clearing session
			}
			else // Session expiration time is OK
			{
				$results = array();
				
				if (!empty($session['user_group']))
				{
					if ($session['user_group'] == 'users')
					{
						$members = new DM_Wordpress_Members_Model();
						$results = $members->session_check($session['ID']);
					}
					if ($session['user_group'] == 'suppliers')
					{
						$suppliers = new DM_Wordpress_Suppliers_Users_Model();
						$results = $suppliers->session_check($session['ID']);
					}
				}
				if ($results AND $results['user_status'])
				{
					DM_Wordpress_Session::set(self::$session_key, $results); // Refreshing session data
					DM_Wordpress_Session::set(self::$session_expiration_key, time() + self::$session_expiration_delay); // Increment session expiration time
				}
				else
				{
					DM_Wordpress_Session::clear(self::$session_key); // Member not found, clearing session
				}
			}
		}
	}

	/**
	 * Member login rendering
	 * @return void
	 */
	static public function login($params)
	{	
		$data = array(
			'user_login' => '',
			'user_password' => '',
			'create_email' => ''
		);
		$errors = array();
		$success = array();

		if (isset($_SERVER['REQUEST_URI'])
			AND isset($_SERVER['HTTP_REFERER'])
			AND (FALSE === strpos($_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI'])))
		{
			DM_Wordpress_Session::set(self::$session_referer, wp_get_referer());
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
			if (!empty($_POST['action']) AND $_POST['action'] == 'login')
			{
				if (!$data['user_login'])
				{
					$errors['user_login'] = 'Identifiant manquant.';
				}
				if (!$data['user_password'])
				{
					$errors['user_password'] = 'Mot de passe manquant.';
				}
				if (!$errors)
				{
					$members = new DM_Wordpress_Members_Model();
					$suppliers = new DM_Wordpress_Suppliers_Users_Model();

					if (($results = $members->authenticate($data['user_login'], md5(md5($data['user_password']).DM_Wordpress_Config::get('Security.Password.Salt'))))
						OR ($results = $suppliers->authenticate($data['user_login'], md5(md5($data['user_password']).DM_Wordpress_Config::get('Security.Password.Salt')))))
					{
						if ($results['user_status'] == 0)
						{
							$errors['user_login'] = 'Votre compte a été désactivé.';
						}
						else
						{
							DM_Wordpress_Session::set(self::$session_key, $results);
							if($data['rester_connecter']) {
								DM_Wordpress_Session::set(self::$session_expiration_key, time() + 9000);
							}else {
								DM_Wordpress_Session::set(self::$session_expiration_key, time() + self::$session_expiration_delay);
							}
						}
					}
					else
					{
						$errors['user_login'] = 'Identifiant ou mot de passe incorrect.';
					}
				}
				if (!$errors)
				{
					if ($referer = DM_Wordpress_Session::get(self::$session_referer))
					{
						wp_redirect("http://www.devicemed.fr/");
					}
					else
					{
						wp_redirect(get_home_url());
					}
				}
			}
			if (!empty($_POST['action']) AND $_POST['action'] == 'create')
			{
				$members = new DM_Wordpress_Members_Model();
				if (!$data['create_email'])
				{
					$errors['create_email'] = 'Veuillez entrer votre adresse email.';
				}
				else if ($members->check_duplicate_email($data['create_email']))
				{
					$errors['create_email'] = 'Cette adresse email est déja utilisée.';
				}
				
				if (!$errors)
				{
					$key = md5(mt_rand());
					$user_id = $members->create_account(array(
						'user_login' => $data['create_email'],
						'user_email' => $data['create_email'],
						'user_created' => date('Y-m-d H:i:s'),
						'user_modified' => date('Y-m-d H:i:s'),
						'user_status' => '1',
						'user_confirmation_key' => $key,
						'user_country' => 'France'
					));
					if ($user_id)
					{
						$to      = $data['create_email'];
						$subject = 'DeviceMed.fr - Création d\'un nouveau compte';
						$subject = mb_encode_mimeheader($subject, "UTF-8");
						$message = 'Bonjour ! Bienvenue sur DeviceMed.fr.<br /><a href="'.site_url('/members/confirm/'.$key).'">Veuillez cliquer sur ce lien afin de finaliser votre inscription</a>';
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
						$headers .= "From: \"DeviceMed France\"<info@devicemed.fr>";

						
						// $mail = DM_Wordpress_Mailer_PHPMailer::factory()
							// ->to($data['create_email'])
							// ->subject('DeviceMed.fr - Création d\'un nouveau compte')
							// ->html('Bonjour ! Bienvenue sur DeviceMed.fr.<br /><a href="'.site_url('/members/confirm/'.$key).'">Veuillez cliquer sur ce lien afin de finaliser votre inscription</a>')
							// ->text('Bonjour ! Bienvenue sur DeviceMed.fr. Veuillez cliquer sur ce lien afin de finaliser votre inscription : '.site_url('/members/confirm/'.$key));

						// echo "key : ". $key;
						
						if(filter_var($data['create_email'], FILTER_VALIDATE_EMAIL)) 
						{
							if (!mail($to, $subject, $message, $headers))
							{
								// echo "error info : ". $mail->ErrorInfo;
								$members->delete($user_id);
								$errors['create_email'] = 'Une erreur est survenue lors de l\'envoi du message de confirmation.';
							}
							else
							{
								$success['create_email'] = 'Un email va vous être envoyé pour que vous validiez la création de votre compte.';
								$data['create_email'] = '';
							}
						}else {
							// echo "error info : ". $mail->ErrorInfo;
							$members->delete($user_id);
							$errors['create_email'] = 'Veuillez renseigner une adresse valide.';
						}
					}
				}
			}
		}

		DM_Wordpress::title(array('Membres', 'Connexion'));
		DM_Wordpress_Template::theme('members/login', array(
			'data' => $data,
			'errors' => $errors,
			'success' => $success
		));
	}

	static public function confirm($params)
	{
		$key = !empty($params['key']) ? $params['key'] : '';
		if ($key)
		{
			$members = new DM_Wordpress_Members_Model();
			if ($result = $members->check_confirmation_key($key))
			{
				DM_Wordpress_Session::set(self::$session_key, array(
					'ID' => $result['ID'],
					'user_group' => 'users'
				));
				DM_Wordpress_Session::set(self::$session_expiration_key, time() + self::$session_expiration_delay);
				wp_redirect(site_url('/members/profile'));
			}
		}
		$errors = $data = array();
		DM_Wordpress::title(array('Membres', 'Confirmation de votre compte'));
		DM_Wordpress_Template::theme('members/confirm', array(
			'data' => $data,
			'errors' => $errors
		));
	}

	static public function lost_password($params)
	{
		$key = !empty($params['key']) ? $params['key'] : '';
		if ($key)
		{
			$members = new DM_Wordpress_Members_Model();
			if ($result = $members->check_lost_password_key($key))
			{
				DM_Wordpress_Session::set(self::$session_key, array(
					'ID' => $result['ID'],
					'user_group' => 'users'
				));
				DM_Wordpress_Session::set(self::$session_expiration_key, time() + self::$session_expiration_delay);
				wp_redirect(site_url('/members/profile'));
			}
		}
		$errors = $data = array();
		DM_Wordpress::title(array('Membres', 'Mot de passe oublié'));
		DM_Wordpress_Template::theme('members/lost_password2', array(
			'data' => $data,
			'errors' => $errors
		));
	}

	static public function lost_password2($params)
	{
		DM_Wordpress::title(array('Membres', 'Mot de passe oublié'));
		DM_Wordpress_Template::theme('members/lost_password', array());
	}

	static public function logout($params)
	{
		DM_Wordpress_Session::clear(self::$session_key);
		$referer = wp_get_referer();
		wp_redirect($referer ? $referer : get_home_url());
	}

	static public function profile($params)
	{
		$session = self::session();
		if (!$session)
		{
			wp_redirect(site_url('/members/login'));
		}
		if ($session['user_group'] == 'users')
		{
			$members = new DM_Wordpress_Members_Model();
			$user_id = (int) $session['ID'];
			$data = array(
				'user_id' => $user_id,
				'user_login' => '',
				'user_nicename' => '',
				'user_lastname' => '',
				'user_firstname' => '',
				'user_email' => '',
				'user_sex' => 'M',
				'user_address' => '',
				'user_city' => '',
				'user_postalcode' => '',
				'user_country' => '',
				'user_lostpassword_key'	=> '',
				'user_confirmation_key'	=> '',
				'user_created' => date('Y-m-d H:i:s'),
				'user_modified' => date('Y-m-d H:i:s'),
				'user_status' => '1',
				'user_new_password' => '',
				'user_new_password_confirm' => '',
				'user_password' => '',
				'user_password_confirm' => ''
			);
			$errors = array();
			
			$results = $members->admin_edit_get_profile($user_id);
			foreach ($data as $field => $value)
			{
				if (isset($results[ $field ]))
				{
					$data[ $field ] = $results[ $field ];
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
				if (!$data['user_lastname'])
				{
					$errors['user_lastname'] = 'Veuillez indiquer votre nom.';
				}
				if (!$data['user_firstname'])
				{
					$errors['user_firstname'] = 'Veuillez indiquer votre prénom.';
				}
				if (!$data['user_email'])
				{
					$errors['user_email'] = 'Veuillez indiquer votre adresse e-mail.';
				}
				else
				{
					$data['user_email'] = strtolower($data['user_email']);
					if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $data['user_email']))
					{
						$errors['user_email'] = 'Adresse e-mail invalide.';
					}
					/*
					else if ($members->check_duplicate_email($data['user_email']))
					{
						$errors['user_email'] = 'Adresse e-mail déja utilisée.';
					}
					*/
				}
				if ($data['user_new_password'] OR !$data['user_password'])
				{
					if (!$data['user_password'] AND !$data['user_new_password'])
					{
						$errors['user_new_password'] = 'Veuillez entrer votre mot de passe.';
					}
					if (!$data['user_new_password_confirm'])
					{
						$errors['user_new_password_confirm'] = 'Veuillez confirmer votre mot de passe.';
						$data['user_new_password'] = '';
					}
					elseif ($data['user_new_password'] != $data['user_new_password_confirm'])
					{
						$errors['user_new_password_confirm'] = 'Confirmation de votre mot de passe incorrect.';
						$data['user_new_password'] = $data['user_new_password_confirm'] = '';
					}
				}
				if (!$errors)
				{
					$fields = $data;

					if ($fields['user_new_password'])
					{
						$fields['user_password'] = $fields['user_new_password'];
					}
					$fields['user_password'] = md5(md5($fields['user_password']).DM_Wordpress_Config::get('Security.Password.Salt'));
					$fields['user_modified'] = date('Y-m-d H:i:s');
					$fields['user_firstname'] = $members->string_sanitize_nicename($fields['user_firstname']);
					$fields['user_lastname'] = $members->string_sanitize_nicename($fields['user_lastname']);
					$fields['user_city'] = $members->string_sanitize_nicename($fields['user_city']);
					$fields['user_country'] = $members->string_sanitize_nicename($fields['user_country']);
					$fields['user_nicename'] = $fields['user_firstname'].' '.$fields['user_lastname'];
					$fields['user_confirmation_key'] = '';
					$fields['user_lostpassword_key'] = '';
					
					$fields['user_login'] = $fields['user_email'];
					//unset($fields['user_login']);
					
					unset($fields['user_created']);
					unset($fields['id']);
					unset($fields['user_status']);

					$saved = $members->admin_edit_update_profile($fields, $user_id);

					if ($saved)
					{
						wp_redirect(site_url('/members/profile'));
					}
				}
			}

			DM_Wordpress::title(array('Membres', 'Profil'));
			DM_Wordpress_Template::theme('members/profile_user', array(
				'data' => $data,
				'errors' => $errors
			));
		}
		elseif ($session['user_group'] == 'suppliers')
		{
			$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
			$suppliers_model = new DM_Wordpress_Suppliers_Model();
			$supplier_user_id = (int) $session['ID'];

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

			$results = $suppliers_users->admin_edit_get_profile($supplier_user_id);
			foreach ($data as $field => $value)
			{
				if (isset($results[ $field ]))
				{
					$data[ $field ] = $results[ $field ];
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
				if (!$data['supplier_user_lastname'])
				{
					$errors['supplier_user_lastname'] = 'Veuillez indiquer votre nom.';
				}
				if (!$data['supplier_user_firstname'])
				{
					$errors['supplier_user_firstname'] = 'Veuillez indiquer votre prénom.';
				}
				if (!$data['supplier_user_email'])
				{
					$errors['supplier_user_email'] = 'Veuillez indiquer votre adresse e-mail.';
				}
				else
				{
					$data['supplier_user_email'] = strtolower($data['supplier_user_email']);
					if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $data['supplier_user_email']))
					{
						$errors['supplier_user_email'] = 'Adresse e-mail invalide.';
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
				if (!$errors)
				{
					$fields = $data;

					$fields['supplier_user_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_password'] = md5(md5($fields['supplier_user_new_password']).DM_Wordpress_Config::get('Security.Password.Salt'));
					$fields['supplier_user_firstname'] = $suppliers_users->string_sanitize_nicename($fields['supplier_user_firstname']);
					$fields['supplier_user_lastname'] = $suppliers_users->string_sanitize_nicename($fields['supplier_user_lastname']);
					$fields['supplier_user_city'] = $suppliers_users->string_sanitize_nicename($fields['supplier_user_city']);
					$fields['supplier_user_country'] = $suppliers_users->string_sanitize_nicename($fields['supplier_user_country']);
					$fields['supplier_user_nicename'] = $fields['supplier_user_firstname'].' '.$fields['supplier_user_lastname'];
					unset($fields['supplier_user_login']);
					unset($fields['supplier_user_created']);
					unset($fields['supplier_id']);
					unset($fields['supplier_user_status']);

					$saved = $suppliers_users->admin_edit_update_profile($fields, $supplier_user_id);

					if ($saved)
					{
						wp_redirect(site_url('/members/profile'));
					}
				}
			}

			DM_Wordpress::title(array('Fournisseurs', 'Profil'));
			DM_Wordpress_Template::theme('members/profile_supplier', array(
				'data' => $data,
				'errors' => $errors,
				'suppliers' => $suppliers
			));
		}
	}

	static public function session()
	{
		return DM_Wordpress_Session::get(self::$session_key);
	}
}