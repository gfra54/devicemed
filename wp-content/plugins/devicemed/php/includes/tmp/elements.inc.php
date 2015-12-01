<?php


function cartouche($txt=false){
    if($txt) {
    	tag('span.entry-surtitre',svg('cartouche',true).tag('span.surtitre-text',$txt,true));
    }
}

function p($content='',$params=array()){
    echo tag($tag,$content,$params);
}
function h2($content='',$params=array()){
    echo tag($tag,$content,$params);
}
function tag_espaces($s) {
    if(!strstr($s[1], '[')  && !strstr($s[1], ']')) {
        return str_replace(" ", "_SPACE_", '['.$s[1].']');
    } else {
        return '['.$s[1].']';
    }
}
function tag_open($tag){
   return tag($tag,'',array('open_only'=>true));
}
function tag_close($tag){
   return tag($tag,'',array('close_only'=>true));
}
function tag($tag=false,$content='',$params=array()){
	if($params === true){
		$params = array('return'=>true);
	}
    $noend = array('br','img');
    if(is_object($content)){
        ob_start();
        $content();
        $content = ob_get_contents();
        ob_end_clean();
    }
    if(substr(trim($content),0,11) == 'function(){'){
        $content = substr(substr(trim($content),11),0,-1);
        ob_start();
        eval($content);
        $content = ob_get_contents();
        ob_end_clean();

    }

    $tag = preg_replace_callback("~\[([^\)]*)\]~", 'tag_espaces', $tag);
    $tags = array_map('trim',explode(' ',$tag));
    if(count($tags)>1){
        $tags = array_reverse($tags);
        foreach($tags as $tag){
            $content = tag($tag,$content,$params+array('return'=>true));
        }
        $ret = $content;
    } else {
       if(strstr($tag, '[') && strstr($tag, ']')){
           list($tag,$tmp) = explode('[',$tag);
           list($tmp) = explode(']',$tmp);
           $tmp = explode(';',$tmp);
           $rab = array();
           foreach($tmp as $line){
                list($key) = explode('=',$line);
                $value = substr($line,strlen($key)+1);
                $rab[$key] = str_replace("_SPACE_",' ',$value);
           }
           $params += $rab;
       }

        if(strstr($tag, '.')){
            list($tag,$params['class']) = explode('.',$tag);
            if(!empty($params['class'])){
                $params['class'] = str_replace(',', ' ', str_replace(';', ',', $params['class']));
            }
        }
        if(strstr($tag, '#')){
            list($tag,$params['id']) = explode('#',$tag);
        }
        $ret = empty($params['close_only']) ? '<'.$tag.' '.toHtmlAttributes($params,array('open_only','close_only','return')).'>'.PHP_EOL : '';
        $ret.= $content;
        $ret.= (!in_array($tag, $noend) && empty($params['open_only']) ? PHP_EOL.'</'.$tag.'>' : '').PHP_EOL;
    }

    if(sinon($params,'return')){
        return $ret;
    } else {
        echo $ret;
    }
}
function include_external($file){

//    $delta='?'.(@filemtime(CHEMIN_SITE.$file));
    $delta='?'.$GLOBALS['MAJ_TIME'];
    
    if(strstr($file, '.css')!==false){
        echo '<link href="'.$file.$delta.'" rel="stylesheet">';
    } else {
        echo '<script type="text/javascript" src="'.$file.$delta.'"></script>';
    }
}