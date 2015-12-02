<?php

function acf_load_articles( $field ) {
    
    // reset choices
    $field['choices'] = array();

    $args = array( 
        'post_type' => 'post',
        'posts_per_page' => 20
    );
    if(!empty($attr['raw'])){
        $cadre=false;
    }
    if($posts = new WP_Query($args)) {
        foreach($posts->posts as $post) {
            list($cat) = get_the_category($post->ID);
            $field['choices'][$post->ID]=$cat->name.' - '.get_the_title($post->ID);
        }
    }
    return $field;
    
}

add_filter('acf/load_field/name=articles', 'acf_load_articles');