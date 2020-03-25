<?php


add_filter('tag_row_actions','action_row_extraction', 10, 2);

function action_row_extraction($actions, $tag){
    //check for your post type
    if ($tag->taxonomy =="categorie"){
    	if($tag->parent) {
    		$attr ='sous_categorie='.$tag->term_id.'&categorie='.$tag->parent;
    	} else {
    		$attr = 'categorie='.$tag->term_id;
    	}
        $actions['export'] = '<a href="/fournisseurs?excel=true&'.$attr.'">Export&nbsp;fournisseur</a>';
    }
    return $actions;
}