<?php
class DM_Wordpress_Tag
{
	/**
	 * Initialize section
	 * @return void
	 */
	static public function initialize()
	{
		DM_Wordpress_Router::add('/tag/@tag', array(__CLASS__, 'tag'));
	}
	
	static public function tag($params)
	{
		DM_Wordpress::title(array('DeviceMed.fr'));
		DM_Wordpress_Template::theme('tag/tag', array(
			'tag' => $params[1]
		));
	}
}