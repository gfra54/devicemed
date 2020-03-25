<?php
function search_filter($query) {
	if (!is_admin() && $query->is_search && $_GET['post_type']) {
		$query->set('post_type', explode(',',$_GET['post_type']));
	}
	return $query;
}

add_filter('pre_get_posts','search_filter');





/*
add_filter('posts_orderby','changer_ordre_recherche',10,2);
function changer_ordre_recherche( $orderby, $query ){
    global $wpdb;

    if($query->is_search){
        $orderby =  $wpdb->prefix."posts.post_type ASC, {$wpdb->prefix}posts.post_date DESC";
	}

    return  $orderby;
}



add_action( 'pre_get_posts', 'include_tags_in_search' );
function include_tags_in_search($query){
    if($query->is_search){
        $terms = explode(' ', $query->get('s'));
        $query->set('tax_query', array(
            'relation'=>'OR',
            array(
                'taxonomy'=>'post_tag',
                'field'=>'slug',
                'terms'=>$terms
            )
        ));
    }
}*/




