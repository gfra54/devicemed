<?php 

add_action('admin_head', 'bouton_guillemets_init');

function bouton_guillemets_init(){
 global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "bouton_guillemets_plugin");
        add_filter('mce_buttons', 'bouton_guillemets_register');
    }	
}


function bouton_guillemets_plugin($plugin_array) {
    $plugin_array['bouton_guillemets'] = plugins_url().'/devicemed/js/bouton_guillemets.js'; 
    return $plugin_array;
}


function bouton_guillemets_register($buttons) {
   array_push($buttons, "bouton_guillemets");
   return $buttons;
}