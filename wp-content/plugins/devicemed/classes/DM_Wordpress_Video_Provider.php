<?php

class DM_Wordpress_Video_Provider
{
	protected $name;

	static public function factory($provider)
	{
		$class = 'DM_Wordpress_Video_Provider_'.ucfirst(strtolower($provider));
		return new $class;
	}

	public function name()
	{
		return $this->name;
	}

	public function parse($string) {}
	public function thumbnails($id) {}
	public function thumbnail($id, $size = 'medium') {}
	public function player($id) {}
}