<?php

define('SVG_DIR',ABSPATH.'wp-content/themes/society-magazine/images/svg/');

$GLOBALS['SVG'] = array();
function svg($id,$ret=false){
	ob_start();
	$file = SVG_DIR.$id.'.svg';
	if(!isset($GLOBALS['SVG'][$id])){
		$c = file_get_contents($file);
		if(strstr($c, '<style')!==false){
			?>
			<span class="svg-image-inline svg-<?php echo $id;?>">
			<img src="<?php echo get_bloginfo('template_url').'/images/svg/'.$id;?>.svg">
			</span>
			<?php
		} else {
			$GLOBALS['SVG'][$id] = parseSvg($c);
		}
	}
	?>
	<span class="svg-image svg-<?php echo $id;?>">
	<svg><use xlink:href="#<?php echo $id;?>"></use></svg>
	</span>
	<?php

	$html = ob_get_contents();
	ob_end_clean();	
	if($ret){
		return $html;
	} else {
		echo $html;
	}
}


function svgdefs($all=false){
	if($all){
		$tmp = glob(SVG_DIR.'*.svg');
		foreach($tmp as $file){
			$c = file_get_contents($file);
			list($id) = explode('.',basename($file));
			$GLOBALS['SVG'][$id] = parseSvg($c);
		}
	}
	$out='<svg style="display:none !important"><defs>';
	foreach($GLOBALS['SVG'] as $id => $svg){
		$out.=PHP_EOL.'<!-- '.$id.' -->'.PHP_EOL;
		$out.='<symbol id="'.$id.'"'.toHtmlAttributes($svg,array('svg')).'>';
		$out.=$svg['svg'];
		$out.='</symbol>';
		$out.=PHP_EOL.'<!-- /'.$id.' -->'.PHP_EOL;
	}	
	$out.='<defs><svg>';

	echo $out;
}



function parseSvg($code){
	$out=array();
	list(,$tmp) = explode('<svg',$code);
	$out['svg'] = '<svg'.$tmp;
	$yes = array('preserveaspectratio','viewbox', 'xmlns');
	$xml = simplexml_load_string($out['svg']);
	foreach($xml->attributes() as $k=>$v){
		if(in_array(strtolower($k), $yes)!==false) {
			$out[$k]=(string)$v;
		}
	}

	$out['svg']=strip_tags_specific($out['svg'],'svg');

//		$code = preg_replace('/<!--(.*)-->/Uis', '', trim($svg['svg']));
//		$code = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $code);

	return $out;
}