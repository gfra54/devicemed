<?php

class DM_Wordpress
{
	static private $title = array();

	static public function initialize()
	{
		spl_autoload_register(array(__CLASS__, 'autoload'));
		add_filter('wp_title', array(__CLASS__, 'wp_filter_title'), 10, 3);
		add_action('parse_request', array(__CLASS__, 'wp_action_parse_request'));
	}
	static public function autoload($class)
	{
		$file = dirname(__FILE__).DIRECTORY_SEPARATOR.$class.'.php';
		if (file_exists($file))
		{
			require_once $file;
		}
	}
	static public function template($file, $variables = array())
	{
		$file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.php';
		if (file_exists($file))
		{
			extract($variables);
			include $file;
		}
	}
	static public function title($title = NULL, $separator = NULL, $separatorLocation = NULL)
	{
		if ($title !== NULL)
		{
			if (is_array($title))
			{
				self::$title = $title;
			}
			else
			{
				self::$title = array((string) $title);
			}
		}
		else
		{
			return wp_title($separator, FALSE, $separatorLocation);
		}
	}
	static public function wp_action_parse_request()
	{
		global $wp;
		if (DM_Wordpress_Router::dispatch('/'.$wp->request))
		{
			exit(1);
		}
	}
	static public function wp_filter_title($title, $separator, $separatorLocation)
	{
		if (self::$title) {
			if ('right' === $separatorLocation)
			{
				return sprintf('%s %s %s',
					implode($separator, array_reverse(self::$title)),
					$separator,
					$title ? sprintf('%s %s', $separator, $title) : ''
				);

			}
			else
			{
				return sprintf('%s %s %s',
					$title ? sprintf('%s %s', $title, $separator) : '',
					implode($separator, self::$title),
					$separator
				);
			}
		}
		return $title;
	}
}