<?php

/* Function which remove Plugin Update Notices – Askimet*/
function disable_plugin_updates( $value ) {
   unset( $value->response['opengraph/opengraph.php'] );
   return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );