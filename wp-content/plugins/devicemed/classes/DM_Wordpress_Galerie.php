<?php
class DM_Wordpress_Galerie
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
		DM_Wordpress_Router::add('/galeries', array(__CLASS__, 'liste'));
	}
	
	static public function liste($params)
	{
		DM_Wordpress::title(array('Galerie'));
		DM_Wordpress_Template::theme('galeries/liste', array());
	}
}