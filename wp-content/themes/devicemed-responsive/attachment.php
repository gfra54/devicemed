<?php if($post->post_parent) {
	wp_redirect(get_permalink($post->post_parent)); 
} else {
	wp_redirect('/?s='.urlencode(get_the_title($post->ID)));
}?>