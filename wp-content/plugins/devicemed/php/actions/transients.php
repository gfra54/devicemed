<?php function get_transients($key,$strict=false){

		global $wpdb;
		if($strict) {
			$pre='%transient_';
		} else {
			$pre='%transient%';
		}
		$transients = $wpdb->get_results(
			"SELECT option_name AS name FROM $wpdb->options 
			WHERE option_name LIKE '$pre$key%'"
		);
		$out = array();
		foreach($transients as $transient) {
			$out[]=str_replace('_transient_','',$transient->name);
		}
		return $out;
}