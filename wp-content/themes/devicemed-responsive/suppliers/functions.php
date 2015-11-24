<?php
	try  {
		$bdd = new PDO('mysql:host=devicemedrbdd.mysql.db;dbname=devicemedrbdd;charset=utf8', 'devicemedrbdd', 'BG4Buths6X62');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	
	function string_sanitize_nicename($supplier_name) {
		return str_replace(' - ', '-', preg_replace('/\s+/', ' ',
			mb_convert_case(
				str_replace('-', ' - ', strtolower(trim($supplier_name))
			), MB_CASE_TITLE, 'UTF-8')
		));
	}
	
	if(isset($_GET['pattern']) && $_GET['pattern'] != '') {
		$pattern = $_GET['pattern'];
		
		if($pattern == 'rechercheFournisseur') {
			$q = $_GET['q'];
			
			// On récupére les fournisseurs qui commencent par la variable "q"
			$suppliers_reponse = $bdd->query("SELECT ID, supplier_name FROM wordpress_dm_suppliers WHERE supplier_name LIKE '$q%'");
			$suppliers = '';
			$i = 0;

			// On affiche chaque entrée une à une
			while ($supplier = $suppliers_reponse->fetch())
			{
				$supplier_name = $supplier['supplier_name'];
				
				if($i == 0) {
					$suppliers .= "$supplier_name";
				}else {
					$suppliers .= "|$supplier_name";
				}
				
				$i++;
			}
			
			$suppliers_reponse->closeCursor(); // Termine le traitement de la requête
			
			$suppliers = htmlspecialchars($suppliers);
			echo "$suppliers";
		}elseif($pattern == 'deleteImage') {
			$filename = $_GET['filename'];
			$supplier_id = $_GET['supplier_id'];
			
			// On supprime l'image
			$sql_delete_image = $bdd->query("DELETE FROM wordpress_dm_suppliers_medias WHERE supplier_id='$supplier_id' AND supplier_media_metas LIKE '%$filename%'");
			
			if($sql_delete_image !== FALSE) {
				echo json_encode("true");
			}else {
				echo json_encode("false");
			}
		}
	}
?>