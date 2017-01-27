<?php
add_filter( 'the_content', 'liens_fournisseurs' ,2);

function liens_fournisseurs($content) {
		global $post;
		return fournisseur_parse_liens($post->ID, $content);
}

