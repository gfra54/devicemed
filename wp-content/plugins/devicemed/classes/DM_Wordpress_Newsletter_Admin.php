<?php

class DM_Wordpress_Newsletter_Admin extends DM_Wordpress_Admin_Menu_Page
{
	protected $page_title = 'Newsletter';
	protected $menu_title = 'Newsletter';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-newsletter';
}