<?php 

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page([
		'page_title'=>'Blocs',
		'update_button' => 'Enregistrer',
		'icon_url' => 'dashicons-grid-view'
	]);

	acf_add_options_page([
		'page_title'=>'Page d\'accueil',
		'update_button' => 'Enregistrer',
		'icon_url' => 'dashicons-admin-home'
	]);
	
	
}