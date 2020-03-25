<?php

class DM_Wordpress_Suppliers_Extraire_Admin extends DM_Wordpress_Admin_Submenu_Page
{
	protected $parent_slug = 'devicemed-suppliers';
	protected $page_title = 'Extraire la bdd';
	protected $menu_title = 'Extraire la bdd';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-extraire-bdd-suppliers';

	public function load()
	{
		$suppliers = new DM_Wordpress_Suppliers_Model();
		$suppliers->extractBdd();
	}
}
?>