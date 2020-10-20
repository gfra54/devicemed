<?php

add_action( 'init', function() {
	if($_GET['export-abonne']) {
		$magazine = new DM_Wordpress_Magazine_Model();
		$magazine->extractBddAbos();
	}
});