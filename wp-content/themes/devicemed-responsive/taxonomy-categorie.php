<?php
if($categorie = $wp_query->queried_object) {
	$GLOBALS['categorie'] = $categorie->slug;
	include 'fournisseurs.php';
}
