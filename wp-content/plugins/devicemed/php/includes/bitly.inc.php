<?php

define('BITLY_API','9e2e1b854350b95abe574561d875ce919da8f888');
define('BITLY_URL','https://api-ssl.bitly.com/v3/');
function bitly_shorten($url) {
	if($data = bitly_get('shorten',array('longUrl'=>$url))) {
		return empty($data['data']['url']) ? $url : $data['data']['url'];
	}
}
function is_bitly($url) {
	return strstr($url, 'bit.ly')!==false;
}

function bitly_get($w,$params=array()) {
	$url = BITLY_URL.$w.'?access_token='.BITLY_API;
	foreach($params as $k=>$v) {
		$url.='&'.$k.'='.urlencode($v);
	}
	if($ret = file_get_contents($url)){
		$ret = json_decode($ret,true);
		// if($ret['status_txt'] != 'OK'){
		// 	m($ret);
		// }
		return $ret;
	}
}

