<?php
	mysql_connect('devicemedrbdd.mysql.db','devicemedrbdd','BG4Buths6X62') or die ("<font color=red>Erreur à la connexion</font>");
	mysql_select_db ("devicemedrbdd") or die("<font color=red>Erreur à la sélection de la base</font>");
	
	$sqlUpdateNewsletterEnvoyee = "UPDATE wordpress_dm_newsletter_test SET nl_envoyee='0'";
	$resultUpdateNewsletterEnvoyee = mysql_query($sqlUpdateNewsletterEnvoyee);
	
	$sqlUpdateNewsletterEnvoyee2 = "UPDATE wordpress_dm_newsletter SET nl_envoyee='0'";
	$resultUpdateNewsletterEnvoyee2 = mysql_query($sqlUpdateNewsletterEnvoyee2);
	
	if($resultUpdateNewsletterEnvoyee!==FALSE && $resultUpdateNewsletterEnvoyee2!==FALSE) {
		echo "Done ! ";
	}
?>