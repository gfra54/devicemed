<?php

class DM_Wordpress_Template extends DM_Wordpress_Object
{
	static public function load($file, $variables = array())
	{
		$file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.php';
		if (file_exists($file))
		{
			extract($variables);
			include $file;
		}
	}
	static public function theme($file, $variables = array())
	{
		$file = get_template_directory().DIRECTORY_SEPARATOR.$file.'.php';
		if (file_exists($file))
		{
			extract($variables);
			include $file;
		}
	}
}