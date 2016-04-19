<?php function get_transients($key){

		global $wpdb;
		$transients = $wpdb->get_results(
			"SELECT option_name AS name FROM $wpdb->options 
			WHERE option_name LIKE '%transient%$key%'"
		);
		$out = array();
		foreach($transients as $transient) {
			$out[]=str_replace('_transient_','',$transient->name);
		}
		return $out;
}