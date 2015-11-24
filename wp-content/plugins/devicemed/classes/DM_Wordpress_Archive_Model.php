<?php

class DM_Wordpress_Archive_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_archives';
	protected $fields = array(
		'titre_archive' => '',
		'apercu_archive' => '',
		'pdf_archive' => ''
	);
	public function save($data, $archive_id = 0)
	{
		global $wpdb;
		$titre_archive = $data['titre_archive'];
		
		if(!$_FILES['apercu_archive']['error']) {
			$dossierApercu = '../wp-content/uploads/archives/apercu/';
			$fichierApercu = $_FILES['apercu_archive']['name'];
			$apercu_archive = $fichierApercu;
			
			if(!file_exists($dossierApercu . $fichierApercu)) {
				move_uploaded_file($_FILES['apercu_archive']['tmp_name'], $dossierApercu . $fichierApercu);
			}
		}
		
		if(!$_FILES['pdf_archive']['error']) {
			$dossierPdf = '../wp-content/uploads/archives/pdf/';
			$fichierPdf = $_FILES['pdf_archive']['name'];
			$pdf_archive = $fichierPdf;

			if(!file_exists($dossierPdf . $fichierPdf)) {
				move_uploaded_file($_FILES['pdf_archive']['tmp_name'], $dossierPdf . $fichierPdf);
			}
		}
		
		if($archive_id == 0) {
			$sqlSave =  "INSERT INTO ".$this->table()."(titre_archive, apercu_archive, pdf_archive, date_publication, date_modified)";
			$sqlSave .= " VALUES ('$titre_archive', '". $apercu_archive ."', '". $pdf_archive ."', '". $data['date_publication'] ."', '". $data['date_modified'] ."')";
		}else {
			$sqlSave =  "UPDATE ".$this->table()." SET titre_archive='$titre_archive', ";
			if($_FILES['apercu_archive']) {
				$sqlSave .= " apercu_archive='". $apercu_archive ."',  ";
			}
			if($_FILES['pdf_archive']) {
				$sqlSave .= " pdf_archive='". $pdf_archive ."',  ";
			}
			$sqlSave .= " date_publication='". $data['date_publication'] ."'" .",  date_modified='". $data['date_modified'] ."'";
			$sqlSave .= " WHERE ID=$archive_id";
		}
		
		if($wpdb->query($sqlSave)) {
			return $wpdb->insert_id;
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
				"(titre_archive LIKE '%:search%')",
				array(':search' => esc_sql(like_escape($filters['search'])))
			);
		}
		// if (isset($filters['supplier_status']))
		// {
			// $where[] = sprintf("(supplier_status = %d)", (int) $filters['supplier_status']);
		// }
		
		$results = $wpdb->get_results(strtr(
			'SELECT :table.ID, :table.titre_archive, :table.apercu_archive, :table.pdf_archive, :table.date_publication, :table.date_modified'.
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
	public function admin_list_count_all()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table());
	}
	public function admin_list_count_active()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_status > 0');
	}
	public function admin_list_count_inactive()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_status = 0');
	}
	public function admin_list_bulk_enable($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'UPDATE '.$this->table().
			' SET supplier_status = 1'.
			' WHERE ID IN ('.implode(', ', $where).')'
		);
	}
	public function admin_list_bulk_disable($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'UPDATE '.$this->table().
			' SET supplier_status = 0'.
			' WHERE ID IN ('.implode(', ', $where).')'
		);
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
	public function admin_edit_get_archive($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function admin_edit_get_admin($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function admin_edit_update_archive($fields, $id)
	{
		return $this->save($fields, $id ? (int) $id : NULL);
	}
	public function admin_get_suppliers()
	{
		global $wpdb;
		return $wpdb->get_results(
			'SELECT ID, supplier_name'.
			' FROM '.$this->table()
		);
	}
	public function get_archives($limit = '')
	{
		global $wpdb;
		
		if($limit == '') {
			return $wpdb->get_results(
				'SELECT *'.
				' FROM '.$this->table().
				' ORDER BY ID DESC'
			, ARRAY_A);
		}else {
			return $wpdb->get_results(
				'SELECT *'.
				' FROM '.$this->table().
				' ORDER BY ID DESC LIMIT 0, '. $limit
			, ARRAY_A);
		}
	}
	public function get_suppliers_by_category_id($category_id)
	{
		global $wpdb;
		return $wpdb->get_results(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE supplier_category_id = '.((int) $category_id).' AND supplier_status = 1'
		, ARRAY_A);
	}
}