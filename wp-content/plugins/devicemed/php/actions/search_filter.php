<?php
function search_filter($query) {
	if ($query->is_search && $_GET['post_type']) {
		$query->set('post_type', explode(',',$_GET['post_type']));
	}
	return $query;
}

add_filter('pre_get_posts','search_filter');