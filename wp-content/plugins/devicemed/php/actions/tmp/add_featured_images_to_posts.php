<?php

function the_default_image($size='large'){
	the_post_thumbnail($size);
	excluWeb();
	the_post_thumbnail_caption();
}

function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));


  if ($thumbnail_image && isset($thumbnail_image[0]) && !empty($thumbnail_image[0]->post_excerpt)) {
    echo '<div class="image-legend poster-giant-image-legend">'.$thumbnail_image[0]->post_excerpt.'</div>';
  }
}

/* works with Multiple Post Thumbnails */
if (class_exists('MultiPostThumbnails')) {

	new MultiPostThumbnails(array(
		'label' => 'Home Image',
		'id' => 'home-image',
		'post_type' => 'post'
   ) );

	function the_home_image($size='full', $post_id=NULL, $thumb_id='home-image'){
		$post_type = get_post_type();
    $post_id = (NULL === $post_id) ? get_the_ID() : $post_id;
    $post_thumbnail_id = MultiPostThumbnails::get_post_thumbnail_id( get_post_type(), 'home-image', $post_id );

    $ret = MultiPostThumbnails::get_the_post_thumbnail($post_type, $thumb_id,$post_id, $size);
    $src = getHtmlVal('src="','"',$ret);

    $home['src'] = $src;
    $home['tn_id'] = $post_thumbnail_id;

    return $home;
  }
}