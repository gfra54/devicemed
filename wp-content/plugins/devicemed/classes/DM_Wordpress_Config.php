<?php
class DM_Wordpress_Config
{
	static private $data = array();
	
	static public function set($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $sub => $value)
			{
				self::set($sub, $value);
			}
		}
		else
		{
			self::$data[ $key ] = $value;
		}
	}
	static public function get($key)
	{
		if (isset(self::$data[ $key ]))
		{
			return self::$data[ $key ];
		}
		return NULL;
	}
	static public function clear($key = NULL)
	{
		if ($key === NULL)
		{
			self::$data = array();
		}
		else if (isset(self::$data[ $key ]))
		{
			unset(self::$data[ $key ]);
		}
	}
}