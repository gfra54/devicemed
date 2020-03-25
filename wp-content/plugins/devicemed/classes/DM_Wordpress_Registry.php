<?php
class DM_Wordpress_Registry
{
	static private $data = array();
	
	static public function set($key, $value)
	{
		self::$data[ $key ] = $value;
	}
	static public function get($key)
	{
		if (isset(self::$data[ $key ]))
		{
			return self::$data[ $key ];
		}
	}
	static public function clear($key)
	{
		if (isset(self::$data[ $key ]))
		{
			unset(self::$data[ $key ]);
		}
	}
}