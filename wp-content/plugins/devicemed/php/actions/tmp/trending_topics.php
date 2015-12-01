<?php



function get_trending_topics(){
	$loop = new WP_Query(array(
		'post_type' => 'post', 
		'posts_per_page' => 20
	));

	$topics = array();
	while ($loop->have_posts()) { 
		$loop->the_post();
		if($st = get_field('surtitre')){
			if(in_array($st, $topics)===false) {
				$topics[get_the_permalink()]= $st;
			}
		}
	}
	shuffle_assoc($topics);
	if(is_array($topics)) {
		return array_slice($topics,0,5,true);
	} else {
		return array();
	}
} 