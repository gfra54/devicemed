<?php

class DM_Wordpress_Suppliers_Users_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_suppliers_users';
	protected $fields = array(
		'supplier_id'						=> 0,
		'supplier_user_login'				=> '',
		'supplier_user_password'			=> '',
		'supplier_user_nicename'			=> '',
		'supplier_user_lastname'			=> '',
		'supplier_user_firstname'			=> '',
		'supplier_user_email'				=> '',
		'supplier_user_sex'					=> 'M',
		'supplier_user_address'				=> '',
		'supplier_user_city'				=> '',
		'supplier_user_postalcode'			=> '',
		'supplier_user_country'				=> '',
		'supplier_user_lostpassword_key'	=> '',
		'supplier_user_created'				=> '0',
		'supplier_user_modified'			=> '0',
		'supplier_user_status'				=> '1'
	);
	public function authenticate($login, $password)
	{
		global $wpdb;
		return (array) $wpdb->get_row($wpdb->prepare(
			'SELECT ID, supplier_user_nicename AS user_nicename, supplier_user_status AS user_status, supplier_id, %s AS user_group 
			FROM '.$this->table().'
			WHERE supplier_user_login = %s AND supplier_user_password = %s',
			'suppliers',
			(string) $login,
			(string) $password
		));
	}
	public function session_check($id)
	{
		global $wpdb;
		return (array) $wpdb->get_row($wpdb->prepare(
			'SELECT ID, supplier_user_nicename AS user_nicename, supplier_user_status AS user_status, supplier_id, %s AS user_group
			FROM '.$this->table().'
			WHERE ID = %d',
			'suppliers',
			(int) $id
		));
	}
	public function admin_list($page = 1, $limit = 10, $filters = array())
	{
		global $wpdb;

		$orderby = 'ID';
		$order = 'ASC';
		$where = array();
		$offset = ($page - 1) * $limit;

		$suppliers = new DM_Wordpress_Suppliers_Model();

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
				"(:table.supplier_user_login LIKE '%:search%' OR :table.supplier_user_lastname LIKE '%:search%' OR :table.supplier_user_firstname LIKE '%:search%' OR :table.supplier_user_email = ':search' OR :table_suppliers.supplier_name LIKE '%:search%')",
				array(
					':search' => esc_sql(like_escape($filters['search'])),
					':table' => $this->table(),
					':table_suppliers' => $suppliers->table()
				)
			);
		}
		if (isset($filters['supplier_user_status']))
		{
			$where[] = sprintf("(supplier_user_status = %d)", (int) $filters['supplier_user_status']);
		}
		
		$results = $wpdb->get_results(strtr(
			'SELECT :table.ID, :table.supplier_id, :table_suppliers.supplier_name, :table.supplier_user_login, :table.supplier_user_lastname, :table.supplier_user_firstname, :table.supplier_user_email, :table.supplier_user_nicename, :table.supplier_user_status, :table.supplier_user_created, :table.supplier_user_modified'.
			' FROM '.$this->table().
			' LEFT JOIN :table_suppliers ON :table_suppliers.ID = :table.supplier_id'.
			($where ? ' WHERE '.implode(' AND ', $where) : '').
			' ORDER BY '.$orderby.' '.$order.
			' LIMIT '.$offset.', '.$limit,
			array(
				':table' => $this->table(),
				':table_suppliers' => $suppliers->table()
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
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_user_status > 0');
	}
	public function admin_list_count_inactive()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_user_status = 0');
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
	public function admin_edit_get_profile($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function get_profile($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function admin_edit_check_duplicate_login($login)
	{
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare(
			'SELECT ID'.
			' FROM '.$this->table().
			' WHERE supplier_user_login = %s',
			(string) $login
		));
	}
	public function admin_edit_update_profile($fields, $id)
	{
		return $this->save($fields, $id ? (int) $id : NULL);
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