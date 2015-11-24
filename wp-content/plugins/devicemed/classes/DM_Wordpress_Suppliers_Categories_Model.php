<?php

class DM_Wordpress_Suppliers_Categories_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_suppliers_categories';
	protected $fields = array(
		'supplier_category_title' => ''
	);
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
				"(supplier_category_title LIKE '%:search%')",
				array(':search' => esc_sql(like_escape($filters['search'])))
			);
		}
		
		$results = $wpdb->get_results(
			'SELECT ID, supplier_category_title'.
			' FROM '.$this->table().
			($where ? ' WHERE '.implode(' AND ', $where) : '').
			' ORDER BY '.$orderby.' '.$order.
			' LIMIT '.$offset.', '.$limit
		);

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
	public function admin_edit_get_category($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function get_category($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function admin_edit_update_category($fields, $id)
	{
		return $this->save($fields, $id ? (int) $id : NULL);
	}
	public function admin_get_categories()
	{
		global $wpdb;
		return $wpdb->get_results(
			'SELECT *'.
			' FROM '.$this->table()
		);
	}
	public function get_categories($supplier_category)
	{
		$posVirgule = strpos($supplier_category, ",");
		$supplier_category = substr($supplier_category, 0, $posVirgule);
				
		global $wpdb;
		if($supplier_category != '') {
			return $wpdb->get_results(
				'SELECT *'.
				' FROM '.$this->table().
				' WHERE ID = '. $supplier_category.
				' ORDER BY supplier_category_title ASC'
			, ARRAY_A);
		}else {
			return $wpdb->get_results(
				'SELECT *'.
				' FROM '.$this->table().
				' ORDER BY supplier_category_title ASC'
			, ARRAY_A);
		}
	}
}