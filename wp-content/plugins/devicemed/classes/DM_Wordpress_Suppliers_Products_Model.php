<?php

class DM_Wordpress_Suppliers_Products_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_suppliers_products';
	protected $fields = array(
		'supplier_id'						=> 0,
		'supplier_user_id'					=> 0,
		'supplier_product_title'				=> '',
		'supplier_product_content'				=> '',
		'supplier_product_created'				=> '',
		'supplier_product_modified'			=> '',
		'supplier_product_status'				=> '0'
	);
    
	public function admin_list($page = 1, $limit = 10, $filters = array())
	{
		global $wpdb;

		$orderby = 'ID';
		$order = 'ASC';
		$where = array();
		$offset = ($page - 1) * $limit;

		$suppliers = new DM_Wordpress_Suppliers_Model();
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();

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
				"(:table.supplier_product_title LIKE '%:search%' OR :table_suppliers.supplier_name LIKE '%:search%' OR :table_suppliers_users.supplier_user_nicename LIKE '%:search%')",
				array(
					':search' => esc_sql(like_escape($filters['search'])),
					':table' => $this->table(),
					':table_suppliers_users' => $suppliers_users->table(),
					':table_suppliers' => $suppliers->table()
				)
			);
		}
        
		if (isset($filters['supplier_product_status']))
		{
			$where[] = sprintf("(supplier_product_status = %d)", (int) $filters['supplier_product_status']);
		}
		
		$results = $wpdb->get_results(strtr(
			'SELECT
            :table.ID,
            :table.supplier_id,
            :table.supplier_user_id,
            :table.supplier_product_title,
            :table.supplier_product_created,
            :table.supplier_product_modified,
            :table.supplier_product_status,
            :table_suppliers_users.supplier_user_nicename,
            :table_suppliers.supplier_name'.
			' FROM :table'.
			' LEFT JOIN :table_suppliers_users ON :table_suppliers_users.ID = :table.supplier_user_id'.
			' LEFT JOIN :table_suppliers ON :table_suppliers.ID = :table.supplier_id'.
			($where ? ' WHERE '.implode(' AND ', $where) : '').
			' ORDER BY '.$orderby.' '.$order.
			' LIMIT '.$offset.', '.$limit,
			array(
				':table' => $this->table(),
				':table_suppliers_users' => $suppliers_users->table(),
				':table_suppliers' => $suppliers->table(),
			)
		));

		$count = $wpdb->get_var(strtr(
			'SELECT COUNT(*)'.
			' FROM :table'.
			' LEFT JOIN :table_suppliers_users ON :table_suppliers_users.ID = :table.supplier_user_id'.
			' LEFT JOIN :table_suppliers ON :table_suppliers.ID = :table.supplier_id'.
			($where ? ' WHERE '.implode(' AND ', $where) : ''),
			array(
				':table' => $this->table(),
				':table_suppliers_users' => $suppliers_users->table(),
				':table_suppliers' => $suppliers->table(),
			)
		));
		
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
    
	public function admin_list_count_pendings()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_product_status = 2');
	}
    
	public function admin_list_count_drafts()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_product_status = 0');
	}
    
	public function admin_list_count_published()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_product_status = 1');
	}
	public function admin_list_bulk_publish($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'UPDATE '.$this->table().
			' SET supplier_product_status = 1'.
			' WHERE ID IN ('.implode(', ', $where).')'
		);
	}
	public function admin_list_bulk_draft($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'UPDATE '.$this->table().
			' SET supplier_product_status = 0'.
			' WHERE ID IN ('.implode(', ', $where).')'
		);
	}
	public function admin_list_bulk_pending($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'UPDATE '.$this->table().
			' SET supplier_product_status = 2'.
			' WHERE ID IN ('.implode(', ', $where).')'
		);
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
			' SET supplier_user_status = 1'.
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
			' SET supplier_user_status = 0'.
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

	public function get_product($product_id)
	{
		global $wpdb;
		return $wpdb->get_results(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = '.$product_id
		, ARRAY_A);
	}
    
	public function admin_edit_get_product($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
    
	public function admin_edit_update_product($fields, $id)
	{
		return $this->save($fields, $id ? (int) $id : NULL);
	}

	public function get_last_products_by_supplier_id($supplier_id, $limit = 3)
	{
		global $wpdb;
		if($limit != '') {
			return $wpdb->get_results(
				'SELECT *'.
				' FROM '.$this->table().
				' WHERE supplier_product_status = 1 AND supplier_id='.$supplier_id.
				' ORDER BY ID DESC LIMIT 0, '.((int) $limit)
			, ARRAY_A);
		}else {
			return $wpdb->get_results(
				'SELECT *'.
				' FROM '.$this->table().
				' WHERE supplier_product_status = 1 AND supplier_id='.$supplier_id.
				' ORDER BY ID DESC'
			, ARRAY_A);
		}
	}
    
	public function string_sanitize_nicename($string)
	{
		return str_replace(' - ', '-', preg_replace('/\s+/', ' ',
			mb_convert_case(
				str_replace('-', ' - ', strtolower(trim($string))
			), MB_CASE_TITLE, 'UTF-8')
		));
	}
}