<?
	echo "Votre base est en cours de sauvegarde.......";
	system("mysqldump --host=mysql51-110.perso --user=norismod1 --password=S4JN6FCktSEj norismod1 > norismod1.sql");
	echo "C'est fini. Vous pouvez récupérer la base par FTP";
?>