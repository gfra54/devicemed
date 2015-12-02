<?php
	mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die ("<font color=red>Erreur à la connexion</font>");
	mysql_select_db (DB_NAME) or die("<font color=red>Erreur à la sélection de la base</font>");
	
	$sqlUpdateNewsletterEnvoyee = "UPDATE wordpress_dm_newsletter_test SET nl_envoyee='0'";
	$resultUpdateNewsletterEnvoyee = mysql_query($sqlUpdateNewsletterEnvoyee);
	
	$sqlUpdateNewsletterEnvoyee2 = "UPDATE wordpress_dm_newsletter SET nl_envoyee='0'";
	$resultUpdateNewsletterEnvoyee2 = mysql_query($sqlUpdateNewsletterEnvoyee2);
	
	if($resultUpdateNewsletterEnvoyee!==FALSE && $resultUpdateNewsletterEnvoyee2!==FALSE) {
		echo "Done ! ";
	}
?>