<?php
add_theme_support('post-thumbnails');

register_nav_menus(array(
	'primary' => __('Menu principal', 'devicemed'),
	'footer-primary' => __('Bas de page - Première ligne', 'devicemed'),
	'footer-secondary' => __('Bas de page - Deuxième ligne', 'devicemed'),
	'home' => __('Page d\'accueil', 'devicemed'),
));

function devicemed_header_menu($id) {
	return wp_nav_menu(array(
		'menu' => $id,
		'link_before' => '<span>',
		'link_after' => '</span>'
	));
}
function devicemed_footer_menu($id) {
	return wp_nav_menu(array(
		'menu' => $id
	)); 
}
function devicemed_home_get_featured_posts($limit = 6, $offset = 0) {
	return get_posts(array(
		'posts_per_page' => $limit,
		'offset' => $offset,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => '_dm_featured',
				'value' => '1',
			)
		)
	));
}
function devicemed_home_get_news_posts($limit = 3, $offset = 0, $exclude = array()) {
	$posts = get_posts(array(
		'posts_per_page' => $limit,
		'offset' => $offset,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => '_dm_last_posts',
				'value' => '1',
			)
		),
		'exclude' => $exclude
	));
	return $posts;
};
function devicemed_home_get_last_posts_by_category($category_id, $limit = 3, $offset = 0) {
	$posts = get_posts(array(
		'posts_per_page' => $limit,
		'offset' => $offset,
		'category' => $category_id,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_status' => 'publish'
	));
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
function devicemed_get_post_excerpt() {
	$excerpt = get_the_excerpt();
	return $excerpt;
}
function devicemed_single_get_related_posts($post_id = NULL) {
	return yarpp_get_related();
}
function devicemed_single_get_related_category_posts($post_id = NULL, $limit = 5) {
	$posts = get_posts(array(
		'posts_per_page' => $limit,
		'category__in' => wp_get_post_categories($post->ID),
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_status' => 'publish',
		'exclude' => array($post_id)
	));
	return $posts;
}

function wp_trim_all_excerpt($text) { // Creates an excerpt if needed; and shortens the manual excerpt as well
	global $post;
	
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
	}
	
	$text = strip_shortcodes( $text ); // optional
	$text = strip_tags($text);
	$excerpt_length = apply_filters('excerpt_length', 35);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$words = explode(' ', $text, $excerpt_length + 1);
	
	if (count($words)> $excerpt_length) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	} else {
		$text = implode(' ', $words);
	}
	return $text;
}

// Ici on active les menu déroulant Font Select et Font Size Select
if ( ! function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Font Select
		array_unshift( $buttons, 'fontsizeselect' ); //Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

// Personnalisez mce tailles de police de l'éditeur
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wp_trim_all_excerpt');