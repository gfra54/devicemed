<?php
/*add_action( 'init', 'wordpress_routes' );
function wordpress_routes(){
    add_rewrite_rule(
        'videos$',
        'index.php?pagename=videos',
        'top' );
}

/*

add_action( 'init', 'wpse26388_rewrites_init' );
function wpse26388_rewrites_init(){
    add_rewrite_rule(
        'properties/([0-9]+)/?$',
        'index.php?pagename=properties&property_id=$matches[1]',
        'top' );
}

add_filter( 'query_vars', 'wpse26388_query_vars' );
function wpse26388_query_vars( $query_vars ){
    $query_vars[] = 'property_id';
    return $query_vars;
}

*/