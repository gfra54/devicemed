<?php

abstract class DM_Wordpress_Metabox extends DM_Wordpress_Singleton
{
	protected $id = '';
	protected $title = '';
	protected $post_type = '';
	protected $context = '';
	protected $priority = '';
	
	public function __construct($id = NULL, $title = NULL, $post_type = NULL, $context = NULL, $priority = NULL)
	{
		$this->id = $id === NULL ? (string) $this->id : (string) $id;
		$this->title = $title === NULL ? (string) $this->title : (string) $title;
		if ($post_type === NULL)
		{
			$this->post_type = (string) $this->post_type;
		}
		elseif (is_object($post_type) AND (is_a($post_type, 'DM_Wordpress_Admin_Menu_Page') OR is_a($post_type, 'DM_Wordpress_Admin_Submenu_Page')))
		{
			$this->post_type = $post_type->hook();
		}
		else
		{
			$this->post_type = (string) $post_type;
		}
		$this->context = $context === NULL ? (string) $this->context : (string) $context;
		$this->priority = $priority === NULL ? (string) $this->priority : (string) $priority;

		add_action('add_meta_boxes_'.$this->post_type, array($this, '__add_meta_boxes_callback'));
		add_action('load-'.$this->post_type, array($this, 'load'));
		add_action('save_'.$this->post_type, array($this, 'save'));
	}
	public function __add_meta_boxes_callback()
	{
		add_meta_box(
			$this->id,
			$this->title,
			array($this, 'render'),
			$this->post_type,
			$this->context,
			$this->priority
		);
	}
	
	public function load() {}
	public function render($data) {}
	public function save($data) {}

	public function id()
	{
		return $this->id;
	}
	public function title()
	{
		return $this->title;
	}
	public function post_type()
	{
		return $this->post_type;
	}
	public function context()
	{
		return $this->context;
	}
	public function priority()
	{
		return $this->priority;
	}
}