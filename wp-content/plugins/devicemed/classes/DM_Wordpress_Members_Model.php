<?php

class DM_Wordpress_Members_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_users';
	protected $fields = array(
		'user_login'			=> '',
		'user_password'			=> '',
		'user_nicename'			=> '',
		'user_lastname'			=> '',
		'user_firstname'		=> '',
		'user_email'			=> '',
		'user_sex'				=> 'M',
		'user_address'			=> '',
		'user_city'				=> '',
		'user_postalcode'		=> '',
		'user_country'			=> '',
		'user_lostpassword_key'	=> '',
		'user_confirmation_key'	=> '',
		'user_created'			=> '0',
		'user_modified'			=> '0',
		'user_status'			=> '1'
	);
	public function authenticate($login, $password)
	{
		global $wpdb;
		return (array) $wpdb->get_row($wpdb->prepare(
			'SELECT ID, user_nicename, user_status, %s AS user_group 
			FROM '.$this->table().'
			WHERE user_login = %s AND user_password = %s',
			'users',
			(string) $login,
			(string) $password
		));
	}
	public function session_check($id)
	{
		global $wpdb;
		return (array) $wpdb->get_row($wpdb->prepare(
			'SELECT ID, user_nicename, user_status, %s AS user_group 
			FROM '.$this->table().'
			WHERE ID = %d',
			'users',
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
				"(user_login LIKE '%:search%' OR user_lastname LIKE '%:search%' OR user_firstname LIKE '%:search%' OR user_email = ':search')",
				array(':search' => esc_sql(like_escape($filters['search'])))
			);
		}
		if (isset($filters['user_status']))
		{
			$where[] = sprintf("(user_status = %d)", (int) $filters['user_status']);
		}
		
		$results = $wpdb->get_results(
			'SELECT ID, user_login, user_lastname, user_firstname, user_email, user_nicename, user_status, user_created, user_modified'.
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
	public function admin_list_count_active()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE user_status > 0');
	}
	public function admin_list_count_inactive()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE user_status = 0');
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
			' SET user_status = 1'.
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
			' SET user_status = 0'.
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
	public function check_duplicate_login($login)
	{
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare(
			'SELECT ID'.
			' FROM '.$this->table().
			' WHERE user_login = %s',
			(string) $login
		));
	}
	public function check_duplicate_email($login)
	{
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare(
			'SELECT ID'.
			' FROM '.$this->table().
			' WHERE user_email = %s',
			(string) $login
		));
	}
	public function create_account($fields)
	{
		return $this->save($fields);
	}
	public function check_confirmation_key($key)
	{
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare(
			'SELECT ID'.
			' FROM '.$this->table().
			' WHERE user_confirmation_key = %s',
			(string) $key
		), ARRAY_A);
	}
	public function check_lost_password_key($key)
	{
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare(
			'SELECT ID'.
			' FROM '.$this->table().
			' WHERE user_lostpassword_key = %s',
			(string) $key
		), ARRAY_A);
	}
	public function admin_edit_check_duplicate_login($login)
	{
		global $wpdb;
		return $wpdb->get_row($wpdb->prepare(
			'SELECT ID'.
			' FROM '.$this->table().
			' WHERE user_login = %s',
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