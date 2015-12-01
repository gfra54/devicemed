<?php

$GLOBALS['HOME_STYLES'] = array(
	array(
		'id'=>1,
		'color'=>'black',
		'background'=> '#fce0d4'
	),
	array(
		'id'=>2,
		'color'=>'white',
		'background'=> '#323232'
	),
	array(
		'id'=>3,
		'color'=>'black',
		'background'=> '#ffe5b2'
	),
	array(
		'id'=>4,
		'color'=>'black',
		'background'=> '#ffde9b'
	),
	array(
		'id'=>5,
		'color'=>'black',
		'background'=> '#e5e5e5'
	),
	array(
		'id'=>6,
		'color'=>'white',
		'background'=> '#fbb41a'
	),
);

// test


function homeStyles(){
	$out='<style>';
		foreach ($GLOBALS['HOME_STYLES'] as $key => $rules) {
			$out.='.home-style-'.$rules['id'].' .img-mask, .home-style-'.$rules['id'].' .home-header, .home-style-'.$rules['id'].':after{';
				foreach ($rules as $k => $v) {
					if($k != 'id') {
						$out.=$k.': '.$v.';';
					}
				}
			$out.='}';
			$out.='.home-style-'.$rules['id'].' .home-header:before,.home-style-'.$rules['id'].' .home-header:after{';
				foreach ($rules as $k => $v) {
					if($k == 'color') {
						$out.='border-color: '.$v.' !important;';
					}
				}
			$out.='}';

		}
	$out.='</style>';
	echo $out;
}
function homeHeight($home_mode){
	$out='';
	foreach($GLOBALS['HOME_GRID'][$home_mode] as $screen=>$mode_data){
		$h=0;
		foreach($mode_data as $k=>$v){
			if($v['x'] == 1){
				$h+= $v['h'];
			}
		}
		$out.=' '.$screen.'-grid-'.$h;
	}	
	return $out;
}

function getHomeStyle($cpt,$home_mode=false){
	$out=array();
	if($home_mode) {
		foreach($GLOBALS['HOME_GRID'][$home_mode] as $screen=>$mode_data){
			foreach(array('x','y','w','h') as $idx) {
				if(isset($mode_data[$cpt][$idx])) {
					$out[]=($screen != 'default' ? $screen.'-' : '').$idx.'-'.$mode_data[$cpt][$idx];
				} else return false;
			}
			if($mode_data[$cpt]['w']>1){
				$out[]='home-large';
			}
		}
		if($cpt == 0 && $home_mode !='suite'){
			$out[]='home-header-big';
		}
	}
	if(!isset($GLOBALS['HOME_STYLES_TMP']) || count($GLOBALS['HOME_STYLES_TMP'])==0) {
		$GLOBALS['HOME_STYLES_TMP'] = $GLOBALS['HOME_STYLES'];
	}
	if(!isset($GLOBALS['HOME_STYLES_PREC'])){
		$GLOBALS['HOME_STYLES_PREC']=false;
	}
	shuffle($GLOBALS['HOME_STYLES_TMP']);
	$v = $GLOBALS['HOME_STYLES_TMP'][0];
	if($GLOBALS['HOME_STYLES_PREC'] == $v['id']){
		$out[] = getHomeStyle($cpt);
	} else {
		unset($GLOBALS['HOME_STYLES_TMP'][0]);
		$GLOBALS['HOME_STYLES_PREC'] = $v['id'];
		$out[] = ' home-style-'.$v['id'].' ';
	}
	return implode(' ',$out);
}


function excluWeb(){
	global $post;
	if(has_tag( 'EXCLU WEB', $post ) || has_tag( 'WEB ONLY', $post )) {
		return svg('exclu-web');
	}
	if(has_tag( 'BONUS_MAG', $post )) {
		return svg('bonus-mag');
	}
}
