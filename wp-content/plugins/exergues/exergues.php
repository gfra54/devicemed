<?php
/**
 * @package Exergues
 * @author Gilles FRANCOIS
 * @version 1.0
 */
/*
Plugin Name: Exergues
Plugin URI: http://www.betterinternets.com
Description: Adding exergues in the editor
Author: Gilles FRANCOIS
Version: 1.0
Author URI: http://www.betterinternets.com
*/

/*  Copyright 2014 GF
*/

define( 'WP_EXERGUES_PLUGIN_DIR', dirname(__FILE__) );
list(,$tmp) = explode('wp-content',str_replace('\\','/',WP_EXERGUES_PLUGIN_DIR));
define( 'WP_EXERGUES_PLUGIN_URL', site_url().'/wp-content'.$tmp );

function exergue_add_editor_styles() {
    add_editor_style( WP_EXERGUES_PLUGIN_URL.'/css/editor-style.css');
}
add_action( 'admin_init', 'exergue_add_editor_styles' );

function exergue_add_admin_js(){
    wp_enqueue_script( 'exergues-admin-actions', WP_EXERGUES_PLUGIN_URL . '/js/admin-actions.js' );
}
add_action( 'admin_enqueue_scripts', 'exergue_add_admin_js' );

require_once (WP_EXERGUES_PLUGIN_DIR . '/exergues-tinymce.php');
