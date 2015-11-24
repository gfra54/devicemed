<?php
class DM_Wordpress_Archive
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
		DM_Wordpress_Router::add('/archives', array(__CLASS__, 'liste'));
		DM_Wordpress_Router::add('/salons', array(__CLASS__, 'liste_salons'));
		DM_Wordpress_Router::add('/galeries', array(__CLASS__, 'liste_galeries'));
	}
	
	static public function liste($params)
	{	
		$archiveModel = new DM_Wordpress_Archive_Model();
		$archives = array();
		foreach ($archiveModel->get_archives() as $archive)
		{
			$archives[ $archive['ID'] ] = $archive;
		}

		DM_Wordpress::title(array('Tous nos numéros'));
		DM_Wordpress_Template::theme('archives/liste', array(
			'archives' => $archives
		));
		
		// $data = array('test');
		// $errors = array();
		
		// DM_Wordpress::title(array('archives', 'Tous nos numéros'));
		// DM_Wordpress_Template::theme('archives/liste', array(
			// 'data' => $data,
			// 'errors' => $errors,
			// 'archive' => $archive
		// ));
	}
	
	static public function liste_galeries($params)
	{	
		DM_Wordpress::title(array('Galerie'));
		DM_Wordpress_Template::theme('galeries/liste', array());
	}
	
	static public function liste_salons($params)
	{	
		DM_Wordpress::title(array('Salons et manifestations'));
		DM_Wordpress_Template::theme('salons/liste', array());
	}
}