<?php

abstract class DM_Wordpress_Singleton extends DM_Wordpress_Object
{
	static private $_instances = array();

	static public function instance()
	{
		$args = func_get_args();
		$class = get_called_class();
		if (!isset(self::$_instances[ $class ]))
		{
			$reflector = new ReflectionClass($class);
			self::$_instances[ $class ] = $reflector->newInstanceArgs($args);
		}
		return self::$_instances[ $class ];
	}
}