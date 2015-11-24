<?php

class DM_Wordpress_Suppliers_Medias_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_suppliers_medias';
	protected $fields = array(
		'supplier_id'						=> 0,
		'supplier_user_id'					=> 0,
		'supplier_media_related_id'			=> 0,
		'supplier_media_related_type'		=> '',
		'supplier_media_metas'				=> '',
		'supplier_media_created'			=> '',
		'supplier_media_modified'			=> '',
		'supplier_media_status'				=> 0
	);

	public function get_media($media_id)
	{
		global $wpdb;
		return $wpdb->get_row(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = '.((int) $media_id)
		, ARRAY_A);
	}

	public function get_medias_by_related($related_type, $related_id, $gallery_admin = NULL)
	{
		global $wpdb;
		
		if(!$gallery_admin) {
			$sqlMediaByRelated = 'SELECT * FROM '.$this->table().' WHERE supplier_media_related_type = \''.esc_sql((string) $related_type).'\' AND supplier_media_related_id = '.((int) $related_id);
			$results = $wpdb->get_results($sqlMediaByRelated, ARRAY_A);
		}else {
			$sqlMediaByRelated = 'SELECT * FROM '.$this->table().' WHERE supplier_media_related_type = \''.esc_sql((string) $related_type).'\' AND ID = '.((int) $related_id);
			$results = $wpdb->get_results($sqlMediaByRelated, ARRAY_A);
		}
		return $results;
	}

	public function get_featured_media_by_related($related_type, $related_id, $gallery_admin = NULL)
	{
		if(!$gallery_admin) {
			$results = $this->get_medias_by_related($related_type, $related_id);
			$arrayResult = array();
			
			if($related_type == 'Video') {
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
			}else {
				$imagePost = $results[0]['supplier_media_metas'];
				$arrayTempImage = explode(';', $imagePost);
				$imagePost = $arrayTempImage[1];
				$posPremierGuillemet = strpos($imagePost, '"');
				$posDernierGuillemet = strripos($imagePost, '"');
				$length = $posDernierGuillemet - $posPremierGuillemet;
				$media = substr($imagePost, ($posPremierGuillemet+1), ($length-1));
				
				return $media;
			}
		}else {
			$results = $this->get_medias_by_related($related_type, $related_id, 'gallery_admin');
			$arrayResult = array();

			$imagePost = $results[0]['supplier_media_metas'];
			$arrayTempImage = explode(';', $imagePost);
			$imagePost = $arrayTempImage[1];
			$posPremierGuillemet = strpos($imagePost, '"');
			$posDernierGuillemet = strripos($imagePost, '"');
			$length = $posDernierGuillemet - $posPremierGuillemet;
			$media = substr($imagePost, ($posPremierGuillemet+1), ($length-1));
			
			return $media;
		}
	}
	
	public function save($arraySave, $idMedia) {
		global $wpdb;
		
		$supplier_id = $arraySave['supplier_id'];
		$supplier_user_id = $arraySave['supplier_user_id'];
		$supplier_media_related_id = $arraySave['supplier_media_related_id'];
		$supplier_media_related_type = $arraySave['supplier_media_related_type'];
		$supplier_media_metas = $arraySave['supplier_media_metas'];
		$supplier_media_created = $arraySave['supplier_media_created'];
		$supplier_media_modified = $arraySave['supplier_media_modified'];
		$supplier_media_status = $arraySave['supplier_media_status'];

		if(!$idMedia) {
			$sqlSave =  "INSERT INTO ".$this->table()."(supplier_id, supplier_user_id, supplier_media_related_id, supplier_media_related_type,supplier_media_metas,supplier_media_created, supplier_media_modified, supplier_media_status)";
			$sqlSave .= " VALUES ($supplier_id, $supplier_user_id, $supplier_media_related_id, '$supplier_media_related_type', '$supplier_media_metas', '$supplier_media_created', '$supplier_media_modified', $supplier_media_status)";
		}else {
			$sqlSave =  "UPDATE ".$this->table();
			$sqlSave .= " SET supplier_id=$supplier_id, supplier_user_id=$supplier_user_id, supplier_media_related_type='$supplier_media_related_type', supplier_media_metas='$supplier_media_metas', supplier_media_created='$supplier_media_created', supplier_media_modified='$supplier_media_modified', supplier_media_status=$supplier_media_status";
			$sqlSave .= " WHERE supplier_media_related_id=$supplier_media_related_id";
		}
		
		return $wpdb->query($sqlSave);
	}
}