<?php
/*
add_action('generate_rewrite_rules', 'urls_fournisseurs');
 
function urls_fournisseurs() {
  global $wp_rewrite;
  $new_non_wp_rules = array(
    'css/(.*)'       => 'wp-content/themes/'. $theme_name . '/css/$1',
    'js/(.*)'        => 'wp-content/themes/'. $theme_name . '/js/$1',
    'images/wordpress-urls-rewrite/(.*)'    => 'wp-content/themes/'. $theme_name . '/images/wordpress-urls-rewrite/$1',
  );
  $wp_rewrite->non_wp_rules += $new_non_wp_rules;
}*/

add_filter( 'parse_query', 'filtre_fournisseurs' );
add_action( 'restrict_manage_posts', 'filtre_fournisseurs_restrict_manage_posts' );

function filtre_fournisseurs( $query )
{
    global $pagenow;

    if ( is_admin() && $pagenow=='edit.php') {
        if(!empty($_GET['ADMIN_FILTER_PREMIUM'])) {
	        $query->query_vars['meta_key'] = 'premium';
	        $query->query_vars['meta_value'] = 1;
	    }
    }
}

function filtre_fournisseurs_restrict_manage_posts()
{
    global $wpdb, $typenow;
		if ($typenow=='fournisseur'){
			$premium = !empty($_GET['ADMIN_FILTER_PREMIUM']);
?>
<select name="ADMIN_FILTER_PREMIUM" onchange="jQuery('input[name=filter_action]').trigger('click');">
<option value="1" <?php echo $premium ? 'selected' : '';?>>Partenaires</option>
<option value="0" <?php echo !$premium ? 'selected' : '';?>>Tous les fournisseurs</option>
</select>
<?php
}
}
/*
function filtre_fournisseurs_restrict_manage_posts()
{
    global $wpdb, $typenow;
		if ($typenow=='fournisseur'){
		    $sql = 'SELECT DISTINCT meta_key FROM '.$wpdb->postmeta.' ORDER BY 1';
		    $fields = $wpdb->get_results($sql, ARRAY_N);
?>
<select name="ADMIN_FILTER_FIELD_NAME">
<option value=""><?php _e('Filter By Custom Fields', 'baapf'); ?></option>
<?php
    $current = isset($_GET['ADMIN_FILTER_FIELD_NAME'])? $_GET['ADMIN_FILTER_FIELD_NAME']:'';
    $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
    foreach ($fields as $field) {
        if (substr($field[0],0,1) != "_"){
        printf
            (
                '<option value="%s"%s>%s</option>',
                $field[0],
                $field[0] == $current? ' selected="selected"':'',
                $field[0]
            );
        }
    }
?>
</select> <?php _e('Value:', 'baapf'); ?><input type="TEXT" name="ADMIN_FILTER_FIELD_VALUE" value="<?php echo $current_v; ?>" />
<?php
}
}*/

ini_set("memory_limit", "1G");

error_reporting(-1);
ini_set('display_errors', 'On');


function get_fournisseurs($params=array()) {
	$args = array();
	if(sinon($params,'premium')) {
		$args['meta_key']='premium';
		$args['meta_value']=1;
		$params['images']=true;
	}
	$fournisseurs = get_posts(array(
		'numberposts'	=> sinon($params,'parpage','default:500'),
		'offset'	=> sinon($params,'debut','default:0'),
		'post_type'		=> 'fournisseur',
		'orderby'=> 'title',
		'order' => 'ASC'
	)+$args);

	if(sinon($params,'images')) {
		foreach($fournisseurs as $k=>$v) {
			$v = get_object_vars($v);
			$v['thumbnail'] = get_post_thumbnail_url($v['ID']);
			$fournisseurs[$k] = $v;

		}
		return $fournisseurs;
	} else {
		return json_encode(json_decode($fournisseurs,true));
	}
}
