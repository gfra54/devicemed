<?php
abstract class DM_Wordpress_Model
{
	protected $table = '';
	protected $fields = array();

	public function table()
	{
		global $wpdb;
		return $wpdb->prefix.$this->table;
	}
	public function save(array $fields, $id = NULL)
	{
		if ($id === NULL)
		{
			return $this->insert($fields);
		}
		else
		{
			return $this->update($fields, $id);
		}
	}
	public function insert(array $fields)
	{
		global $wpdb;
		
		$fields = array_intersect_key($fields + $this->fields, $this->fields);

		if ($wpdb->insert($this->table(), $fields))
		{
			return $wpdb->insert_id;
		}
		return FALSE;
	}
	public function update(array $fields, $id)
	{
		global $wpdb;

		$fields = array_intersect_key($fields, $this->fields);

		return $wpdb->update($this->table(), $fields, array('ID' => (int) $id));
	}
	public function delete($id)
	{
		global $wpdb;
		return $wpdb->delete($this->table(), array('ID' => (int) $id));
	}
}