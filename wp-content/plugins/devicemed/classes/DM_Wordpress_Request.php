<?php

class DM_Wordpress_Request
{
	static public function get($key, $default = NULL)
	{
		if (isset($_GET[ $key ]))
		{
			return $_GET[ $key ];
		}
		return $default;
	}
	static public function post($key, $default = NULL)
	{
		if (isset($_POST[ $key ]))
		{
			return $_POST[ $key ];
		}
		return $default;
	}
}