<?php

class DM_Wordpress_Admin
{
	static public function js($file, $dependencies = array())
	{
		wp_enqueue_script($file, plugins_url('js/'.$file, dirname(__FILE__)), $dependencies);
	}
	static public function css($file)
	{
		wp_enqueue_style($file, plugins_url('css/'.$file, dirname(__FILE__)));
	}
}