<?php

if($id = check('id')) {

	$thumb_id = get_post_thumbnail_id($id);
	$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
	$thumb_url = $thumb_url_array[0];
	$json['etat']=true;
	$json['url']=$thumb_url;
}