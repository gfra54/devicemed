<?php
/* faire en sorte que ce plugins soit toujours chargé en dernier */
add_action( 'activated_plugin', 'make_custom_functions_last' );

function make_custom_functions_last(){
  $plugins = get_option( 'active_plugins' );
  $last = end($plugins);
  $path = str_replace( normalize_path(WP_PLUGIN_DIR) . '/', '', normalize_path(__FILE__ ));
  if($last != $path){
      if ( $key = array_search( $path, $plugins ) ) {
        array_splice( $plugins, $key, 1 );
        $plugins[]=$path;
        update_option( 'active_plugins', $plugins );
      }
  }
}

make_custom_functions_last();
