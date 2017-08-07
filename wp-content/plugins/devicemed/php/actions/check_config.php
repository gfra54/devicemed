<?php

/* vérification de la configuration wordpress (en cas de migration) */
function check_current_config(){
  $path = realpath('.');
  if(strstr($path, ':\\')!==false && get_option('siteurl') == 'http://www.devicemed.fr') {
    $config = 'force';
    $siteurl = 'http://www.devicemed.local';
    $old = 'http://www.devicemed.fr';
  } else {
    $config = isset($_GET['config']) ? $_GET['config'] : false;
    $siteurl = addslashes($_GET['siteurl'] ? $_GET['siteurl'] :  get_option('siteurl')) ;
    $old = addslashes($_GET['old'] ? $_GET['old'] :  get_option('siteurl')) ;
  }

  
  if($config == 'force' ){

    /* mise à jour de l'url du site dans les options */
    update_option('home',$siteurl);
    update_option('siteurl',$siteurl);


    /* mise à jour de l'url du site dans les posts */
    $GLOBALS['wpdb']->get_results('UPDATE '.$GLOBALS['wpdb']->prefix.'posts SET post_content = REPLACE(post_content,"'.$old.'","'.$siteurl.'")');

    $GLOBALS['wpdb']->get_results('UPDATE '.$GLOBALS['wpdb']->prefix.'posts SET guid = REPLACE(guid,"'.$old.'","'.$siteurl.'")');

    me('update terminated : '.$old.' -> '.$siteurl);
  }
}
add_action( 'init', 'check_current_config' );
