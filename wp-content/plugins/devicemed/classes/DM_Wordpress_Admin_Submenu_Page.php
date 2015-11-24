<?php

abstract class DM_Wordpress_Admin_Submenu_Page extends DM_Wordpress_Singleton
{
	protected $parent_slug = '';
	protected $page_title = '';
	protected $menu_title = '';
	protected $capability = '';
	protected $menu_slug = '';
	
	protected $hook;

	public function __construct($parent_slug = NULL, $page_title = NULL, $menu_title = NULL, $capability = NULL, $menu_slug = NULL)
	{
		if ($parent_slug === NULL)
		{
			$this->parent_slug = (string) $this->parent_slug;
		}
		elseif (is_object($parent_slug) AND is_a($parent_slug, 'DM_Wordpress_Admin_Menu_Page'))
		{
			$this->parent_slug = $parent_slug->menu_slug();
		}
		else
		{
			$this->parent_slug = (string) $parent_slug;
		}
		$this->page_title = $page_title === NULL ? (string) $this->page_title : (string) $page_title;
		$this->menu_title = $menu_title === NULL ? (string) $this->menu_title : (string) $menu_title;
		$this->capability = $capability === NULL ? (string) $this->capability : (string) $capability;
		$this->menu_slug = $menu_slug === NULL ? (string) $this->menu_slug : (string) $menu_slug;
		
		add_action('admin_menu', array($this, '__admin_menu_callback'));
	}
	public function __admin_menu_callback()
	{
		$this->hook = add_submenu_page(
			$this->parent_slug,
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->menu_slug,
			array($this, 'render')
		);
		add_action('load-'.$this->hook, array($this, '__load_callback'));
		add_action('admin_footer-'.$this->hook, array($this, 'scripts'));
		add_action('save_'.$this->hook, array($this, 'save'));
	}
	public function __load_callback()
	{
		$this->load();
		do_action('add_meta_boxes_'.$this->hook());
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
	public function parent_slug()
	{
		return (string) $this->parent_slug;
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
	public function hook()
	{
		return (string) $this->hook;
	}
}