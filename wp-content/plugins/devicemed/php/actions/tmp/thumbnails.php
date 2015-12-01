<?php

$GLOBALS['NB_IMAGES_HOME']=0;
function the_post_thumbnail_ratio($size, $custom_id=null){
	$tn_id = get_post_thumbnail_id( get_the_ID() );
	if($custom_id!=null) {
		$img = wp_get_attachment_image_src( $custom_id, $size );
	} else {
		$img = wp_get_attachment_image_src( $tn_id, $size );
	}

	$format = get_post_thumbnail_ratio($size,$img);
	if(!empty($img[0])) {
		if($GLOBALS['NB_IMAGES_HOME']>7) {
			echo '<img data-original="'.$img[0].'" class="image-'.$format.' detect-lazy">';
		} else {
			echo '<img src="'.$img[0].'" class="image-'.$format.'">';
		}
		$GLOBALS['NB_IMAGES_HOME']++;
		return true;
	} else return false;
}

function get_post_thumbnail_ratio($size='large',$img=false){
	if(!$img) {
		$tn_id = get_post_thumbnail_id(get_the_ID() );
		$img = wp_get_attachment_image_src( $tn_id, $size );
	}
	if($img[1] == $img[2]) {
		$format='carre';
	}else if($img[1] <= $img[2]) {
		$format = 'portrait';
	} else {
		$format = 'paysage';
	}
	return $format;

}

function get_post_thumbnail_precent_ratio($size='large',$img=false){
	if(!$img) {
		$tn_id = get_post_thumbnail_id(get_the_ID() );
		$img = wp_get_attachment_image_src( $tn_id, $size );
	}

	return 100 * $img[2] / $img[1];

}