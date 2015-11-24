<?php

class DM_Wordpress_Session
{
	static public function set($key, $value)
	{
		self::__sessionCheck();
		$_SESSION[ $key ] = $value;
	}
	static public function get($key)
	{
		self::__sessionCheck();
		if (isset($_SESSION[ $key ]))
		{
			return $_SESSION[ $key ];
		}
		return NULL;
	}
	static public function clear($key)
	{
		if (isset($_SESSION[ $key ]))
		{
			unset($_SESSION[ $key ]);
		}
	}
	static private function __sessionCheck()
	{
		if ($_SESSION === NULL)
		{
			session_start();
		}
	}
}