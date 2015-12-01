<?php

/* vérification de la configuration wordpress (en cas de migration) */
function check_current_config(){
  $siteurl = addslashes($_GET['siteurl'] ? $_GET['siteurl'] :  get_option('siteurl')) ;
  if((isset($_GET['config']) && $_GET['config'] == 'force' )/* || SOCIETY_SITEURL != $siteurl*/){

    /* mise à jour de l'url du site dans les options */
    update_option('home',SOCIETY_HOME);
    update_option('siteurl',SOCIETY_SITEURL);

    /* génération du htaccess mis à jour avec le bon rewritebase*/
//    $htaccess = file_get_contents(dirname(__FILE__).'/../../config/htaccess.template');
//    $htaccess = str_replace('{SOCIETY_BASE}', SOCIETY_BASE, $htaccess);
 //   file_put_contents(ABSPATH.'.htaccess', $htaccess);

    /* mise à jour de l'url du site dans les posts */
    $GLOBALS['wpdb']->get_results('UPDATE '.$GLOBALS['wpdb']->prefix.'posts SET post_content = REPLACE(post_content,"'.$siteurl.'","'.SOCIETY_SITEURL.'")');

    $GLOBALS['wpdb']->get_results('UPDATE '.$GLOBALS['wpdb']->prefix.'posts SET guid = REPLACE(guid,"'.$siteurl.'","'.SOCIETY_SITEURL.'")');

    wp_redirect(add_query_arg(array('config'=>'updated'),$_SERVER['REQUEST_URI']));
    exit;
  }
}
add_action( 'init', 'check_current_config' );
