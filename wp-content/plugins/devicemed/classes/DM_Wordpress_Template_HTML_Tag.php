<?php

class DM_Wordpress_Template_HTML_Tag
{
	protected $tag = '';
	protected $attributes = array();
	protected $content = '';

	static public function factory($tag, $content = NULL)
	{
		return new DM_Wordpress_Template_HTML_Tag($tag, $content);
	}
	public function __construct($tag, $content = NULL)
	{
		$this->tag = (string) $tag;
		$this->content($content);
	}
	public function content($content = NULL)
	{
		$this->content = (string) $content;
		return $this;
	}
	public function attribute($attribute = NULL, $value = NULL)
	{
		if ($attribute !== NULL)
		{
			$attribute = strtolower($attribute);
			if ($value !== NULL)
			{
				if (is_array($value))
				{
					$value = implode(' ', $value);
				}
				$this->attributes[ $attribute ] = esc_attr((string) $value);
			}
		}
		return $this;
	}
	public function render()
	{
		$attributes = array();
		foreach ($this->attributes as $attribute => $value)
		{
			$attributes[] = $attribute.'='.$value;
		}
		return strtr('<:tag:attributes>:content</:tag>', array(
			':tag' => $this->tag,
			':attributes' => $this->attributes ? ' '.implode(' ', $attributes) : '',
			':content' => $this->content
		));
	}
	public function __call($name, $arguments)
	{
		return $this->attribute($name, $arguments + array(NULL));
	}
	public function __toString()
	{
		return $this->render();
	}
}