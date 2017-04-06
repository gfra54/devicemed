<?php

add_filter('post_row_actions','custion_action_row', 10, 2);

function custion_action_row($actions, $post){
    if ($post->post_type =="post"){
    	$actions['ga']='<a href="https://analytics.google.com/analytics/web/#report/content-drilldown/a55916994w89227602p92714496/%3Fexplorer-table.filter%3D%2F'.$post->ID.'%26explorer-table.plotKeys%3D%5B%5D/" target="_blank">Google Analytics</a>';
    }
    return $actions;
}