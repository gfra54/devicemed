<?php
/**
* videos.inc.php (02/01/2014 09:50:15)
* 
* Fonctions de gestion des vidéos (Gestion des éléments de type sofoot_vidéos ainsi que traitement et récupération de données des vidéos youtube vimeo, etc.)
* @author Gilles FRANCOIS <gilles@sofoot.com>
* @version 1.0
* @copyright 2004-2014 SOFOOT/Gilles FRANCOIS
* @package Videos
*/

$GLOBALS['data_videos'] = array(
	'jeuxvideo' => array(
		'name'=>'jeuxvideo',
		'parse_debut'=> 'Lecteur exportable : <input type="text" value="',
		'parse_fin'=>'&lt;/div&gt;',
		'add'=>'</div>'
	),
	'goal4replay' => array(
		'name'=>'goal4replay',
		'embed' => '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="288" height="214" id="videoEmbed" align="middle"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="wmode" value="transparent" /><param name="scale" value="true" /><param name="movie" value="http://www.goal4replay.net/videoEmbedLa.swf?ID=S%code%&MediaID=1" /><param name="quality" value="high" /><param name="bgcolor" value="#999999" /><embed src="http://www.goal4replay.net/videoEmbedLa.swf?ID=S%code%&MediaID=1" quality="high"  width="288" height="214" name="videoEmbedLa" align="middle" allowScriptAccess="always"  allowFullScreen="true" wmode="transparent" scale="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></embed></object>',
		'debut_code_url'=>'ID=',
		'fin_code_url'=>'&',
		'debut_code_url_object'=>'ID=S',
		'fin_code_url_object'=>'&',
	),
	//do we need this ? <script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>
	'vine' => array(
		'name'=>'vine',
		'embed' => '<iframe class="vine-embed" src="https://vine.co/v/%code%/embed/simple" width="288" height="214" frameborder="0"></iframe>',
		'debut_code_url'=>'/v/',
		'fin_code_url'=>'',
		'player'=>'https://vine.co/v/%code%/embed/simple',
		'direct'=>'http://vine.co/%code%',
	),
	'youtube' => array(
		'name'=>'youtube',
		'embed' => '<iframe title="YouTube video player" autoplay="1" class="youtube-player" type="text/html" width="400" height="400" src="http://www.youtube.com/embed/%code%" divers="?rel=0&amp;hd=1" frameborder="0"></iframe>',
		'debut_code_url'=>'v=',
		'fin_code_url'=>'&',
		'debut_code_url_object'=>'/v/',
		'fin_code_url_object'=>'?',
		'player'=>'http://www.youtube.com/embed/%code%',
		'direct'=>'http://www.youtube.com/v/%code%',
		'meta'=>array(
			'url'=>'http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=%code%&format=json',
			'title'=>'title'
		)
	),
	'youtu.be' => array(
		'name'=>'youtu.be',
		'embed' => '<iframe width="288" height="214" src="http://www.youtube.com/embed/%code%" frameborder="0" allowfullscreen></iframe>',
		'debut_code_url'=>'.be/',
		'fin_code_url'=>'',
		'debut_code_url_object'=>'.be/',
		'fin_code_url_object'=>'',
		'player'=>'http://www.youtube.com/embed/%code%',
		'direct'=>'http://www.youtube.com/v/%code%',
		'meta'=>array(
			'url'=>'http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=%code%&format=json',
			'title'=>'title'
		)
	),
	/*
	'ina' => array(
		'name'=>'ina',
		'embed' => '<iframe title="YouTube video player" autoplay="1" class="youtube-player" type="text/html" width="288" height="214" src="http://www.youtube.com/embed/%code%" divers="?rel=0&amp;hd=1" frameborder="0"></iframe>',
		'debut_code_url'=>'v=',
		'fin_code_url'=>'&',
		'debut_code_url_object'=>'/v/',
		'fin_code_url_object'=>'?',
	),*/
	'rutube' => array(
		'name'=>'rutube',
		'embed' => '<object width="288" height="214"><param name="movie" value="http://video.rutube.ru/%code%"></param><param name="wmode" value="window"></param><param name="allowFullScreen" value="true"></param><embed src="http://video.rutube.ru/%code%" type="application/x-shockwave-flash" wmode="window" width="288" height="214" allowFullScreen="true" ></embed></object>',
		'debut_code_url'=>'v=',
		'fin_code_url'=>'&',
		'debut_code_url_object'=>'video.rutube.ru/',
		'fin_code_url_object'=>'"></param',
	),
	'vimeo' => array(
		'name'=>'vimeo',
		'embed' => '<iframe src="http://player.vimeo.com/video/%code%?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="288" height="214" frameborder="0"></iframe>',
		'debut_code_url'=>'vimeo.com/',
		'fin_code_url'=>'?',
	),
	'dailymotion' => array(
		'name'=>'dailymotion',
		'embed' => '<iframe frameborder="0" width="480" height="270" src="//www.dailymotion.com/embed/video/%code%" allowfullscreen></iframe>',
		'debut_code_url'=>'video/',
		'fin_code_url'=>'_',
		'debut_code_url_object'=>'video/',
		'fin_code_url_object'=>'_',
	),
);

function gestVideo($url,$id=false){
	if(is_array($url)){
		foreach($url as $k=>$v){
			if(!$v['embedcode']){
				$v['embedcode'] = gestVideo($v['urlvideo'],$id);
			}
			$url[$k]=$v;
		}
		return $url;
	}  else 
	if($vid = isVideo($url)) {
		if($id){
			$image = faireUrlImage('sofoot_videos',$id,'path');
			$logo = $GLOBALS['CHEMIN_SITE'].'IMG/sofoot_videos/logo_'.$id.'.'.getExtension($image);
			if(!file_exists($logo)){
				if($image = getIconeVideo($url,$vid)) {
					$logo = $GLOBALS['CHEMIN_SITE'].'IMG/sofoot_videos/logo_'.$id.'.'.getExtension($image);
					if($c = @file_get_contents($image)) {
						@file_put_contents($logo,$c);
					}
				}
			}
		}
		return '<div class="video-wrapper">'.getHtmlCodeVideo($url,$vid).'</div>';
	}
}

/**
* isVideo
* 
* isVideo($url)
* 
* @todo phpDoc
* 
* @param $url
* 
* @return $v
* 
*/
function isVideo($url) {
	foreach($GLOBALS['data_videos'] as $k=>$v){
		if(strstr($url,$k)!==false){
			return $v;
		}
	}
	return false;
}

/**
* getIconeVideo
* 
* getIconeVideo($url,$vid,$parse=true)
* 
* @todo phpDoc
* 
* @param $url
* @param $vid
* @param $parse valeur par défaut : true
* 
* @return "".$ret
* 
*/
function getIconeVideo($url,$vid,$parse=true) {
	$ret=false;
	if($vid['name']=='dailymotion'){
		$xml_url = "http://www.dailymotion.com/api/oembed?url=".urlencode($url)."&format=xml";
        if($xml=@simplexml_load_file($xml_url)) {
			list($ret) = explode('?',$xml->thumbnail_url);

		}
		/*
		$content = file_get_contents($url);
		list(,$ret)=explode('<meta property="og:image" content="',$content);
		list($ret)=explode('"',$ret);
		$ret = str_replace('_medium.','_large.',$ret);
		*/
	} else
	if($vid['name']=='vimeo'){
		$content = file_get_contents($url);
		list(,$ret)=explode('<meta property="og:image" content="',$content);
		list($ret)=explode('"',$ret);
	} else
	if($vid['name']=='youtube'){
		$ret = 'http://i3.ytimg.com/vi/'.($parse ? parseUrlVideo($url) : $url).'/0.jpg';
	} else
	if($vid['name']=='rutube'){
		$code = ($parse ? parseUrlVideo($url) : $url);
		$c1 = substr($code,0,2);
		$c2 = substr($code,2,2);
		$ret = 'http://tub.rutube.ru/thumbs-wide/'.$c1.'/'.$c2.'/'.$code.'-3.jpg';
	}
	
	
	return "".$ret;
}
/**
* parseUrlVideo
* 
* parseUrlVideo($url,$vid=false,$object=false)
* 
* @todo phpDoc
* 
* @param $url
* @param $vid valeur par défaut : false
* @param $object valeur par défaut : false
* 
* @return trim($code)
* 
*/
function parseUrlVideo($url,$vid=false,$object=false) {
	if(!$vid) {
		$vid = isVideo($url);
	}
	if($object){
		$debut = 'debut_code_url_object';
		$fin = 'fin_code_url_object';
	} else {
		$debut = 'debut_code_url';
		$fin = 'fin_code_url';
	}
	list(,$code) = explode($vid[$debut],$url); 
	if($vid[$fin]) {
		list($code) = explode($vid[$fin],$code);
	}
	list($code) = explode('#',$code);

	// m($url.' -> '.$code);

	$ret = trim($code);

	if(!$ret && !$object) {
		return parseUrlVideo($url,$vid,true);
	} else {
		return $ret;
	}
}



/**
* getHtmlCodeVideo
* 
* getHtmlCodeVideo($url,$vid)
* 
* @todo phpDoc
* 
* @param $url
* @param $vid
* 
* @return $html
* 
*/
function getHtmlCodeVideo($url,$vid){
	if(isset($vid['parse_debut'])) {
		datasExist('embedcodevideos');
		if(!isset($GLOBALS["datas"]["embedcodevideos"][$url])) {
			$GLOBALS["datas"]["embedcodevideos"][$url]=file_get_contents($url);
			cacheItems('embedcodevideos',$GLOBALS["datas"]["embedcodevideos"]);
		}

		 $html = html_entity_decode(getHtmlVal($vid['parse_debut'],$vid['parse_fin'],$GLOBALS["datas"]["embedcodevideos"][$url])).$vid['add'];
	} else {
		$code = parseUrlVideo($url,$vid);

		$html=str_replace('%code%',$code,$vid['embed']);

		if(isset($vid['meta'])) {
//			$metaurl=str_replace('%code%',$code,$vid['meta']['url']);
//			$json = json_decode(file_get_contents($metaurl),true);
//			$html=str_replace('%title%',$json[$vid['meta']['title']],$html);
			$html=str_replace('%title%','Youtube',$html); // todo
		}

	}

	return $html;
}


/**
* resizeVideo
* 
* resizeVideo($txt,$w=604,$h=425)
* 
* @todo phpDoc
* 
* @param $txt
* @param $w valeur par défaut : 604
* @param $h valeur par défaut : 425
* 
* @return $out
* 
*/
function resizeVideo($txt,$w=604,$h=425){
	if(strstr($txt,'<iframe')===false && strstr($txt,'<object')===false){
		return $txt;
	}
	$tab = explode('<iframe',$txt);
	$out=$tab[0];
	unset($tab[0]);
	
	foreach($tab as $line){
		list($iframe,$reste) = explode('</iframe>',$line);
		$params = parseHtmlTagAttributes($iframe);
		if($vid = isVideo($params['src'])){
//			$iframe = str_replace('width="','width="'.$w.'" "',$iframe);
//			$iframe = str_replace('height="','height="'.$h.'" "',$iframe);
			$params['width']=$w;
			$params['height']=$h;
			$iframe = HtmlTagAttributesToString($params);
		}
		$out.='<iframe '.$iframe.'</iframe>'.$reste;
	}
	
	$tab = explode('<object',$out);
	$out=$tab[0];
	unset($tab[0]);

	foreach($tab as $line){
		list(,$reste) = explode('</object>',$line);

		list(,$tmp) = explode('<param name="movie" value="',$line);

		list($url) = explode('"',$tmp);
		if($vid = isVideo($url)){
			$code = parseUrlVideo($url,$vid,'object');
			$html=str_replace('%code%',$code,$vid['embed']);
			$html = str_replace('width=','width="'.$w.'" ',$html);
			$html = str_replace('height=','height="'.$h.'" ',$html);
			$out.=$html.$reste;
		} else {
			$html = str_replace('width=','width="'.$w.'" ','<object '.$line);
			$out.= str_replace('height=','height="'.$h.'" ',$html);
		}
	}

	
	return $out;

}

/**
* parseVideoEntry
* 
* parseVideoEntry($url)
* 
* @todo phpDoc
* 
* @param $url
* 
* @return object to caller   
      return $obj
* 
*/
function parseVideoEntry($url) {       
	$code = parseUrlVideo($url);
	$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'. $code; 

    // read feed into SimpleXML object 
    $entry = simplexml_load_file($feedURL); 
	$obj= new stdClass; 
       
      // get nodes in media: namespace for media information 
      $media = $entry->children('http://search.yahoo.com/mrss/'); 
      $obj->title = $media->group->title; 
      $obj->description = $media->group->description; 
       
      // get video player URL 
      $attrs = $media->group->player->attributes(); 
      $obj->watchURL = $attrs['url'];  
       
      // get video thumbnail 
      $attrs = $media->group->thumbnail[0]->attributes(); 
      $obj->thumbnailURL = $attrs['url'];  
             
      // get <yt:duration> node for video length 
      $yt = $media->children('http://gdata.youtube.com/schemas/2007'); 
      $attrs = $yt->duration->attributes(); 
      $obj->length = $attrs['seconds'];  
       
      // get <yt:stats> node for viewer statistics 
      $yt = $entry->children('http://gdata.youtube.com/schemas/2007'); 
      $attrs = $yt->statistics->attributes(); 
      $obj->viewCount = $attrs['viewCount'];  
       
      // get <gd:rating> node for video ratings 
      $gd = $entry->children('http://schemas.google.com/g/2005');  
      if ($gd->rating) {  
        $attrs = $gd->rating->attributes(); 
        $obj->rating = $attrs['average'];  
      } else { 
        $obj->rating = 0;          
      } 
         
      // get <gd:comments> node for video comments 
      $gd = $entry->children('http://schemas.google.com/g/2005'); 
      if ($gd->comments->feedLink) {  
        $attrs = $gd->comments->feedLink->attributes(); 
        $obj->commentsURL = $attrs['href'];  
        $obj->commentsCount = $attrs['countHint'];  
      } 
       
      //Get the author 
      $obj->author = $entry->author->name; 
      $obj->authorURL = $entry->author->uri; 
       
       
      // get feed URL for video responses 
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom'); 
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/ 
      2007#video.responses']");  
      if (count($nodeset) > 0) { 
        $obj->responsesURL = $nodeset[0]['href'];       
      } 
          
      // get feed URL for related videos 
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom'); 
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/ 
      2007#video.related']");  
      if (count($nodeset) > 0) { 
        $obj->relatedURL = $nodeset[0]['href'];       
      } 
     
      // return object to caller   
      return $obj;       
    } 
?>