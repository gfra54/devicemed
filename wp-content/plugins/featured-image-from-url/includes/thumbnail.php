<?php

function get_post_thumbnail_url($post_id) {
	if($image_url = get_post_meta($post_id, 'fifu_image_url', true)) {
		return $image_url;
	} else return sinon(wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full'),0);
}


/*
add_filter('wp_head', 'fifu_image_social_tags');

function fifu_image_social_tags() {
	$post_id = get_the_ID();

	$image_url = get_post_meta($post_id, 'fifu_image_url', true);

	if ($image_url)
		include 'html/social.html';
}

add_action('the_post', 'fifu_choose');

function fifu_choose($post) {
	$post_id = $post->ID;

	$image_url = get_post_meta($post_id, 'fifu_image_url', true);

	$featured_image = get_post_meta($post_id, '_thumbnail_id', true);

	if ($image_url) {
		if (!$featured_image)
			update_post_meta($post_id, '_thumbnail_id', -1);
	}
	else {
		if ($featured_image == -1)
			delete_post_meta($post_id, '_thumbnail_id');
	}
}

add_filter('post_thumbnail_html', 'fifu_replace', 10, 2);

function fifu_replace($html, $post_id) {
	$image_url = get_post_meta($post_id, 'fifu_image_url', true);

	if ($image_url) {
		$html = fifu_get_html($post_id, $image_url);
		if (get_option('fifu_backlink') == 'toggleon')
			include 'html/backlink.html';
	}

	return $html;
}

function fifu_get_html($id, $image_url) {
	$alt = get_post_meta($id, 'fifu_image_alt', true);
	include 'html/thumbnail.html';
}

*/