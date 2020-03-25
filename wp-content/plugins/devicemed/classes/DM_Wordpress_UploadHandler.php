<?php
if (!class_exists('UploadHandler'))
{
	require_once implode(DIRECTORY_SEPARATOR, array(dirname(dirname(__FILE__)), 'js', 'jquery.file-upload', 'server', 'php', 'UploadHandler.php'));
}
class DM_Wordpress_UploadHandler extends UploadHandler
{
	public function __construct($options = null, $initialize = true, $error_messages = null)
	{
		foreach ($_FILES as $field => $keys)
		{
			foreach ($keys['name'] as $k => $v)
			{
				$pathinfo = pathinfo($v);
				$_FILES[ $field ]['name'][ $k ] =
					sanitize_title($pathinfo['filename'])
					.($pathinfo['extension'] ? '.'.$pathinfo['extension'] : '');
			}
		}
		return parent::__construct($options, $initialize, $error_messages);
	}
}