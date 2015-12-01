<?php

function page_datas($params=array()) {
	$main_tag=false;
	if($qo = get_queried_object()) {
		if($qo->taxonomy == 'post_tag') {
			$main_tag = $qo;
		}
	}
	$page_datas = array();
	if(!isset($params['title']) || $params['title'] == 'auto') {
		$page_datas['title'] = $main_tag ? $main_tag->name : get_the_title();
	} else if(isset($params['title'])){
		$page_datas['title'] = $params['title'];
	}

	if(!isset($params['type']) || $params['type'] == 'auto') {
		$type = get_post_type();
		$page_datas['type'] = $main_tag ? 'tag' : $type;
	} else if(isset($params['type'])){
		$page_datas['type'] = $params['type'];
	}

	if(isset($params['type'])) {
		$page_datas['type'] = $params['type'];
	}
	if(isset($params['tag'])) {
		$params['tags'] = array($params['tag']);
	}

	if(isset($params['tags'])) {
		if($params['tags'] == 'auto') {
			if($main_tag) {
				$page_datas['tags'] = array($main_tag->slug);
			} else if($tags = wp_get_post_tags(get_the_ID())) {
				$page_datas['tags'] = array();
				foreach($tags as $tag) {
					$page_datas['tags'][]=$tag->slug;
				}
			}
		} else {
			$page_datas['tags']=is_array($params['tags']) ? $params['tags'] : array($params['tags']);
		}
	}?>
	<script>var PAGE_DATAS = <?php echo json_encode($page_datas);?></script>
	<?php
}
