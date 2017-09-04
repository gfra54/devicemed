<?php

add_filter( 'the_content', 'filtrer_liens_connexes' );
 
function filtrer_liens_connexes( $content ) {
 
    // Check if we're inside the main loop in a single post page.
    if ( is_single() && in_the_loop() && is_main_query() ) {
    	$content = str_replace('#lien-connexe"', '" class="lien-connexe"', $content);
    }
 
    return $content;
}


// add new buttons
add_filter( 'mce_buttons', 'liens_connexes_register_buttons' );

function liens_connexes_register_buttons( $buttons ) {
	$buttons = array_values(array_insert_after(array_search('unlink', $buttons),$buttons,count($buttons),'liens_connexes'));
//   array_push( $buttons, 'separator', 'liens_connexes' );
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
add_filter( 'mce_external_plugins', 'liens_connexes_register_plugin' );

function liens_connexes_register_plugin( $plugin_array ) {
   $plugin_array['liens_connexes'] = plugins_url( '../../js/plugin_liens_connexes.js',__FILE__ );
   return $plugin_array;
}