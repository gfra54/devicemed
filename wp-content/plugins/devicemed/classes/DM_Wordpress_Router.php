<?php
class DM_Wordpress_Router
{
	static private $routes = array();

	static public function add($pattern, $callback)
	{
		$pattern = preg_replace('#@(\w+)#', '(?P<\1>[^\/]+)', $pattern);
		self::$routes[] = array($pattern, $callback);
	}
	static public function dispatch($uri)
	{
		foreach (self::$routes as $name => $route)
		{
			list($pattern, $callback) = $route;
			if (preg_match("#$pattern#u", $uri, $params))
			{
				if (is_callable($callback))
				{
					call_user_func($callback, $params);
					return TRUE;
				}
			}
		}
		return FALSE;
	}
}