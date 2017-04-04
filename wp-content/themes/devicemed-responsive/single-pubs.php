<?php
if($url = get_field('url_cible',$post->ID)) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".$url);
	exit();
} else {
	wp_redirect('/');
}