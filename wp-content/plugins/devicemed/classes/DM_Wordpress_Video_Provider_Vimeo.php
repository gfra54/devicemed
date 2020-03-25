<?php

class DM_Wordpress_Video_Provider_Vimeo
{
	protected $name = 'Vimeo';
	
	public function parse($string)
	{
		$patterns = array(
			'#(http(s)?://)?(www\.)?vimeo\.com/.*(?P<id>[0-9]++)#Ui'
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
		$api = 'http://vimeo.com/api/v2/video/%s.json';
		$response = file_get_contents(sprintf($api, $id));
		if ($response)
		{
			$json = json_decode($response);
			$thumbnails = array(
				'large' => $json[0]->thumbnail_large,
				'medium' => $json[0]->thumbnail_medium,
				'small' => $json[0]->thumbnail_small
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
		return '//player.vimeo.com/video/'.$id;
	}
}