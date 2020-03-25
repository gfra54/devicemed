<?php

class DM_Wordpress_Members_Admin extends DM_Wordpress_Admin_Menu_Page
{
	protected $page_title = 'Membres';
	protected $menu_title = 'Membres';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-members';
}