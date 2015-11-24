<?php
register_nav_menus(array(
	'primary' => __('Menu principal', 'devicemed'),
	'secondary' => __('Menu secondaire', 'devicemed')
));

function devicemed_menu($id) {
	return wp_nav_menu(array(
		'menu' => $id,
		'link_before' => '<span>',
		'link_after' => '</span>'
	));
}
function devicemed_homepage_get_featured_posts() {
	return get_posts(array(
		'posts_per_page' => 6,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_status' => 'publish'
	));
}
function devicemed_homepage_get_news_posts() {
	$posts = get_posts(array(
		'posts_per_page' => 6,
		'offset' => 6,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_status' => 'publish'
	));
	for ($i=0, $c=count($posts); $i < $c; $i++) {
		$posts[ $i ]->last = ($i == $c - 1);
	}
	return $posts;
};
function devicemed_homepage_get_whitepapers_posts() {
	$posts = get_posts(array(
		'posts_per_page' => 3,
		'offset' => 12,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_status' => 'publish'
	));
	for ($i=0, $c=count($posts); $i < $c; $i++) {
		$posts[ $i ]->last = ($i == $c - 1);
	}
	return $posts;
};
function devicemed_get_post_featured_thumbnail($post_id) {
	if (has_post_thumbnail($post_id)) {
		$thumbnail = get_post(get_post_thumbnail_id($post_id));
		$thumbnail->url = wp_get_attachment_url($thumbnail->ID);
		return $thumbnail;
	}
	return false;
}