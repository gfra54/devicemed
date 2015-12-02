<?php	
	mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	mysql_select_db (DB_NAME);

	if(isset($_GET['banniere_id']) && $_GET['banniere_id'] != '') {
		$banniere_id = $_GET['banniere_id'];
		
		$sqlClic =  "INSERT INTO wordpress_dm_banniere_clic(banniere_id) VALUES($banniere_id)";
		$resultClic = mysql_query($sqlClic);
		
		if($resultClic !== FALSE) {
			echo "true";
		}else {
			echo "false";
		}
	}else {
		echo "false";
	}
?>