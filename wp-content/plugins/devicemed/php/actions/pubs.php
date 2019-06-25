<?php


add_action( 'save_post', 'save_post_pubs' );
function save_post_pubs($post_id) {
	if(strstr($_SERVER['REQUEST_URI'],'post-new.php')!==false) {
		return;
	}
	global $post; 

	if ($post->post_type == 'pubs'){
		$thumbnail = str_replace('http://','https://',get_post_thumbnail_url($post_id));

		
		$display = bitly_shorten($thumbnail);

		update_field('url_tracking_display', $display, $post_id);


		$url_cible = get_field('url_cible',$post_id);
		update_field('url_cible',http($url_cible),$post_id);

		$clicks = bitly_shorten($url_cible);
		update_field('url_tracking_clicks', $clicks, $post_id);



		store_pubs(true);

		store_pub($post);


	}
}
