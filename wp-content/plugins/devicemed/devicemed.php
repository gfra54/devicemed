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

/* inclure les fonctions utilitaires */
require_once(dirname(__FILE__).'/php/utils.inc.php');

/* inclure les fonctions de debug */
require_once(dirname(__FILE__).'/php/debug.inc.php');

/* inclure les fonctions des pubs */
require_once(dirname(__FILE__).'/php/pubs.inc.php');

//mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die ("<font color=red>Erreur ÃÂ  la connexion</font>");
//mysql_select_db (DB_NAME) or die("<font color=red>Erreur ÃÂ  la sÃÂ©lection de la base</font>");

$GLOBALS['mysqli'] = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);

setlocale (LC_TIME, 'fr_FR.UTF-8','fr_FR.UTF8','fra'); 



define( 'DEVICEMED_PLUGIN_DIR', dirname(__FILE__) );
list($pre,$tmp) = explode('wp-content',str_replace('\\','/',DEVICEMED_PLUGIN_DIR));
define( 'DEVICEMED_PLUGIN_URL', site_url().'/wp-content'.$tmp );
define( 'DEVICEMED_THEME_URL', site_url().'/wp-content/themes/devicemed-responsive/' );
define( 'DEVICEMED_THEME_PATH', $pre.'wp-content/themes/devicemed-responsive/' );


function add_admin_js(){
    wp_enqueue_script( 'admin-actions', DEVICEMED_PLUGIN_URL . '/js/admin-actions.js?2' );
}
add_action( 'admin_enqueue_scripts', 'add_admin_js' );

function devicemed_add_editor_styles() {
    add_editor_style( DEVICEMED_PLUGIN_URL.'/css/editor-style.css?'.filemtime(DEVICEMED_PLUGIN_DIR.'/css/editor-style.css'));
}
add_action( 'admin_init', 'devicemed_add_editor_styles' );


foreach(glob(dirname(__FILE__).'/php/*/*.php') as $file){
  if(file_exists($file)){
    require_once $file;
  }
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
	// DM_Wordpress_Newsletter_Admin::instance(); //desactivation de l'ancien systeme de newsletter
	// DM_Wordpress_Newsletter_Admin_List::instance();
	// DM_Wordpress_Newsletter_Admin_Edit::instance();
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
	// DM_Wordpress_Newsletter_Extraire_Admin::instance();
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