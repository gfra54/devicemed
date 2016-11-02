<?php

//wp_register_style( 'pubs', plugins_url().'/custom-functions/css/pubs.css');
//wp_enqueue_style( 'pubs' );


//require_once(dirname(__FILE__).'/widgets/pubs_300x250.widget.php');

$GLOBALS['PUBS'] = false;
function get_pubs($type=false) {
   	if($pubs = get_transient('pubs')) {
		$out = array();
		foreach($pubs as $pub) {
			if($type===false || check_espace($type,$pub)){
				$out[]=$pub;
			}
		}
		return $out;
	}
}
function afficher_pub_js($type,$attr=array()) {
	$pubs = get_selected_pub($type,get_pubs($type),true);
	if(count($pubs)) {
		$pubs_final = array();
		foreach($pubs as $k=>$pub) {
			$pub = pub_metrics($pub);
//			$pub = get_object_vars($pub);
			$tmp=array();
			$tmp['id'] = $pub['ID'];
			$tmp['largeur_maximale'] = get_field('largeur_maximale',$pub['ID']);
			$tmp['bordure'] = get_field('bordure',$pub['ID']);
			$tmp['url_tracking_clicks'] = https(get_field('url_tracking_clicks',$pub['ID']));
			$tmp['url_tracking_display'] = https(get_field('url_tracking_display',$pub['ID']));
			$tmp['image'] = https($pub['image']);
			$tmp['time'] = time();
			$pubs_final[]=$tmp;
		}
		?><script>randomPub(<?php echo json_encode($pubs_final);?>);</script><?php
	}
}
function afficher_pub($type,$attr=array()) {


	if($return = sinon($attr,'return')) {
		unset($attr['return']);
	}
	if(!empty($attr['raw'])){
		$cadre=false;
	}
	$pubs = get_pubs($type);
	if($type=="cadre-video") {
		$pub=false;
		foreach($pubs as $tmp_pub) {
			if(!$pub && $tmp_pub['post_status'] == 'publish') {
				$pub = $tmp_pub;
			}
		}
	} else {
		$pub = get_selected_pub($type,$pubs);
	}
	if($pub) {
		if($ret = display_pub($pub,$attr,$type)) {
			if($return) {
				return $ret;
			} else {
				echo $ret;
				return true;
			}
		}
	}
	return false;
}

function display_pub($pub,$attr=array(),$type=false) {
	if(empty($pub)){
		return false;
	}
	if(is_numeric($pub)) {
		$pub = get_post($pub);
	}
	$PUB = pub_metrics($pub);
	if(check_espace('newsletter-textad',$pub)) {
		  $textad = pub_metrics($pub);
		  return render_textad(array(
		      'image'=>get_field('url_tracking_display',$textad['ID']),
		      'title'=>get_field('titre_pub',$textad['ID']),
		      'text'=>get_field('texte',$textad['ID']),
		      'lien'=>get_field('libelle_lien',$textad['ID']),
		      'url'=>get_field('url_tracking_clicks',$textad['ID'])
		  ));
	} else
	if($type == 'cadre-video') {
		$out='<section id="sidebar-issues" class="cadre-video">';
		$out.='<header>';
		// $out.='<div class="right-side">';
		$out.='<h1 class="title">'.get_field('titre_video',$PUB['ID']).'</h1>';
		// $out.='</div>';
		$out.='</header><article>';
		if($url_video = get_field('url_video',$PUB['ID'])) {
			$video = resizeVideo(gestVideo(https($url_video)));
			$out.=$video;
		}
		$out.=get_field('code',$PUB['ID']);
		$out.='<center><a class="more archives-videos" href="/videos">Voir d\'autres vidéos</a></center>';
		$out.='</article></section>';
		return $out;
	} else
	


	if($type == 'site-habillage') {
		$GLOBALS['habillage']=true;
		extracss('pubs');
		$out = '<body class="body-habillage" data-url="'.addURLParameter($PUB['url_tracking_clicks'],'t',time()).'"';
		$out.=' style="'.
			'background-color:'.get_field('couleur_de_fond',$PUB['ID']).';'.
			'padding-top:'.get_field('hauteur',$PUB['ID']).'px;'.
			'background-image:url('.$PUB['url_tracking_display'].');"'.
		'>';
		$cadre=false;

	} else {
		$cadre=true;
//			if($PUB['ID'] == 5067) mse($PUB);
		if($PUB['url_tracking_display']) {
			$style='';
			$largeur_maximale = get_field('largeur_maximale',$PUB['ID']);

			if(get_field('bordure',$PUB['ID'])) {
				$style.='border:1px solid #ccc;';
				$largeur_maximale-=2;
			}
			if($largeur_maximale>0) {
				$style.='max-width:'.$largeur_maximale.'px;';
			}
			if($style){
				$style = 'style="'.$style.'"';
			}
			$out = '<a href="'.addURLParameter($PUB['url_tracking_clicks'],'t',time()).'" target="_blank"><img '.$style.' src="'.addURLParameter($PUB['url_tracking_display'],'t',time()).'"></a>';
		}
	}
	$ret='';
	if($cadre){
		$attr['data-id'] = $pub->ID;
		$attr['data-titre'] = $pub->post_title;
		$attr['data-type'] = $type;
		$ret.= '<section '.array_to_html_attributes($attr,array('class'=>'reclame')).'>';
	}
	$ret.=$out;
	$ret.=get_field('code',$PUB['ID']);
	if($cadre){
		$ret.='</section>';
	}
	return $ret;
}

function get_selected_pub($type, $pubs, $all=false) {
	$pubs_sort=array();
	foreach($pubs as $key => $pub) {
		if(check_espace($type,$pub)) {
			$public = $pub['post_status'] == 'publish';
			if($date_debut = $pub['date_debut']) {
				$date_debut.=' 00:00:00';
			}
			if($date_fin = $pub['date_fin']) {
				$date_fin.=' 23:59:59';
			}
			$ok=true;
			$change=false;
			if(!empty($date_debut)) {
				if(time()<strtotime($date_debut)) {
					if($public) {
						change_post_status($pub['ID'],'draft');
						$change=true;
						// m('1 on est avant publication. Si la pub est public, on la met en draft',$pub);
						$public=false;
					}
					$ok=false;
				} else if(!$public){
					if(!$date_fin || time()<strtotime($date_fin)) {
						change_post_status($pub['ID'],'publish');
						$change=true;
						// m('2 on est apres le debut de publication. Si la pub est draft, on la met en public',$pub);
						$public=true;
					}
				}
			}

			if(!empty($date_fin)) {
				if(time()>strtotime($date_fin)) {
					if($public) {
						change_post_status($pub['ID'],'draft');
						$change=true;
						// m('3 on est apres la date de fin. Si la pub est public, on la met en draft',$pub);
						$public=false;
					}
					$ok=false;
				} else if(!$public){
					if(!$date_debut || time()>strtotime($date_debut)) {
						change_post_status($pub['ID'],'publish');
						$change=true;
						// m('4 on est avant la date de fin et apres la date de debut. Si la pub est pas public, on la met en public',$pub);
						$public=true;
					}
				}
			}
			if($change) {
				store_pub($pub);
			}
			if(!$public) {
				$ok=false;
			}
			if($ok) {
				$pubs_sort[$key] = $pub['pages'];
			}
		}
	}
	asort($pubs_sort);
	$pubs_sort = array_reverse($pubs_sort,true);

	$pubs_pages = array();
	$pubs_normal = array();
	foreach($pubs_sort as $id_pub => $pages) {
		if(check_pub_page($pages)) {
			$pubs_pages[]=$pubs[$id_pub];
		} else if(empty($pages)){
			$pubs_normal[]=$pubs[$id_pub];
		}
	}
	if($all) {
		if(count($pubs_pages)) {
			return $pubs_pages;
		} else {
			return $pubs_normal;			
		}
	} else {
		if(count($pubs_pages)) {
			return $pubs_pages[array_rand($pubs_pages)];
		} else
		if(count($pubs_normal)) {
			return $pubs_normal[array_rand($pubs_normal)];
		}
	}
}
function check_espace($type,$pub) {
	if(is_array($pub) && isset($pub['espaces'])) {
		$espaces = $pub['espaces'];
	} else {
		$espaces = wp_get_post_terms($pub->ID,'emplacements');
	}
	foreach($espaces as $espace) {
		if($espace->slug == $type) {
			return true;
		}
	}
}
/*function check_univers($univers) {

	if($univers == "Toutes les pages") {
		return true;
	} else if($univers == "Seulement la page d'accueil" && is_front_page()) {
		return true;
	} else if($univers == "Toutes les pages sauf la page d'accueil" && !is_front_page()) {
		return true;
	}
	return false;
}*/
function check_pub_page($pages) {
	if($pages) {
		$pages = array_map('trim',explode(PHP_EOL,$pages));
		
		$uri = $_SERVER['REQUEST_URI'];
		foreach($pages as $page) {
			if($page) {
				if($uri == $page) {
					return true;
				} else if(strlen($page) > 2 && strstr($uri, $page)!==false) {
					return true;
				}
			}
		}
	}
	return false;
}

function pub_metrics($pub) {
	if(is_object($pub)) {
		$id = $pub->ID;
	} else {
		$id = $pub['ID'];
	}
	$url_tracking_clicks=false;
	$url_tracking_display=false;
	if($url_cible = get_field('url_cible',$id)) {
		if(!$url_tracking_clicks = get_field('url_tracking_clicks',$id)) {
			$url = addURLParameter($url_cible,$id);
			$url_tracking_clicks = bitly_shorten($url);
			if(!$url_tracking_clicks) {
				$url_tracking_clicks = $url_cible;
			} else {
				update_post_meta($id, 'url_tracking_clicks', $url_tracking_clicks);
			}
		}
	}
	$out=array();
	foreach($pub as $k=>$v) {
		$out[$k]=$v;
	}
	if($out['image'] = get_post_thumbnail_url($id)) {
		if(!$url_tracking_display = get_field('url_tracking_display',$id)) {
			if($url_tracking_display = bitly_shorten($out['image'])) {
				update_post_meta($pub->ID, 'url_tracking_display', $url_tracking_display);
			} else {
				$url_tracking_display = $out['image'];
			}
		}
	}
	$out['url_tracking_clicks']=$url_tracking_clicks;
	$out['url_tracking_display']=$url_tracking_display;
	$out['url_cible'] = $url_cible;
	return $out;
}
/*'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true );
*/


function render_textad($ad) {

ob_start();
	?>
	<center>
  <table border="0" cellspacing="0" width="480">
    <tr>
        <td valign=top align="left" style="text-align:left">
        <font size=1 color=#999 face="sans-serif">Annonce</font>
		</td>
	</tr>
	<tr>
		<td>
			<fieldset border=1 bordercolor="#333" style="border:1px solid #333">
				<table cellspacing=0 cellpadding="8">
				<tr>
					<td width="120" valign="top" border=0>
						<a <?php echo $ad['url'] ? 'href="'.$ad['url'].'"' : '';?> target="_blank">
						<table bgcolor=#ccc cellspacing=0 cellpadding=1><td><img style="display:block" width="100" height="auto" src="<?php echo $ad['image'];?>"></td></table></a>
					</td>
					<td valign="top" border=0>
						<a style="text-decoration:none;" <?php echo $ad['url'] ? 'href="'.$ad['url'].'"' : '';?> target="_blank"><span style="font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;color:black;"><?php echo $ad['title'];?></span></a>


						<div>
						<font size=2 face="sans-serif" color="#333"><?php echo $ad['text'];?></font><a target="_blank" style="text-decoration:none;" <?php echo $ad['url'] ? 'href="'.$ad['url'].'"' : '';?>><font face="sans-serif" size=2 color="#005ea8"><?php echo !empty($ad['lien']) ? $ad['lien'] : 'Lire la suite.';?></font></a>
						</font>
						</div>
					</td>

				</tr>
				</table>
			</fieldset>
    </td>
  </tr>
  </table>
  <center>
<?php	
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
}


function store_pub($post) {
	$pubs = get_transient('pubs');
	if($post->post_status == 'trash') {
		unset($pubs[$post->ID]);
	} else {
		if(!is_array($pubs)) {
			$pubs = array();
		}
		$pubs[$post->ID]=prepare_store_pub($post);
	}
	return set_transient('pubs',$pubs);
}

function prepare_store_pub($post) {
	$pub = pub_metrics($post);
	$pub['espaces'] = wp_get_post_terms($post->ID,'emplacements');
	$pub['date_debut'] = get_field('date_debut',$post->ID);
	$pub['date_fin'] = get_field('date_fin',$post->ID);
	$pub['pages'] = get_field('pages',$post->ID);
	return $pub;
}


function store_pubs($force=false) {
	if(WP_DEBUG || !get_transient('pubs_stored') || $force) {
		$args = array( 
			'post_type'	=> 'pubs',
			'post_status'=>array('draft','publish'),
			'posts_per_page'=>1000,
			'order'=>'DESC',
			'orderby'=>'date'
		);
		if($posts = new WP_Query($args)) {
			$pubs = array();
			foreach($posts->posts as $post) {
				$pubs[$post->ID] = prepare_store_pub($post);
			}
			set_transient('pubs',$pubs);
			set_transient('pubs_stored',true);
		}
	}
}
