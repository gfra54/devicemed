<?php

class DM_Wordpress_Cookie
{
	static public function set($key, $value)
	{
		$_COOKIE[ $key ] = $value;
	}
	static public function get($key)
	{
		if (isset($_COOKIE[ $key ]))
		{
			return $_COOKIE[ $key ];
		}
		return NULL;
	}
	static public function clear($key)
	{
		if (isset($_COOKIE[ $key ]))
		{
			unset($_COOKIE[ $key ]);
		}
	}
}