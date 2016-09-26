<?php


function get_related($id,$all=true) {
	$categories = wp_get_post_terms($id,'category');
	if ($categories) {
		$cats = array();
		foreach($categories as $cpt=>$cat) {
			if($all || $cpt == 0) {
				$cats[]=$cat->term_id;
			}
		}
		$args=array(
		'cat_in' => $cats,
		'post__not_in' => array($id),
		'posts_per_page'=>5,
		'caller_get_posts'=>1
		);
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
			me($my_query->posts);
		}
		wp_reset_query();
	}
}


function isLocal() {
	return strstr($_SERVER['HTTP_HOST'],'.local')!==false;
}
function transient_key($lib,$id) {
	return $lib.'_'.$id;
}

function https($url) {
	if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
		$url = str_replace('http://','https://',$url);
	}
	return $url;
}
/*define('DOCUSTOMCACHE',false);
define('CACHETAG','<!-- CACHETAG -->');
$GLOBALS['pagecache-name']=false;
function get_pagecache($name=false) {
	if(!DOCUSTOMCACHE) {return false;}
	if($name === false) {
		$name = get_the_ID();
	}
	if($content = get_transient('pagecache-'.$name)) {
		echo $content;
		exit;
	} else {
		pagecache($name);
		return false;
	}
}

function pagecache($name=false) {
	if(!DOCUSTOMCACHE) {return false;}
	if($name) {
		$GLOBALS['pagecache-name']=$name;
		ob_start();
	} else {
		if(!empty($GLOBALS['pagecache-name'])) {
			$name = $GLOBALS['pagecache-name'];
			$GLOBALS['pagecache-name']=false;
			$content = ob_get_contents();
			ob_end_clean();
			echo cacheproof($content);
			$content = cachetag($content);
			set_transient('pagecache-'.$name,$content);
		}
	}
}
function cachetag($content) {

	$content = str_replace('html {','html .voir-adminbar{',$content);
	$content = str_replace('* html body {','* html body.voir-adminbar {',$content);
	$content = str_replace('<div id="wpadminbar"','<div id="wpadminbar" style="display:none"',$content);
	$content = str_replace('</head>','</head>'.CACHETAG,$content);
	return $content;
}
function cacheproof($content) {
	$content = str_replace('</title>','.</title>',$content);
	return $content;
}
function cachepage_clear($name) {
	delete_transient('pagecache-'.$name);
}
*/
function cond($before,$data,$after=false) {
	if($data) {
		echo $before;
		echo $data;
		echo $after;
		return true;
	}
}

function link_cond($url,$lib=false,$before=false,$after=false) {
	if(isurl($url)) {
		echo $before;
		?><a href="<?php echo esc_html($url) ?>" target='_blank'><?php echo esc_html($lib ? $lib : $url); ?></a><?php
		echo $after;
		return true;
	}
}
function array_unique_multi($array) {
	return array_map("unserialize", array_unique(array_map("serialize", $array)));
}
function get_attachment_id_by_url( $url ) {
	global $wpdb;

	if(!isUrl($url)) {
		if(strstr($url, 'wp-content/')!==false) {
			list(,$url) = explode('wp-content/',$url);
		}
		$url = str_replace('.','_',$url);
		$url = str_replace(' ','_',$url);
		$url = str_replace('(','_',$url);
		$url = str_replace(')','_',$url);
		while(strstr($url, '__')!==false) {
			$url = str_replace('__','_',$url);
		}
		$sql = "SELECT ID FROM ".$wpdb->prefix."posts WHERE guid LIKE '%".mysql_escape_string($url)."%'";
	} else {
		$sql = "SELECT ID FROM ".$wpdb->prefix."posts WHERE guid= '".mysql_escape_string($url)."'";
	}
	// Now we're going to quickly search the DB for any attachment GUID with a partial path match
	// Example: /uploads/2013/05/test-image.jpg
	if($attachment = $wpdb->get_col( $sql  )) {
		// ms($url);

		// Returns null if no attachment is found
		return $attachment[0];
	} else if(strstr($url, ' ')!==false) {
		return get_attachment_id_by_url(str_replace(' ','',$url));
	}
}


function include_external($file,$maj=false){
	if(is_array($file)) {
		foreach($file as $fileunique) {
			include_external($fileunique,$maj);
		}
	} else {
		$ext = getExtension($file);
		if(!isUrl($file)) {
			$path = DEVICEMED_THEME_PATH.$file;
			$time= 'A'.date('Ymd');
			$time = $maj && $maj>$time ? $maj : $time;
			$file = addURLParameter($file,'t',$time);
			$file = DEVICEMED_THEME_URL.$file;
		}
		if($ext == 'css'){
			baliseCss($file);
		} else if($ext == 'js') {
			?><script src="<?php echo $file;?>"></script><?php 
		}
		echo PHP_EOL;
	}
}	

function isUrl($string) {
	return strstr($string, 'http://') !==false || strstr($string, 'https://') !==false;
}

function baliseCss($file){
	$css = '<link rel="stylesheet" href="'.$file.'" type="text/css"/>';
	echo $css;
}

function getExtension($f) {
	$tmp = explode('.',$f);
	return end($tmp);
}
function nouvelIdCategorie($id,$souscategorie=false) {
	$sql='SELECT * FROM legacy_categories WHERE id_ancien = "'.$id.'" AND souscategorie = "'.($souscategorie ? 1 : 0).'"';
	$ret = mysql_fetch_array(mysql_query($sql));
	if(isset($ret['id_nouveau'])) {
		return $ret['id_nouveau'];
	} 
	//else me($sql);
}

$slugs = array();
function creerCategorie($nom,$id_ancien,$souscategorie=false, $parent=0,$parent_ancien=0,$nom_parent='') {
	global $slugs;
	$slug = sanitize_title(trim($nom_parent.' '.$nom));
	if(!empty($slugs[$slug])) {
		$cpt=1;
		while(!empty($slugs[$slug.'-'.$cpt])) {
			$cpt++;
		}
		$slug = $slug.'-'.$cpt;
	}

// ms($nom_parent,$slug);
	$slugs[$slug] = true;
	// e($slug);
	echo '.';

	$ret = wp_insert_term($nom,'categorie',array(
		'parent'=>$parent,
		'slug'=>$slug
	));

	if(is_array($ret)) {
			mysql_query('INSERT INTO legacy_categories (
				nom,
				id_nouveau,
				id_ancien,
				parent_nouveau,
				parent_ancien,
				souscategorie
			) VALUES (
				"'.addslashes($nom).'",
				"'.$ret['term_id'].'",
				"'.$id_ancien.'",
				"'.$parent.'",
				"'.$parent_ancien.'",
				"'.($souscategorie ? '1' : '0').'"
			)');
			return $ret['term_id'];
	} else {
		mse($ret);
	}
}

function Generate_Featured_Image( $image, $post_id  ){
    $filename = basename($image);
    $path = dirname($image);
    $clean = $path.'/'.sanitize_title($filename);
    if(is_file($image)) {
    	if($clean != $image) {
		    copy($image,$clean);
		}
	    list(,$fragment) = explode('wp-content/',$clean);
	    $file = $clean;
	    $file_url = site_url().'/wp-content/'.$fragment;

	    if($attach_id = get_attachment_id_by_url($file_url)) {
	    	set_post_thumbnail( $post_id, $attach_id );
	    } else {
		    $wp_filetype = wp_check_filetype($filename);
		    $attachment = array(
				'guid' => $file_url, 
		        'post_mime_type' => $wp_filetype['type'],
		        'post_title' => sanitize_file_name($filename),
		        'post_content' => '',
		        'post_status' => 'inherit'
		    );
		    $attach_id = wp_insert_attachment_meta( $attachment, $file, $post_id);
		}
	    return $attach_id;
	}
}

function wp_insert_attachment_meta( $attachment, $file=false, $post_id=0) {
    if($attach_id = wp_insert_attachment( $attachment, $file, $post_id)) {
	    require_once(ABSPATH . 'wp-admin/includes/image.php');
	    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
	    $res2= set_post_thumbnail( $post_id, $attach_id );
	    return $attach_id;
	}
}
function datefr($date) {
	$GLOBALS['MOIS'] = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
	$time = strtotime($date);
	$Y = date('Y',$time);
	$m = intval(date('m',$time));
	$d = intval(date('d',$time));
	if($d == 1){
		$d = '1<sup>er</sup>';
	}
	return $d.' '.mb_strtolower($GLOBALS['MOIS'][$m-1]).' '.$Y;
}

function session_file_get_contents($f) {
	if(!isset($_SESSION['files'][$f]) || empty($_SESSION['files'][$f])){
		$_SESSION['files'][$f] = file_get_contents($f);
	}
	return $_SESSION['files'][$f];

}


function HtmlTagAttributesToString($params) {
	$out='';
	foreach($params as $k=>$v) {
		$out.=$out ? ' ':'';
		$out.=$k;
		if($v) {
			$out.='="'.htmlspecialchars($v).'"';
		}
	}
	return $out;
}
function parseHtmlTagAttributes($attr){

	$champs = str_replace('="','=',stripslashes($attr));
	$params=array();
	$tab = explode('"',$champs);
	foreach($tab as $k=>$v) {
		$tmp = explode('=',$v);
		if($key=trim($tmp[0])) {
			unset($tmp[0]);
			$params[$key] = implode('=',$tmp);
		}
	}
	return $params;

}

function http($url){
	if($url) {
		if(!strstr($url, 'http')) {
			$url = 'http://'.$url;
		}
		return $url;
	}
}
function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
    );

    $replace = array(
        '>',
        '<',
        '\\1'
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}

setlocale(LC_TIME, "fr_FR");

function add_utm($url,$content=false,$medium=false,$source=false,$campaign=false){
	if(!$campaign) {
		$campaign= 'newsletter-'.date('Ymd');
	}
	if(!$medium) {
		$medium='mail';
	}
	if(!$source) {
		$source='newsletter';
	}
	if(!$content) {
		$content='article';
	}
	return addURLParameter($url,array(
		'utm_content'=>$content,
		'utm_medium'=>$medium,
		'utm_campaign'=>$campaign,
		'utm_source'=>$source,
	));
}

function addURLParameter ($url, $paramName=false, $paramValue=false) {
	if(!$paramName || !$url){
		return $url;
	}
	if(is_array($paramName) && !$paramValue){
		foreach($paramName as $k=>$v){
			$url = addURLParameter($url,$k,$v);
		}
		return $url;
	} else {
	     $url_data = parse_url($url);
	     $params = array();
		 if(isset($url_data['query'])) {
		     parse_str($url_data['query'], $params);
		 }
	     if($paramName == '#'){
		     $params_str = http_build_query($params);
		     $url =  http_build_url($url, array('query' => $params_str));
		     
		     list($url) = explode('#',$url);
		     return $url.'#'.$paramValue;
	     } else {
	    	 $params[$paramName] = $paramValue;   
		     $params_str = http_build_query($params);
		     return http_build_url($url, array('query' => $params_str));
	     }
	}
}

function cleantext($txt) {

	$txt = str_replace("\n","",$txt);
	$txt = str_replace("\r","",$txt);
	$txt = str_replace("&nbsp;"," ",$txt);
	$txt = str_replace("<br />","<br>",$txt);
	$txt = str_replace("<BR />","<br>",$txt);
	$txt = str_replace("<br/>","<br>",$txt);
	$txt = str_replace("<BR />","<br>",$txt);
	$txt = str_replace("<br>","\n",$txt);
	$txt = str_replace("<br>","\n",$txt);
	return nl2br(trim($txt));
}

function extracss($w) {
?><link rel="stylesheet" href="<?php echo DEVICEMED_THEME_URL;?>/css/extra/<?php echo $w;?>.css" /><?php 
}
function extrajs($w) {
include_external('js/extra/'.$w.'.js');
}
function addToURL($url,  $key, $value) {
    $info = parse_url( $url );
    parse_str( $info['query'], $query );
    return $info['scheme'] . '://' . $info['host'] . $info['path'] . '?' . http_build_query( $query ? array_merge( $query, array($key => $value ) ) : array( $key => $value ) );
}
function check_tag($tag, $post=false) {
	if(!$post) {
		global $post;
	}
	return has_tag( $tag, $post );
}

function get_post_custom_value($key,$pid=false){
	global $post;
	if(!$pid){
		$pid = $post->ID;
	}
	if(list($ret) = get_post_custom_values($key,$pid)) {
		return $ret;
	} else {
		return false;
	}
}
function shuffle_assoc(&$array) {
	$keys = array_keys($array);

	shuffle($keys);

	foreach($keys as $key) {
		$new[$key] = $array[$key];
	}

	$array = $new;

	return true;
}

function get_current_loop_index($val=false){
	global $wp_query, $loop;
	if(!isset($loop)) {
		$loop = $wp_query;
	}
	return $loop->current_post;
}

function the_loop_index($val=false){
	if(!isset($GLOBALS['loop_index'])){
		$GLOBALS['loop_index']=-1;
	}
	if($val!==false){
		$GLOBALS['loop_index']=$val-1;
	}
	return $GLOBALS['loop_index']++;
}

function get_loop_index($val=false){
	return isset($GLOBALS['loop_index']) ? $GLOBALS['loop_index'] : 0;
}
function toHtmlAttributes($params,$no=array()){
	if(!is_array($no)){
		$no = array($no);
	}
	$out='';
	if(is_array($params)) {
		foreach($params as $k=>$v){
			if(!is_array($v) && in_array($k, $no)===false){
				if($k!='class' || !empty($v)){
					$out.=' '.$k.'="'.htmlspecialchars($v).'"';
				}
			}
		}
	}
	return $out;
}
function strip_tags_empty($html,$ok=array(),$_tags=false){
	if(!is_array($ok)){
		$ok = array($ok);
	}
	$tags = array('p','a','b','i','small','span');
	if(is_array($_tags)){
		$tags = $tags + $_tags;
	}
	foreach($tags as $tag){
		if(in_array($tag, $ok)===false) {
			$pattern = "/<".$tag."[^>]*><\\/".$tag."[^>]*>/"; 
			$html = preg_replace($pattern, '', $html); 	
		}
	}
	return $html;
}
function strip_tags_specific($text,$tags){
	if(!is_array($tags)){
		$tags = array($tags);
	}
	foreach($tags as $tag){
		$text = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/",'',$text);
	}
	return $text;
}
/**
* getHtmlVal
* 
* getHtmlVal($debut,$fin,$d,$nb=1,$trim=true)
* 
* @todo phpDoc
* 
* @param $debut
* @param $fin
* @param $d
* @param $nb valeur par défaut : 1
* @param $trim valeur par défaut : true
* @param $ret_tags si true, on retourne le résultat agrémenté de $debut et $fin
* 
* @return ($out)
* 
*/
function getHtmlVal($debut='',$fin='',$d,$nb=1,$trim=true,$ret_tags=false) {
	if($debut) {
		$tmp = explode($debut,$d);
		unset($tmp[0]);
	} else {
		$tmp = array($d);
	}
	if($nb==1){
		if($debut) {
			$out = implode($debut,$tmp);	
		} else  {
			$out = $tmp[0];
		}
	} else {
		$cpt=1;
		foreach($tmp as $k=>$v){
			if($cpt==$nb){
				$out=$v;
			}
			$cpt++;
		}
	}
	if($fin) {
		list($out) = explode($fin,$out);
	}
	if($ret_tags) {
		$out = $debut.$out.$fin;
	} else {
		if($trim) {
			$out = trim($out);
		}
	}
	return ($out);
}

function spliton($split,$content){
	$list = explode($split,$content);
	if(isset($list[0]) && empty($list[0])) {
		unset($list[0]);
	}
	foreach($list as &$line){
		$line = $split.$line;
	}
	return $list;
}
function array_to_html_attributes($tab, $others=array()) {
	foreach($others as $k=>$v){
		if(isset($tab[$k])){
			$tab[$k].=' '.$v;
		}
	}
	$out = '';
	foreach($tab as $k=>$v){
		$out.=' '.$k.'="'.esc_attr($v).'"';
	}
	return trim($out);
}
function check($var,$proof=false,$default=false,$post=false){
	if(php_sapi_name() == 'cli'){
		global $argv;
		foreach($argv as $argument){
			if($argument == $var){
				return true;
			} else {
				list($k) = explode('=',$argument);
				if($k == $var){
					return substr($argument,strlen($k)+1);
				}
			}
		}
		return false;
	} else {
		$tab = $post ? $_POST : $_GET;
		if(isset($tab[$var])){
			if($proof){
				eval('$ret = '.$proof.'($tab[$var]);');
				return $ret;
			} else {
				return $tab[$var];
			}
		} else {
			if(!$post){
				return check($var,$proof,$default,true);
			} else {
				return $default;
			}
		}
	}
}

function wget($file,$delay=3600){
	if(!is_numeric($delay)){
		$delay = strtotime($delay);
	}
	$tmpfile = SOCIETY_TMP.md5($file);
	$delta = time() - @filemtime($tmpfile);
	if(!file_exists($tmpfile) || ($delta > $delay)){
		$content = file_get_contents($file);
		file_put_contents($tmpfile, $content);
		return $content;
	} else {
		return file_get_contents($tmpfile);
	}
}

function normalize_path($path){
	return str_replace('\\', '/', $path);
}
/**
* sinon
* 
* sinon()
* 
* @todo phpDoc
* 
* @return val
* 
*/
function sinon(){
	$ret=false;
	$args = func_get_args();
	$data = $args[0];
	unset($args[0]);
	$empty=false;
	foreach($args as $k=>$v) {
		if(strstr($v,':')) {
			list($v,$len) = explode(':',$v);
			if($v == 'default'){
				$ret = $len;
				$v = $len;
				$len = false;
			}
			if($v == 'empty'){
				$empty=true;
				$v = $len;
				$len=false;
			}
		} else {
			$len = false;
		}
		if($empty){
			if(is_array($data) && isset($data[$v]) && !empty($data[$v])) {
				return $data[$v];
			}
		} else {
			if(is_array($data) && isset($data[$v]) && $data[$v] !== false) {
				return $len ? couper($data[$v],$len) : $data[$v];
			}
		}
	}
	
	return $ret;
}


/**
* couper
* 
* couper($texte, $taille=50, $suite = ' ...')
* 
* @todo phpDoc
* 
* @param $texte
* @param  $taille valeur par défaut : 50
* @param  $suite  valeur par défaut :  ' ...'
* 
* @return ''
* 
*/
function couper($texte, $taille=50, $suite = ' ...') {
	if (!($length=strlen($texte)) OR $taille <= 0) return '';
	$offset = 400 + 2*$taille;
	while ($offset<$length
		AND strlen(preg_replace(",<[^>]+>,Uims","",substr($texte,0,$offset)))<$taille)
		$offset = 2*$offset;
	if (	$offset<$length
		&& ($p_tag_ouvrant = strpos($texte,'<',$offset))!==NULL){
		$p_tag_fermant = strpos($texte,'>',$offset);
	if ($p_tag_fermant<$p_tag_ouvrant)
			$offset = $p_tag_fermant+1; // prolonger la coupe jusqu'au tag fermant suivant eventuel
	}
	$texte = substr($texte, 0, $offset); /* eviter de travailler sur 10ko pour extraire 150 caracteres */

	// on utilise les \r pour passer entre les gouttes
	$texte = str_replace("\r\n", "\n", $texte);
	$texte = str_replace("\r", "\n", $texte);

	// sauts de ligne et paragraphes
	$texte = preg_replace("/\n\n+/", "\r", $texte);
	$texte = preg_replace("/<(p|br)( [^>]*)?".">/", "\r", $texte);

	// supprimer les traits, lignes etc
	$texte = preg_replace("/(^|\r|\n)(-[-#\*]*|_ )/", "\r", $texte);

	// supprimer les tags
	$texte = strip_tags($texte);
	$texte = trim(str_replace("\n"," ", $texte));
	$texte .= "\n";	// marquer la fin


	// couper au mot precedent
	$long = substr($texte, 0, max($taille-4,1));
	$u = 'u';
	$court = preg_replace("/([^\s][\s]+)[^\s]*\n?$/".$u, "\\1", $long);
	$points = $suite;

	// trop court ? ne pas faire de (...)
	if (strlen($court) < max(0.75 * $taille,2)) {
//		$points = '';
		$long = substr($texte, 0, $taille);
		$texte = preg_replace("/([^\s][\s]+)[^\s]*\n?$/".$u, "\\1", $long);
		// encore trop court ? couper au caractere
		if (strlen($texte) < 0.75 * $taille)
			$texte = $long;
	} else
	$texte = $court;

	if (strpos($texte, "\n"))	// la fin est encore la : c'est qu'on n'a pas de texte de suite
	$points = '';

	// remettre les paragraphes
	$texte = preg_replace("/\r+/", "\n\n", $texte);

	// supprimer l'eventuelle entite finale mal coupee
	$texte = preg_replace('/&#?[a-z0-9]*$/S', '', $texte);

	return quote_amp(trim($texte)).$points;
}

/**
* quote_amp
* 
* quote_amp($u)
* 
* @todo phpDoc
* 
* @param $u
* 
* @return val
* 
*/
function quote_amp($u) {
	return preg_replace(
		"/&(?![a-z]{0,4}\w{2,3};|#x?[0-9a-f]{2,5};)/i",
		"&amp;",$u);
}


	if (!function_exists('http_build_url'))
	{
		define('HTTP_URL_REPLACE', 1);				// Replace every part of the first URL when there's one of the second URL
		define('HTTP_URL_JOIN_PATH', 2);			// Join relative paths
		define('HTTP_URL_JOIN_QUERY', 4);			// Join query strings
		define('HTTP_URL_STRIP_USER', 8);			// Strip any user authentication information
		define('HTTP_URL_STRIP_PASS', 16);			// Strip any password authentication information
		define('HTTP_URL_STRIP_AUTH', 32);			// Strip any authentication information
		define('HTTP_URL_STRIP_PORT', 64);			// Strip explicit port numbers
		define('HTTP_URL_STRIP_PATH', 128);			// Strip complete path
		define('HTTP_URL_STRIP_QUERY', 256);		// Strip query string
		define('HTTP_URL_STRIP_FRAGMENT', 512);		// Strip any fragments (#identifier)
		define('HTTP_URL_STRIP_ALL', 1024);			// Strip anything but scheme and host
		
		// Build an URL
		// The parts of the second URL will be merged into the first according to the flags argument. 
		// 
		// @param	mixed			(Part(s) of) an URL in form of a string or associative array like parse_url() returns
		// @param	mixed			Same as the first argument
		// @param	int				A bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
		// @param	array			If set, it will be filled with the parts of the composed url like parse_url() would return 
		/**
* http_build_url
* 
* http_build_url($url, $parts=array(), $flags=HTTP_URL_REPLACE, &$new_url=false)
* 
* @todo phpDoc
* 
* @param $url
* @param  $parts valeur par défaut : array()
* @param  $flags valeur par défaut : HTTP_URL_REPLACE
* @param  &$new_url valeur par défaut : false
* 
* @return val
* 
*/
function http_build_url($url, $parts=array(), $flags=HTTP_URL_REPLACE, &$new_url=false)
		{
			$keys = array('user','pass','port','path','query','fragment');
			
			// HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
			if ($flags & HTTP_URL_STRIP_ALL)
			{
				$flags |= HTTP_URL_STRIP_USER;
				$flags |= HTTP_URL_STRIP_PASS;
				$flags |= HTTP_URL_STRIP_PORT;
				$flags |= HTTP_URL_STRIP_PATH;
				$flags |= HTTP_URL_STRIP_QUERY;
				$flags |= HTTP_URL_STRIP_FRAGMENT;
			}
			// HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
			else if ($flags & HTTP_URL_STRIP_AUTH)
			{
				$flags |= HTTP_URL_STRIP_USER;
				$flags |= HTTP_URL_STRIP_PASS;
			}
			
			// Parse the original URL
			$parse_url = parse_url($url);
			
			// Scheme and Host are always replaced
			if (isset($parts['scheme']))
				$parse_url['scheme'] = $parts['scheme'];
			if (isset($parts['host']))
				$parse_url['host'] = $parts['host'];
			
			// (If applicable) Replace the original URL with it's new parts
			if ($flags & HTTP_URL_REPLACE)
			{
				foreach ($keys as $key)
				{
					if (isset($parts[$key]))
						$parse_url[$key] = $parts[$key];
				}
			}
			else
			{
				// Join the original URL path with the new path
				if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH))
				{
					if (isset($parse_url['path']))
						$parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
					else
						$parse_url['path'] = $parts['path'];
				}
				
				// Join the original query string with the new query string
				if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY))
				{
					if (isset($parse_url['query']))
						$parse_url['query'] .= '&' . $parts['query'];
					else
						$parse_url['query'] = $parts['query'];
				}
			}
				
			// Strips all the applicable sections of the URL
			// Note: Scheme and Host are never stripped
			foreach ($keys as $key)
			{
				if ($flags & (int)constant('HTTP_URL_STRIP_' . strtoupper($key)))
					unset($parse_url[$key]);
			}
			
			
			$new_url = $parse_url;
			
			return 
				 ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
				.((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') .'@' : '')
				.((isset($parse_url['host'])) ? $parse_url['host'] : '')
				.((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
				.((isset($parse_url['path'])) ? $parse_url['path'] : '')
				.((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
				.((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
			;
		}
	}