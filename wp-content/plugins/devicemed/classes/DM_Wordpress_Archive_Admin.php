<?php

class DM_Wordpress_Archive_Admin extends DM_Wordpress_Admin_Menu_Page
{
	protected $page_title = 'Archives';
	protected $menu_title = 'Archives';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-archives';
}