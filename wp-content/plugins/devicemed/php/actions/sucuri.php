<?php

if(WP_ENV == 'prod') {
	// whitelist de l'ip de la personne connectée
	add_action('wp_login', function() {
		$url = 'https://waf.sucuri.net/api?v2';
		
		$ip = get_the_user_ip();

		$params = [
			'k' => 'a1691d9eb844117a444359abb20b72ee',
			's' => '8ce3581bca2880c3bd31354222325762',
			'a' => 'whitelist_ip',
			'ip' => $ip,
			'duration' => 86400,
		];
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

		$output = curl_exec($ch); 
		curl_close($ch);      

	});
}