<?php

class DM_Wordpress_Suppliers_Videos
{
	static private $providers = array(
		'Youtube',
		'Dailymotion',
		'Vimeo'
	);

	static public function initialize()
	{
		DM_Wordpress_Router::add('/suppliers/videos/add', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/videos/edit/@video_id', array(__CLASS__, 'edit'));
		DM_Wordpress_Router::add('/suppliers/videos/delete/@video_id', array(__CLASS__, 'delete'));
		DM_Wordpress_Router::add('/suppliers/videos/@supplier_id', array(__CLASS__, 'display_videos'));
		
		$wp_upload_dir = wp_upload_dir();
		$upload_directory = $wp_upload_dir['basedir'].'/suppliers/medias/uploads/';
		$upload_url = $baseUrl.'/suppliers/medias/uploads/';
		$medias_directory = $wp_upload_dir['basedir'].'/suppliers/medias/';
		$medias_url = $baseUrl.'/suppliers/medias/';
	}

	static public function edit($params)
	{
		$session = DM_Wordpress_Members::session();
		$video_id = isset($params['video_id']) ? (int) $params['video_id'] : NULL;
		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$suppliers_videos = new DM_Wordpress_Suppliers_Videos_Model();
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();

		if (!$session['ID'])
		{
			wp_redirect(site_url('/members/login'));
			exit;
		}

		if (!$session['user_group'] == 'suppliers')
		{
			wp_redirect(site_url('/403'));
			exit;
		}

		$data = array(
			'ID' => $video_id,
			'supplier_id' => $session['supplier_id'],
			'supplier_user_id' => $session['ID'],
			'supplier_video_title' => '',
			'supplier_video_created' => date('Y-m-d H:i:s'),
			'supplier_video_modified' => date('Y-m-d H:i:s'),
			'supplier_video_status' => 0,
			'supplier_video_content' => '',
			'supplier_video_media' => array()
		);
		$errors = array();

		if ($video_id)
		{
			$results = $suppliers_videos->admin_edit_get_video($video_id);
			if ($session['supplier_id'] != $results['supplier_id'])
			{
				wp_redirect(site_url('/403'));
				exit;
			}

			foreach ($data as $field => $value)
			{
				if (isset($results[ $field ]))
				{
					$data[ $field ] = $results[ $field ];
				}
			}
			
			$results = $suppliers_medias->get_medias_by_related('Video', $video_id);
			foreach ($results as $row)
			{
				$data['supplier_video_media'][] = $row;
			}
		}

		if (!empty($_POST))
		{
			foreach ($data as $field => $value)
			{
				if (isset($_POST[ $field ]))
				{
					if (is_string($_POST[ $field ]))
					{
						$data[ $field ] = trim(stripslashes($_POST[ $field ]));
					}
					else
					{
						$data[ $field ] = $_POST[ $field ];
					}
				}
			}			
			
			if (!$data['supplier_video_title'])
			{
				$errors['supplier_video_title'] = 'Veuillez indiquer le titre de la galerie.';
			}
			if (empty($data['supplier_video_media']))
			{
				if (!$data['supplier_video_content'])
				{
					$errors['supplier_video_content'] = 'Veuillez entrer le code d\'intégration, ou le lien de la vidéo.';
				}
			}
			else if ($data['supplier_video_content'] AND !self::detect_provider_video($data['supplier_video_content']))
			{
				$errors['supplier_video_content'] = 'Contenu exportable ou lien de la vidéo incorrect.';
			}

			if (!$errors)
			{
				if (!$video_id)
				{
					$video_id = $suppliers_videos->save($data);
				}
				else
				{
					$fields = $data;
					$fields['supplier_video_modified'] = date('Y-m-d H:i:s');
					$fields['supplier_user_id'] = $session['ID'];
					$suppliers_videos->save($fields, $video_id);
				}

				if ($video_id)
				{
					if ($data['supplier_video_content'])
					{
						$infos = self::detect_provider_video($data['supplier_video_content']);		
						$suppliers_medias->save(array(
							'supplier_id' => $session['supplier_id'],
							'supplier_user_id' => $session['ID'],
							'supplier_media_related_id' => $video_id,
							'supplier_media_related_type' => 'Video',
							'supplier_media_metas' => serialize(array('filetype' => 'stream') + $infos),
							'supplier_media_created' => date('Y-m-d H:i:s'),
							'supplier_media_modified' => date('Y-m-d H:i:s'),
							'supplier_media_status' => 1
						), !empty($data['supplier_video_media'][0]['ID']) ? $data['supplier_video_media'][0]['ID'] : NULL);
					}
					wp_redirect(site_url('/suppliers/videos/edit/'.$video_id));
				}
			}
		}

		DM_Wordpress::title(array('Fournisseurs', $video_id ? 'Modifier vidéo' : 'Ajouter vidéo'));
		DM_Wordpress_Template::theme('suppliers/video_edit', array(
			'data' => $data,
			'errors' => $errors
		));
	}
	static public function display_videos($params)
	{
		$supplier_id = (int) $params['supplier_id'];
		$supplier = $posts = array();

		$suppliers = new DM_Wordpress_Suppliers_Model();
		if ($supplier = $suppliers->get_supplier($supplier_id))
		{
			if ($supplier['supplier_status'] == 1)
			{
				$suppliers_galleries = new DM_Wordpress_Suppliers_Galleries_Model();
				$galleries = $suppliers_galleries->get_last_galleries_by_supplier_id($supplier['ID'], 10);
				$suppliers_videos = new DM_Wordpress_Suppliers_Videos_Model();
				$videos = $suppliers_videos->get_last_videos_by_supplier_id($supplier['ID'], 10);
				m($videos);
				$session = DM_Wordpress_Members::session();
		
				$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
				$category = $suppliers_categories->get_categories($supplier['supplier_category_id']);
				
				DM_Wordpress::title(array('Toutes les images', esc_html($supplier['supplier_name'])));
			}
		}
		
		DM_Wordpress_Template::theme('suppliers/videos', array(
			'galleries' => $galleries,
			'videos' => $videos,
			'medias' => $medias,
			'supplier' => $supplier,
			'category' => $category,
			'session' => $session
		));
	}
	static public function detect_provider_video($string)
	{
		foreach (self::$providers as $provider)
		{
			if ($results = DM_Wordpress_Video_Provider::factory($provider)->parse($string))
			{
				return $results;
			}
		}
		return array();
	}

	static public function get_medias($video_id)
	{
		$suppliers_medias = new DM_Wordpress_Suppliers_Medias_Model();
		$results = $suppliers_medias->get_medias_by_related('Video', $video_id);
		$arrayResult = array();
		
		$videoTemp = $results[0]['supplier_media_metas'];
		$arrayTempImage = explode(';', $videoTemp);
		
		// On récupére le lien de la vidéo
		$videoTemp = $arrayTempImage[18];
		$posPremierGuillemet = strpos($videoTemp, '"');
		$posDernierGuillemet = strripos($videoTemp, '"');
		$length = $posDernierGuillemet - $posPremierGuillemet;
		$media = substr($videoTemp, ($posPremierGuillemet+1), ($length-1));
		
		// On récupére la miniature de la vidéo
		$miniatureTemp = $arrayTempImage[14];
		$posPremierGuillemetMiniature = strpos($miniatureTemp, '"');
		$posDernierGuillemetMiniature = strripos($miniatureTemp, '"');
		$lengthMiniature = $posDernierGuillemetMiniature - $posPremierGuillemetMiniature;
		$miniature = substr($miniatureTemp, ($posPremierGuillemetMiniature+1), ($lengthMiniature-1));
		
		array_push($arrayResult, $media);
		array_push($arrayResult, $miniature);
		
		return $arrayResult;
	}
	
	static public function get_media_path($video_id, $filename = '')
	{
		return $medias_directory.$video_id.DIRECTORY_SEPARATOR.$filename;
	}

	static public function get_media_thumbnail_path($video_id, $filename = '')
	{
		return $medias_directory.$video_id.DIRECTORY_SEPARATOR.'thumbnail'.DIRECTORY_SEPARATOR.$filename;
	}
}