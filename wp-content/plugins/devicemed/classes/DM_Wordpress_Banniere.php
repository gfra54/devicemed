<?php
class DM_Wordpress_Banniere
{
	static private $upload_directory;
	static private $upload_url;
	static private $medias_directory;
	static private $medias_url;

	static public function initialize()
	{
		// DM_Wordpress_Router::add('/suppliers/downloads/add', array(__CLASS__, 'edit'));
		// DM_Wordpress_Router::add('/suppliers/downloads/edit/@download_id', array(__CLASS__, 'edit'));
		// DM_Wordpress_Router::add('/suppliers/products/delete/@product_id', array(__CLASS__, 'delete'));
		// DM_Wordpress_Router::add('/suppliers/products/upload', array(__CLASS__, 'upload'));
		// DM_Wordpress_Router::add('/suppliers/download/@supplier_id', array(__CLASS__, 'display_download'));
		
		// $wp_upload_dir = wp_upload_dir();
		// self::$upload_directory = $wp_upload_dir['basedir'].'/suppliers/downloads/uploads/';
		// self::$upload_url = $wp_upload_dir['baseurl'].'/suppliers/downloads/uploads/';
		// self::$medias_directory = $wp_upload_dir['basedir'].'/suppliers/downloads/';
		// self::$medias_url = $wp_upload_dir['baseurl'].'/suppliers/downloads/';
	}
}