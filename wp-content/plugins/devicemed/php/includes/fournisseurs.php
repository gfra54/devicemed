<?php
$GLOBALS['MENU_FOURNISSEURS'] = array(
	array(
		'titre'=>'Coordonnées',
		'anchor'=>'coordonnees'
	),
	array(
		'titre'=>'Activités',
		'anchor'=>'activites',
	),
	array(
		'titre'=>'Présentation',
		'anchor'=>'presentation',
		'premium'=>true
	),
	array(
		'titre'=>'Articles',
		'anchor'=>'articles',
		'premium'=>true
	),
	array(
		'titre'=>'Photos',
		'anchor'=>'photos',
		'premium'=>true
	),
	array(
		'titre'=>'Vidéos',
		'anchor'=>'videos',
		'premium'=>true
	),
	array(
		'titre'=>'Evénements',
		'anchor'=>'evenements',
		'premium'=>true
	),
	array(
		'titre'=>'Documentation',
		'anchor'=>'documentation',
		'premium'=>true
	),
);

function fournisseur_categories($fournisseur) {
	$out=array();
	if($cats = wp_get_post_terms($fournisseur['ID'],'categorie')) {
		foreach ($cats as $cat) {
			if($cat->parent) {
				if(!isset($out[$cat->parent])) {
					$parent = get_term($cat->parent,'categorie');
					$tmp = array('nom'=>$parent->name,'url'=>get_term_link($parent),'categories'=>array());
					$out[$cat->parent]=$tmp;
				}
				$out[$cat->parent]['categories'][]=array('nom'=>$cat->name,'url'=>get_term_link($cat));
			}
		}
	}
	return $out;
}
function fournisseur_sections($fournisseur) {
	foreach($GLOBALS['MENU_FOURNISSEURS'] as $item) {
		$file = get_template_directory().'/single-fournisseur-'.$item['anchor'].'.php';
		if(file_exists($file)) {
			include $file;
		} else {
			m($file);
		}
	}
}
function fournisseur_menu($fournisseur) {

	$ret = '<section class="actions">';
	foreach($GLOBALS['MENU_FOURNISSEURS'] as $item) {
		if(!$item['premium'] || $fournisseur['premium']) {
			$ret.='<a href="'.$fournisseur['url'].'#'.$item['anchor'].'" class="menu_actif">'.$item['titre'].'</a>';
		} else {
			$ret.='<span class="details_supplier_disabled">'.$item['titre'].'</span>';

		}
	}
	$ret.='</section>';

	echo $ret;
}

function fournisseur_categorie_redir() {
	if(!empty($_GET['categorie'])) {
		if($term_id = nouvelIdCategorie($_GET['categorie'])) {
			wp_redirect(get_term_link(get_term($term_id,'categorie')),301);
			exit;
		}
	}
}
function fournisseur_redir($legacy_supplier_id) {
	if($fournisseur = get_fournisseur($legacy_supplier_id,true)) {
		wp_redirect($fournisseur['url'],301);
		exit;
	}
}
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

//error_reporting(-1);
//ini_set('display_errors', 'On');

function get_fournisseur($ID,$legacy=false) {
	if($legacy) {

		$query = new WP_Query(array(
			'post_type'		=> 'fournisseur',
			'meta_query' => array(
		       array(
		           'key' => 'legacy_supplier_id',
		           'value' => $ID,
		           'compare' => '=',
		       )
		   )
		));
		if(count($query->posts)) {
			return fournisseur_enrichir($query->posts[0]);
		}
	} else 
	if($fournisseur = get_post($ID)){
		if($fournisseur->post_type == 'fournisseur') {
			return fournisseur_enrichir($fournisseur);
		}
	}
}

function fournisseur_enrichir($fournisseur) {
	$fournisseur = get_object_vars($fournisseur);

	$allmeta = get_post_meta($fournisseur['ID']);
	foreach($allmeta as $k=>$v) {
		if(substr($k, 0,1) !='_') {
			$meta[$k] = $v[0];
			if(!isset($fournisseur[$k])) {
				$fournisseur[$k]=$v[0];
			}
		}
	}
	$fournisseur['meta'] = $meta;
	$gallerie = get_field('gallerie',$fournisseur['ID'],false);
	if(!is_array($gallerie)) {
		$gallerie = array();
	}
	$fournisseur['gallerie'] = $gallerie;

	$fournisseur['videos'] = array();
	while(have_rows('videos',$fournisseur['ID'])) {
		the_row();
		$fournisseur['videos'][] = array(
			'titre_de_la_video'=>get_sub_field('titre_de_la_video'),
			'url_de_la_video'=>get_sub_field('url_de_la_video')
		);
	}


	$fournisseur['logo'] = get_post_thumbnail_url($fournisseur['ID']);
	
	$fournisseur['permalink'] = get_post_permalink($fournisseur['ID']);

	$fournisseur['nom'] = $fournisseur['post_title'];


	$fournisseur['categories'] = fournisseur_categories($fournisseur);
	return $fournisseur;
}

function fournisseurs_compte($categorie=false) {
	if(!$categorie) {
		return wp_count_posts('fournisseur');
	} else {
		$query = new WP_Query( array( 
			'categorie' => $categorie,
	 		'post_type'		=> 'fournisseur'
		) );
		return $query->found_posts;
	}
}

function get_fournisseurs($params=array()) {
	$args = array();
	if(sinon($params,'premium')) {
		$args['meta_key']='premium';
		$args['meta_value']=1;
		$params['images']=true;
		$rich=true;
	} else {
		$rich=false;
	}
	if(sinon($params,'categorie')) {
		$args['categorie']=sinon($params,'categorie');
	}
	$args['numberposts'] = sinon($params,'parpage','default:500');
	$args['offset']	= sinon($params,'debut','default:0');
	$args['post_type'] = 'fournisseur';
	$args['orderby'] = 'title';
	$args['order'] = 'ASC';
m($arg todo s);
	$query = new WP_Query($args);
	$fournisseurs = $query->posts;
	// me($args,$query->posts);
	// $fournisseurs = get_posts($args);
	if($rich || sinon($params,'images')) {
		foreach($fournisseurs as $k=>$v) {
			$fournisseurs[$k] = fournisseur_enrichir($v);

		}
		return $fournisseurs;
	} else {
		return array_map('get_object_vars',$fournisseurs);
	}
}
