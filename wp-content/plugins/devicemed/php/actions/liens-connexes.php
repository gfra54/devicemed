<?php

add_filter( 'the_content', 'filtrer_liens_connexes' );
 
function filtrer_liens_connexes( $content ) {
 
    // Check if we're inside the main loop in a single post page.
    if ( is_single() && in_the_loop() && is_main_query() ) {
    	$content = str_replace('#lien-connexe"', '" class="lien-connexe"', $content);
    }
 
    return $content;
}