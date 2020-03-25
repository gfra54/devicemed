<?php

class DM_Wordpress_Banniere_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_banniere';
	protected $table_clic = 'dm_banniere_clic';
	protected $fields = array(
		'nom_banniere' => '',
		'image' => '',
		'lien' => '',
		'date_fin' => '',
		'frequence' => '',
		'affichage' => ''
	);
	public function save($data, $banniere_id = 0)
	{
		global $wpdb;
		$nom_banniere = $data['nom_banniere'];
		$lien = $data['lien'];
		$date_fin = $data['date_fin'];
		$frequence = $data['frequence'];
		$affichage = $data['affichage'];
		
		if(!$_FILES['image']['error']) {
			$dossierBanniere = '../wp-content/uploads/banniere/';
			$fichierBanniere = $_FILES['image']['name'];
			$image = $fichierBanniere;
			
			if(!file_exists($dossierApercu . $fichierApercu)) {
				$resultatBanniere = move_uploaded_file($_FILES['image']['tmp_name'], $dossierBanniere . $fichierBanniere);
			}
		}
			
		if($resultatBanniere  || $banniere_id != 0) {
			if($banniere_id == 0) {
				$sqlSave =  "INSERT INTO ".$this->table()."(nom_banniere, image, lien, date_fin, frequence, affichage)";
				$sqlSave .= " VALUES ('$nom_banniere', '". $image ."', '". $lien ."', '". $date_fin ."', ". $frequence .", ". $affichage .")";
			}else {
				$sqlSave =  "UPDATE ".$this->table()." SET nom_banniere='$nom_banniere', ";
				if($_FILES['image']['error'] == 0) {
					$sqlSave .= " image='". $image ."',  ";
				}
				$sqlSave .= " lien='". $lien ."'" .",  date_fin='". $date_fin ."', frequence=". $frequence .", affichage=". $affichage;
				$sqlSave .= " WHERE ID=$banniere_id";
			}
		
			if($wpdb->query($sqlSave)) {
				return $wpdb->insert_id;
			}else {
				return FALSE;
			}
		}else {
			return FALSE;
		}
	}
	public function get_banniere($banniere_id = '')
	{
		global $wpdb;
		
		return $wpdb->get_results(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID='. $banniere_id
		, ARRAY_A);
	}
	public function get_clic($banniere_id = '')
	{
		global $wpdb;
		
		if($banniere_id != '') {
			$sqlClic = "SELECT count(*) AS nbClic FROM wordpress_dm_banniere_clic WHERE banniere_id=$banniere_id;";

			$arrayTemp = $wpdb->get_results($sqlClic, ARRAY_A);
			$arrayFinal = $arrayTemp[0];
			
			return $arrayFinal;
		}
	}
	public function clic_banniere($banniere_id = '')
	{
		global $wpdb;
		
		if($banniere_id != '') {
			$sqlClic =  "INSERT INTO wordpress_dm_banniere_clic(banniere_id) VALUES($banniere_id)";
		
			if($wpdb->query($sqlClic)) {
				return true;
			}else {
				return FALSE;
			}
		}else {
			return FALSE;
		}
	}
	public function display_banniere($typeAffichage = 0, $idNone, $salon = 'false') 
	{
		global $wpdb;
		
		if($salon == 'false') {
			if($idNone == '') {
				$idNone .= '29';
			}else {
				$idNone .= ',29';
			}
		}
		
		$idNone = str_replace(",,",",", $idNone);
		
		if($typeAffichage != 0) {
			if($idNone != '') {
				$sqlAffichage =  "SELECT * FROM ".$this->table()." WHERE affichage=$typeAffichage AND ID NOT IN($idNone) ORDER BY (RAND() * frequence) DESC LIMIT 0,1";
				// echo "sqlAffichage : ". $sqlAffichage;
			}else {
				$sqlAffichage =  "SELECT * FROM ".$this->table()." WHERE affichage=$typeAffichage ORDER BY (RAND() * frequence) DESC LIMIT 0,1";
			}
			
			return $wpdb->get_results($sqlAffichage , ARRAY_A);
		}else {
			return FALSE;
		}
	}
	public function admin_list($page = 1, $limit = 10, $filters = array())
	{
		global $wpdb;

		$orderby = 'ID';
		$order = 'ASC';
		$where = array();
		$offset = ($page - 1) * $limit;

		if (!empty($filters['orderby']) AND !empty($filters['order']))
		{
			if (isset($this->fields[ $filters['orderby'] ]))
			{
				$orderby = $filters['orderby'];
				$order = $filters['order'] === 'desc' ? 'DESC' : 'ASC';
			}
		}
		if (!empty($filters['search']))
		{
			$where[] = strtr(
				"(lien LIKE '%:search%')",
				array(':search' => esc_sql(like_escape($filters['search'])))
			);
		}
		// if (isset($filters['supplier_status']))
		// {
			// $where[] = sprintf("(supplier_status = %d)", (int) $filters['supplier_status']);
		// }
		
		$results = $wpdb->get_results(strtr(
			'SELECT :table.ID, :table.nom_banniere, :table.image, :table.lien, :table.date_fin, :table.frequence, :table.affichage'.
			' FROM '.$this->table().
			// ' LEFT JOIN :table_category ON :table.supplier_category_id = :table_category.ID'.
			($where ? ' WHERE '.implode(' AND ', $where) : '').
			' ORDER BY '.$orderby.' '.$order.
			' LIMIT '.$offset.', '.$limit,
			array(
				':table' => $this->table()
			)
		));

		$count = $wpdb->get_var(
			'SELECT COUNT(*)'.
			' FROM '.$this->table().
			($where ? ' WHERE '.implode(' AND ', $where) : '')
		);
		
		return array(
			'results' => $results,
			'count' => $count,
			'pages' => ceil($count / $limit)
		);
	}
	public function admin_edit_get_banniere($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function admin_list_count_all()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table());
	}
	public function admin_list_bulk_delete($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'DELETE FROM '.$this->table().
			' WHERE ID IN ('.implode(', ', $where).')'
		);
	}
}