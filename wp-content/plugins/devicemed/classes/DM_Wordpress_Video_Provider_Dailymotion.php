<?php

class DM_Wordpress_Video_Provider_Dailymotion
{
	protected $name = 'Dailymotion';
	
	public function parse($string)
	{
		$patterns = array(
			'#(http(s)?://)?dai\.ly/(?P<id>\w+)#i',
			'#(http(s)?://)?(www\.)?dailymotion\.com/video/(?P<id>[^_]+)#i',
			'#(www\.)?dailymotion\.com/embed/video/(?P<id>\w+)#i'
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
		$api = 'https://api.dailymotion.com/video/%s?fields=thumbnail_large_url,thumbnail_medium_url,thumbnail_small_url';
		$response = file_get_contents(sprintf($api, $id));
		if ($response)
		{
			$json = json_decode($response);
			$thumbnails = array(
				'large' => $json->thumbnail_large_url,
				'medium' => $json->thumbnail_medium_url,
				'small' => $json->thumbnail_small_url
			);
			return $thumbnails;
		}
		return array();
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
		return '//www.dailymotion.com/embed/video/'.$id;
	}
}