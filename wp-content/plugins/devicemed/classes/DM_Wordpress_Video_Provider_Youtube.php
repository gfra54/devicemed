<?php

class DM_Wordpress_Video_Provider_Youtube
{
	protected $name = 'Youtube';
	
	public function parse($string)
	{
		$patterns = array(
			'#(http(s)?://)?(www\.)?youtube\.com/watch\?v=(?P<id>\w+)#i',
			'#(http(s)?://)youtu\.be/(?P<id>\w+)#i',
			'#(www\.)?youtube\.com/embed/(?P<id>\w+)#i'
		);
		foreach ($patterns as $pattern)
		{
			if (preg_match($pattern, $string, $matches))
			{
				$id = $matches['id'];
				$width = $height = 0;
				if (preg_match('/width=["]?(?P<width>[0-9]+)["]?/i', $string, $m))
				{
					$width = (int) $m['width'];
				}
				if (preg_match('/height=["]?(?P<height>[0-9]+)["]?/i', $string, $m))
				{
					$height = (int) $m['height'];
				}
				return array(
					'provider' => $this->name,
					'id' => $id,
					'width' => $width,
					'height' => $height,
					'thumbnails' => $this->thumbnails($id),
					'player' => $this->player($id)
				);
			}
		}
		return array();
	}

	public function thumbnails($id)
	{
		$thumbnails = array(
			'large' => '//i1.ytimg.com/vi/'.$id.'/hqdefault.jpg',
			'medium' => '//i1.ytimg.com/vi/'.$id.'/mqdefault.jpg',
			'small' => '//i1.ytimg.com/vi/'.$id.'/default.jpg'
		);
		return $thumbnails;
	}

	public function thumbnail($id, $size = 'medium')
	{
		$thumbnails = $this->thumbnails($id);
		if (!empty($thumbnails[ $size ]))
		{
			return $thumbnails[ $size ];
		}
		return '';
	}

	public function player($id)
	{
		return '//www.youtube.com/embed/'.$id;
	}
}