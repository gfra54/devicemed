<?php

add_action('admin_menu', 'fifu_insert_menu');

function fifu_insert_menu() {
	add_menu_page(
			'Featured Image From URL', 
			'Featured Image From URL', 
			'administrator', 
			'featured-image-from-url', 
			'fifu_get_menu_html', 
			plugins_url() . '/featured-image-from-url/admin/images/favicon.png'
	);

	add_action('admin_init', 'fifu_get_menu_settings');
}

function fifu_get_menu_html() {
	$image_button = plugins_url() . '/featured-image-from-url/admin/images/onoff.jpg';

	$enable = get_option('fifu_backlink');

	include 'html/menu.html';

	if ((int) $_POST['fifu_input_backlink'])
		update_option('fifu_backlink', 'toggleon');
	else
		update_option('fifu_backlink', 'toggleoff');
}

function fifu_get_menu_settings() {
	register_setting('settings-group', 'fifu_backlink');

	if (!get_option('fifu_backlink'))
		update_option('fifu_backlink', 'toggleoff');
}

