<?php
require_once("../../../../wp-load.php");

if(isset($_GET['w'])) {
	$w = sanitize_title(basename($_GET['w']));
	$file = DEVICEMED_PLUGIN_DIR.'/php/actions/get/'.$w.'.php';

	if(file_exists($file)) {
		$json = array('etat'=>false);
		include $file;
		if($json) {
			header('Content-Type: application/json');
			echo json_encode($json);
		}
	}
}