<?php
/**
 * @package DeviceMed
 * @version 0.1
 */
/*
Plugin Name: DeviceMed WordPress Plugin
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: DeviceMed WordPress Plugin
Author: Romain Rytter
Version: 0.1
Author URI: http://www.keepcom.fr
*/
require_once dirname(__FILE__).'/classes/DM_Wordpress.php';


$files = glob(dirname(__FILE__).'/auto/*.php');
foreach($files as $file) {
	include $file;
}

DM_Wordpress::initialize();

DM_Wordpress_Config::set(array(
	'Security.Cookie.Salt' => '0cc0ea8ba7df02b613e5a7ca96646c8c',
	'Security.Password.Salt' => 'fe3a6eb83f5301d3fd98fc4f86cb48',
	'Security.Session.Expiration' => 60 * 15,
	'Mail.From' => 'no-reply@devicemed.fr',
	'Mail.FromName' => 'DeviceMed.fr',
	'Mail.Host' => 'localhost',
	'Mail.SmtpAuth' => true,
	'Mail.Username' => '',
	'Mail.Password' => '',
	'Mail.Port' => 587,
	'Mail.SMTPSecure' => 'tls'
));

if (is_admin())
{
	DM_Wordpress_Posts_Admin::initialize();
	DM_Wordpress_Members_Admin::instance();
	DM_Wordpress_Members_Admin_List::instance();
	DM_Wordpress_Members_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Admin::instance();
	DM_Wordpress_Suppliers_Admin_List::instance();
	DM_Wordpress_Suppliers_Admin_Edit::instance();
	DM_Wordpress_Archive_Admin::instance();
	DM_Wordpress_Archive_Admin_List::instance();
	DM_Wordpress_Archive_Admin_Edit::instance();
	DM_Wordpress_Banniere_Admin::instance();
	DM_Wordpress_Banniere_Admin_List::instance();
	DM_Wordpress_Banniere_Admin_Edit::instance();
	DM_Wordpress_Newsletter_Admin::instance(); //desactivation de l'ancien systeme de newsletter
	DM_Wordpress_Newsletter_Admin_List::instance();
	DM_Wordpress_Newsletter_Admin_Edit::instance();
//	DM_Wordpress_Gabarit_Admin::instance();
//	DM_Wordpress_Gabarit_Admin_List::instance();
//	DM_Wordpress_Gabarit_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Categories_Admin_List::instance();
	DM_Wordpress_Suppliers_Categories_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Posts_Admin_List::instance();
	DM_Wordpress_Suppliers_Posts_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Products_Admin_List::instance();
	DM_Wordpress_Suppliers_Products_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Gallerie_Admin_List::instance();
	DM_Wordpress_Suppliers_Gallerie_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Videos_Admin_List::instance();
	DM_Wordpress_Suppliers_Videos_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Event_Admin_List::instance();
	DM_Wordpress_Suppliers_Event_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Download_Admin_List::instance();
	DM_Wordpress_Suppliers_Download_Admin_Edit::instance();
	DM_Wordpress_Suppliers_Users_Admin_List::instance();
	DM_Wordpress_Suppliers_Users_Admin_Edit::instance();
	DM_Wordpress_Newsletter_Extraire_Admin::instance();
	DM_Wordpress_Suppliers_Extraire_Admin::instance();
}

DM_Wordpress_Errors::initialize();
DM_Wordpress_Members::initialize();
DM_Wordpress_Suppliers_Posts::initialize();
DM_Wordpress_Suppliers_Products::initialize();
DM_Wordpress_Suppliers_Galleries::initialize();
DM_Wordpress_Suppliers_Videos::initialize();
DM_Wordpress_Suppliers_Download::initialize();
DM_Wordpress_Suppliers_Event::initialize();
DM_Wordpress_Suppliers::initialize();
DM_Wordpress_Newsletter::initialize();
DM_Wordpress_Magazine::initialize();
DM_Wordpress_Archive::initialize();
DM_Wordpress_Banniere::initialize();
DM_Wordpress_Tag::initialize();