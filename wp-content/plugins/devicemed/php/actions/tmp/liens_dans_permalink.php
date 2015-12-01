<?php

function liens_dans_permalink($url,$post) {
	if($url_custo = get_post_custom_value('url',$post->ID)) {
		return $url_custo;
	} else {
	    return $url;
	}
}
//add_filter('the_permalink', 'liens_dans_permalink');

add_filter('post_link', 'liens_dans_permalink', 10, 2);