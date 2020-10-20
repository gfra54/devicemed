<?php
class DM_Wordpress_Magazine
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
		DM_Wordpress_Router::add('/magazine/abonnement', array(__CLASS__, 'abonnement'));
		// DM_Wordpress_Router::add('/newsletter/informations/@code_temporaire', array(__CLASS__, 'informations'));
		// DM_Wordpress_Router::add('/newsletter/desinscrire/@mail', array(__CLASS__, 'desinscrire'));
		// DM_Wordpress_Router::add('/newsletter/previsualiser/@gabarit_id/@dynamique', array(__CLASS__, 'previsualiser'));
	}
	
	static public function abonnement($params)
	{	
		$magazine = new DM_Wordpress_Magazine_Model();
		$data = array();
		$errors = array();
		$success = array();
		
		if (!empty($_POST))
		{
			$data['nom'] = $_POST['nom'];
			$data['prenom'] = $_POST['prenom'];
			$data['email'] = $_POST['email'];
			$data['societe'] = $_POST['societe'];
			$data['adresse'] = $_POST['adresse'];
			$data['code_postal'] = $_POST['code_postal'];
			$data['ville'] = $_POST['ville'];
			
			if (!$data['nom'])
			{
				$errors['nom'] = 'Veuillez indiquer votre nom.';
			}
			if (!$data['prenom'])
			{
				$errors['prenom'] = 'Veuillez indiquer votre prénom.';
			}
			if(!$data['email']) {
				$errors['email'] = 'Veuillez indiquer une adresse mail.';
			}elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = 'Veuillez indiquer une adresse mail valide.';
			}
			if (!$data['societe'])
			{
				$errors['societe'] = 'Veuillez indiquer votre société.';
			}
			if (!$data['adresse'])
			{
				$errors['adresse'] = 'Veuillez indiquer votre adresse.';
			}
			if (!$data['code_postal'])
			{
				$errors['code_postal'] = 'Veuillez indiquer votre code postal.';
			}
			if (!$data['ville'])
			{
				$errors['ville'] = 'Veuillez indiquer votre ville.';
			}
			
			if(!$errors) {
				if($magazine->save($data)) {
					$success['general'] = 'Votre demande a été prise en compte. Vous recevrez le dernier numéro gratuitement dès que possible.';
				// }else {
				// 	$errors['general'] = 'Votre email est déjà abonné au magazine.';
				}
			}
		}
		
		me([
			'data' => $data,
			'errors' => $errors,
			'success' => $success
		]);
		DM_Wordpress::title(array('magazine', 'Abonnement au magazine'));
		DM_Wordpress_Template::theme('magazine/abonnement', array(
			'data' => $data,
			'errors' => $errors,
			'success' => $success
		));
	}
}