<?php
if($categorie = $wp_query->queried_object) {
	$GLOBALS['categorie'] = get_object_vars($categorie);
	$GLOBALS['categorie']['parent'] = get_object_vars(get_term($GLOBALS['categorie']['parent'],'categorie'));
	include 'fournisseurs-liste.php';
}
