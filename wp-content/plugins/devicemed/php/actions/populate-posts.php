<?php
function acf_load_textad( $field ) {
    
    // reset choices
    $field['choices'] = array('');

    $posts = get_pubs('newsletter-textad');
    if($posts) {
        foreach($posts as $post) {
            $field['choices'][$post->ID]=$post->post_title;
        }
    }
    return $field;
    
}

add_filter('acf/load_field/name=textad', 'acf_load_textad');

function acf_load_bannieres_verticales( $field ) {

    // reset choices
    $field['choices'] = array(0=>'');

    $posts = get_pubs('newsletter-droite');
    if($posts) {
        foreach($posts as $post) {
            $field['choices'][$post->ID]=$post->post_title;
        }
    }
    return $field;
    
}

add_filter('acf/load_field/name=banniere_verticale', 'acf_load_bannieres_verticales');


function acf_load_bannieres_horizontales( $field ) {
    // reset choices
    $field['choices'] = array(0=>'');

    $posts = get_pubs('newsletter-banniere-horizontale');
    if($posts) {
        foreach($posts as $post) {
            $field['choices'][$post->ID]=$post->post_title;
        }
    }
    return $field;
    
}
add_filter('acf/load_field/name=banniere_horizontale_en_haut', 'acf_load_bannieres_horizontales');
add_filter('acf/load_field/name=banniere_horizontale_en_bas', 'acf_load_bannieres_horizontales');




function acf_load_articles( $field ) {
    $field['choices'] = array();
    global $post;

    $meta = get_post_meta($post->ID);

    if(!empty($meta['mot_cle'][0])) {
        $args = array( 
            'post_type' => 'post',
            'tag' => $meta['mot_cle'][0]
        );
        if($posts = new WP_Query($args)) {
            foreach($posts->posts as $tmp_post) {
                list($cat) = get_the_category($tmp_post->ID);
                //$cat->name.' - '.
                $field['choices'][$tmp_post->ID]=$tmp_post->ID.' - '.get_the_title($tmp_post->ID);
            }
        }
    }

    return $field;
    
}

add_filter('acf/load_field/name=articles', 'acf_load_articles');



function acf_mot_cle($value) {
    global $post;

    $meta = get_post_meta($post->ID);
    if(isset($meta['date_envoi'][0]) && empty($meta['mot_cle'][0])) {
        return 'NL-'.date('d-m-y',strtotime($meta['date_envoi'][0]));
    } else {
        return $meta['mot_cle'][0];
    }
}
add_filter('acf/load_value/name=mot_cle', 'acf_mot_cle');
