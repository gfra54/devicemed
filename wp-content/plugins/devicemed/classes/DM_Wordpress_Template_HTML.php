<?php

class DM_Wordpress_Template_HTML
{
	static public function tag($tag, $content = NULL)
	{
		return DM_Wordpress_Template_HTML_Tag::factory($tag, $content);
	}
}