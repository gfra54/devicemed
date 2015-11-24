<?php
class DM_Wordpress_Newsletter
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
		DM_Wordpress_Router::add('/newsletter/inscription', array(__CLASS__, 'inscription'));
		DM_Wordpress_Router::add('/newsletter/informations/@code_temporaire', array(__CLASS__, 'informations'));
		DM_Wordpress_Router::add('/newsletter/desinscrire/@mail', array(__CLASS__, 'desinscrire'));
		DM_Wordpress_Router::add('/newsletter/previsualiser/@gabarit_id/@dynamique', array(__CLASS__, 'previsualiser'));
	}
	
	static public function inscription($params)
	{	
		$newsletter = new DM_Wordpress_Newsletter_Model();
		$data = array();
		$errors = array();
		$success = array();
		
		if (!empty($_POST))
		{
			$data['mail_newsletter'] = $_POST['mail_newsletter'];
			$data['offre_devicemed'] = $_POST['offre_devicemed'];
			$data['offre_partenaires'] = $_POST['offre_partenaires'];
			
			if(!$data['mail_newsletter']) {
				$errors['mail_newsletter'] = 'Veuillez indiquer une adresse mail.';
			}elseif(!filter_var($data['mail_newsletter'], FILTER_VALIDATE_EMAIL)) {
				$errors['mail_newsletter'] = 'Veuillez indiquer une adresse mail valide.';
			}
			if (!$data['offre_devicemed'])
			{
				$errors['offre_devicemed'] = 'Voulez-vous recevoir la newsletter devicemed ?';
			}
			if (!$data['offre_partenaires'])
			{
				$errors['offre_partenaires'] = 'Voulez-vous recevoir les offres de nos partenaires ?';
			}
			
			if(!$errors) {
				$arrayMail = $newsletter->verifmail($data['mail_newsletter']);
				if(count($arrayMail) == 0) {
					if($newsletter->save($data)) {
						$success['general'] = 'Votre demande a été prise en compte. Un email vous sera envoyé dans un instant pour que vous validiez votre abonnement.';
					}else {
						$errors['general'] = 'Une erreur est survenue lors de l\'inscription à la newsletter. Veuillez contacter un administrateur.';
					}
				}else {
					$errors['general'] = 'Vous êtes déjà inscrit à la newsletter.';
				}
			}
		}
		
		DM_Wordpress::title(array('newsletter', 'Inscription à la newsletter'));
		DM_Wordpress_Template::theme('newsletter/inscription', array(
			'data' => $data,
			'errors' => $errors,
			'success' => $success
		));
	}
	
	static public function desinscrire($params)
	{	
		$newsletter = new DM_Wordpress_Newsletter_Model();
		$data = array();
		$errors = array();
		$success = array();
		
		if (!empty($_POST))
		{
			$data['confirmation_desinscrire'] = $_POST['confirmation_desinscrire'];
			
			if(!$data['confirmation_desinscrire']) {
				$errors['confirmation_desinscrire'] = 'Veuillez confirmer votre désinscription.';
			}
			
			if(!$errors) {
				$data['mail'] = $params['mail'];
				
				$mailExist = $newsletter->mailDesinscriptionExiste($params['mail']);//exit();

				if($mailExist > 0) {
					if($newsletter->desinscrire($data)) {
						$success['general'] = 'Votre désabonnement à la newsletter a été pris en compte. <br />Merci de contacter info@devicemed.fr si, malgré cela, vous recevez la prochaine édition.';
						// header("refresh:5;url=http://www.devicemed.fr/");
					}else {
						$errors['general'] = 'Une erreur est survenue lors de la désinscription à la newsletter. Veuillez contacter un administrateur.';
					}
				}else {
					$errors['general'] = 'Le mail n\'existe pas, ou votre désinscription à la newsletter a déjà été pris en compte.';
				}
			}
		}
		
		DM_Wordpress::title(array('newsletter', 'Se désabonner de la newsletter'));
		DM_Wordpress_Template::theme('newsletter/desinscription', array(
			'data' => $data,
			'errors' => $errors,
			'success' => $success
		));
	}
	
	static public function informations($params) {	
		$newsletter = new DM_Wordpress_Newsletter_Model();
		$data = array();
		$errors = array();
		$success = array();
		$code_temporaire = $params['code_temporaire'];
		
		$arrayCodeTemporaire = $newsletter->verifCodeTemporaire($code_temporaire);

		if(count($arrayCodeTemporaire) == 0 || $code_temporaire = '') {
			wp_redirect(home_url().'/newsletter/inscription'); exit;
		}else {
			if (!empty($_POST))
			{
				$data['nom_newsletter'] = $_POST['nom_newsletter'];
				$data['prenom_newsletter'] = $_POST['prenom_newsletter'];
				$data['ville_newsletter'] = $_POST['ville_newsletter'];
				$data['cp_newsletter'] = $_POST['cp_newsletter'];
				
				if(!$data['nom_newsletter']) {
					$errors['nom_newsletter'] = 'Veuillez indiquer votre nom.';
				}
				if (!$data['prenom_newsletter'])
				{
					$errors['prenom_newsletter'] = 'Veuillez indiquer votre prénom.';
				}
				if (!$data['ville_newsletter'])
				{
					$errors['ville_newsletter'] = 'Veuillez indiquer votre ville.';
				}
				if (!$data['cp_newsletter'])
				{
					$errors['cp_newsletter'] = 'Veuillez indiquer votre code postal.';
				}
				
				if(!$errors) {
					if($newsletter->update($data, $params['code_temporaire'])) {
						$success['general'] = 'Votre abonnement à la newsletter a bien été finalisé. Merci et à bientôt dans votre boite email.';
					}else {
						$errors['general'] = 'Une erreur est survenue lors de la finalisation d\'inscription à la newsletter. Veuillez contacter un administrateur.';
					}
				}
			}
		}
		
		DM_Wordpress::title(array('newsletter', 'Etape 2'));
		DM_Wordpress_Template::theme('newsletter/informations', array(
			'data' => $data,
			'errors' => $errors,
			'success' => $success
		));
	}
	static public function previsualiser($params) {	
		$gabarit = new DM_Wordpress_Gabarit_Model();
		$data = array();
		$errors = array();
		$success = array();
		$dynamique = $params['dynamique'];
		
		$results = $gabarit->get_gabarit($params['gabarit_id']);

		DM_Wordpress::title(array('newsletter', 'Prévisualisation'));
		DM_Wordpress_Template::theme('newsletter/previsualiser', array(
			'data' => $data,
			'errors' => $errors,
			'success' => $success,
			'result' => $results[0],
			'dynamique' => $dynamique
		));
	}
}