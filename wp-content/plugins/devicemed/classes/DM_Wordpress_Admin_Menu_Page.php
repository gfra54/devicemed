<?php

abstract class DM_Wordpress_Admin_Menu_Page extends DM_Wordpress_Singleton
{
	protected $page_title = '';
	protected $menu_title = '';
	protected $capability = '';
	protected $menu_slug = '';
	protected $icon_url = '';
	protected $position = NULL;
	
	protected $hook;

	public function __construct($page_title = NULL, $menu_title = NULL, $capability = NULL, $menu_slug = NULL, $icon_url = NULL, $position = NULL)
	{
		$this->page_title = $page_title === NULL ? (string) $this->page_title : (string) $page_title;
		$this->menu_title = $menu_title === NULL ? (string) $this->menu_title : (string) $menu_title;
		$this->capability = $capability === NULL ? (string) $this->capability : (string) $capability;
		$this->menu_slug = $menu_slug === NULL ? (string) $this->menu_slug : (string) $menu_slug;
		$this->icon_url = $icon_url === NULL ? (string) $this->icon_url : (string) $icon_url;
		$this->position = $position === NULL ? $this->position : (string) $position;
		
		add_action('admin_menu', array($this, '__admin_menu_callback'));
	}
	public function __admin_menu_callback()
	{
		$this->hook = add_menu_page(
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->menu_slug,
			array($this, 'render'),
			$this->icon_url,
			$this->position
		);
		echo $this->position;
		add_action('load-'.$this->hook, array($this, 'load'));
		add_action('admin_footer-'.$this->hook, array($this, 'scripts'));
		add_action('save_'.$this->hook, array($this, 'save'));
	}
	public function load() {}
	public function render() {}
	public function scripts() {}
	public function save() {}
	
	public function url($parameters = array())
	{
		$url = '?page='.$this->menu_slug;
		foreach ($parameters as $key => $value)
		{
			$url.= sprintf('&%s=%s', $key, $value);
		}
		return $url;
	}
	public function page_title()
	{
		return (string) $this->page_title;
	}
	public function menu_title()
	{
		return (string) $this->menu_title;
	}
	public function capability()
	{
		return (string) $this->capability;
	}
	public function menu_slug()
	{
		return (string) $this->menu_slug;
	}
	public function icon_url()
	{
		return (string) $this->icon_url;
	}
	public function position()
	{
		return (int) $this->position;
	}
	public function hook()
	{
		return (string) $this->hook;
	}
}