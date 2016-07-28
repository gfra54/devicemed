<?php 

function save_post_action($post_id) {
    global $post; 
    if ($post->post_type == 'pubs'){
    	store_pubs();
    	store_pub($post);
	} else if ($post->post_type == 'fournisseur'){
		fournisseur_enrichir($post,true);
	}

}
add_action( 'save_post', 'save_post_action' );

/*function save_post_cache($post_id) {
	if(is_admin()) {
		cachepage_clear('index');
		cachepage_clear($post_id);
		//get_current_screen()->post_type		
	}

}
add_action( 'save_post', 'save_post_cache' );
// add_action( 'admin_menu', 'save_post_cache' );

/*$GLOBALS['pagecache_on']=false;
function watch_pagecache() {
	global $wp_query;
	if(!$GLOBALS['pagecache_on']) {
		$GLOBALS['pagecache_on']=true;
		if($wp_query->is_home()) {
			get_pagecache('index');
		} else {
			if(is_numeric($pid = $wp_query->query['p'])) {
				get_pagecache($pid);
			}
		}
	}
}
//add_action( 'pre_get_posts', 'watch_pagecache' );

/*function add_action_pagecache() {
	pagecache();
}
add_action('shutdown','add_action_pagecache');*/

/*foreach($_COOKIE as $name=>$val) {
	if(substr($name, 0, 20) == 'wordpress_logged_in_') {
		setcookie('wpadmin', true, time()+(3600 * 24 * 30),'/');
	}
}
*/