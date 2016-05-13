<?php 
function save_post_cache($post_id) {
	if(is_admin()) {
		cachepage_clear('index.html');
		//get_current_screen()->post_type		
	}

}
add_action( 'save_post', 'save_post_cache' );
// add_action( 'admin_menu', 'save_post_cache' );

