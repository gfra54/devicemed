<?php

function disable_plugin_updates( $value ) {
   unset( $value->response['attachments/index.php'] );
   unset( $value->response['opengraph/opengraph.php'] );
   unset( $value->response['featured-image-from-url/featured-image-from-url.php'] );
   return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );