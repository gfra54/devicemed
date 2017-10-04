<?php

add_action('add_meta_boxes', 'fifu_insert_meta_box');

function fifu_insert_meta_box() {
	$post_types = array('pubs');

	foreach ($post_types as $post_type) {
		add_meta_box(
				'Url Meta Box', 
				'Image à la une par URL', 
				'fifu_show_elements', 
				$post_type, 
				'side', 
				'default'
		);
	}
}

function fifu_show_elements($post) {
	$url = get_post_meta($post->ID, 'fifu_image_url', true);
	$alt = get_post_meta($post->ID, 'fifu_image_alt', true);

	if ($url)
		$show_url = $show_button = 'display:none;';
	else
		$show_alt = $show_image = $show_link = 'display:none;';

	$margin = 'margin-top:10px;';
	$width = 'width:100%;';
	$height = 'height:266px;';
	$align = 'text-align:left;';

	include 'html/meta-box.html';
}

add_action('save_post', 'fifu_save_image_properties');

function fifu_save_image_properties($post_id) {
	if (isset($_POST['fifu_input_url']))
		update_post_meta($post_id, 'fifu_image_url', esc_url($_POST['fifu_input_url']));

	if (isset($_POST['fifu_input_alt']))
		update_post_meta($post_id, 'fifu_image_alt', wp_strip_all_tags($_POST['fifu_input_alt']));
}

