<?php
function search_filter($query) {
	if ($query->is_search) {
		// $query->set('post_type', array('post','fournisseur'));
		$query->set('post_type', array('post'));
	}
	return $query;
}

add_filter('pre_get_posts','search_filter');