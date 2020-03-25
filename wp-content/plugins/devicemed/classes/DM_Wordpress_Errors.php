<?php
class DM_Wordpress_Errors
{
	/**
	 * Initialize section
	 * @return void
	 */
	static public function initialize()
	{
		// Register Wordpress Routes
		DM_Wordpress_Router::add('/404', array(__CLASS__, 'error_404'));
		DM_Wordpress_Router::add('/403', array(__CLASS__, 'error_403'));
		DM_Wordpress_Router::add('/500', array(__CLASS__, 'error_500'));
	}
	static public function error_404()
	{
		return self::error(404);
	}
	static public function error_403()
	{
		return self::error(403);
	}
	static public function error_500()
	{
		return self::error(500);
	}
	static public function error($status)
	{
		status_header($status);
		DM_Wordpress::title(sprintf('Erreur %d', $status));
		DM_Wordpress_Template::theme(sprintf('errors/%d', $status));
	}
}