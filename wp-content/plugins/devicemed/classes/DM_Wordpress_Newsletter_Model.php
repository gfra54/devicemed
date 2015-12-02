<?php

class DM_Wordpress_Newsletter_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_newsletter';
	protected $fields = array(
		'mail_newsletter' => '',
		'offre_devicemed' => 0,
		'offre_partenaires' => 0,
		'code_temporaire' => '',
		'nom' => '',
		'prenom' => '',
		'ville' => '',
		'cp' => 0,
		'actif' => 0
	);
	public function get_mail_newsletter() {
		global $wpdb;

		$sqlNewsletter = 'SELECT :table.ID, :table.mail_newsletter'.
		' FROM '.$this->table();

		return $wpdb->get_results(strtr($sqlNewsletter,
			array(
				':table' => $this->table()
			)
		));
	}
	
	public function mailDesinscriptionExiste($mail) {
		global $wpdb;

		$sqlNewsletter = 'SELECT :table.ID, :table.mail_newsletter'.
		' FROM '.$this->table() .' WHERE mail_newsletter=\''. $mail .'\'';
		
		$arrayResult = $wpdb->get_results(strtr($sqlNewsletter,
			array(
				':table' => $this->table()
			)
		));
		
		return count($arrayResult);
	}
	
	public function desinscrire($data) {
		global $wpdb;
		$mail_newsletter = $data['mail'];

		$sqlDelete =  "DELETE FROM ".$this->table()." WHERE mail_newsletter='$mail_newsletter'";

		if($wpdb->query($sqlDelete)) {
			return true;
		}else {
			return false;
		}
	}
	
	public function save($data)
	{
		global $wpdb;
		$mail_newsletter = $data['mail_newsletter'];
		$offre_devicemed = $data['offre_devicemed'];
		$offre_partenaires = $data['offre_partenaires'];
	
		// Generate verification code
		$chrs2 = 30;
		$list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

		mt_srand((double)microtime()*1000000);
		$code_temporaire="";
		
		while( strlen( $code_temporaire )< $chrs2 ) {
			$code_temporaire .= $list[mt_rand(0, strlen($list)-1)];
		}

		$sqlSave =  "INSERT INTO ".$this->table()."(mail_newsletter, offre_devicemed, offre_partenaires, code_temporaire)";
		$sqlSave .= " VALUES ('$mail_newsletter',$offre_devicemed, $offre_partenaires, '$code_temporaire')";

		if($wpdb->query($sqlSave)) {
			$to      = $mail_newsletter;
			$subject = 'Validation de votre abonnement à la newsletter de DeviceMed';
			$message = 'Bonjour,<br /><br />Vous venez de vous abonner à la newsletter du site www.devicemed.fr et nous vous en remercions. Veuillez cliquer sur le lien suivant (ou le copier dans votre navigateur), afin de finaliser votre abonnement : http://www.devicemed.fr/newsletter/informations/'. $code_temporaire .'<br /><br />Cordialement<br />L\'équipe de DeviceMed';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= "From: \"DeviceMed France\"<info@devicemed.fr>";

			if(mail($to, $subject, $message, $headers)) {
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
	public function save_admin($data, $inscrits_id = '')
	{
		global $wpdb;
		
		$mail_newsletter = $data['mail_newsletter'];
		$offre_devicemed = $data['offre_devicemed'];
		$offre_partenaires = $data['offre_partenaires'];
		$nom = $data['nom'];
		$prenom = $data['prenom'];
		$ville = $data['ville'];
		$cp = $data['cp'];
		$actif = $data['actif'];
		
		if($inscrits_id == '') {
			$sqlSave =  "INSERT INTO ".$this->table()."(mail_newsletter, offre_devicemed, offre_partenaires, nom, prenom, ville, cp, actif)";
			$sqlSave .= " VALUES ('$mail_newsletter',$offre_devicemed, $offre_partenaires,'$nom','$prenom','$ville',$cp,$actif)";
		}else {
			$sqlSave =  "UPDATE ".$this->table()." SET mail_newsletter='$mail_newsletter', offre_devicemed=$offre_devicemed, offre_partenaires=$offre_partenaires, actif=$actif, nom='$nom', prenom='$prenom', ville = '$ville', cp=$cp";
			$sqlSave .= " WHERE ID=$inscrits_id";
		}
		
		return $wpdb->query($sqlSave);
	}
	public function update($data, $code_temporaire)
	{
		global $wpdb;
		$nom_newsletter = $data['nom_newsletter'];
		$prenom_newsletter = $data['prenom_newsletter'];
		$ville_newsletter = $data['ville_newsletter'];
		$cp_newsletter = $data['cp_newsletter'];

		$sqlSave =  "UPDATE ".$this->table()." SET code_temporaire='', actif=1, nom='$nom_newsletter', prenom='$prenom_newsletter', ville = '$ville_newsletter', cp=$cp_newsletter";
		$sqlSave .= " WHERE code_temporaire='$code_temporaire'";
		
		if($wpdb->query($sqlSave)) {	
			return true;
		}else {
			return false;
		}
	}
	public function verifmail($email) {
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE mail_newsletter = "'. $email .'"'
		), ARRAY_A);
	}
	public function getLastPostsNewsletter() {
		global $wpdb;
		$sqlPosts = "SELECT * FROM `wordpress_posts` WHERE post_type='post' AND post_status='publish' ORDER BY post_date DESC LIMIT 0,8";
		
		return $wpdb->get_results($wpdb->prepare($sqlPosts), ARRAY_A);
	}
	public function getThumbnailNewsletter($post_id) {
		if (has_post_thumbnail($post_id)) {
			$idThumbnailPost = get_post_thumbnail_id($post_id);
			$thumbnail = get_post($idThumbnailPost);
			$thumbnail = $thumbnail->guid;

			return $thumbnail;
		}else {
			return false;
		}
	}
	public function verifCodeTemporaire($code) {
		global $wpdb;
		$sqlCodeTemporaire = 'SELECT * FROM '.$this->table().' WHERE code_temporaire = "'. $code .'"';

		return $wpdb->get_row($wpdb->prepare($sqlCodeTemporaire), ARRAY_A);
	}
	public function admin_list($page = 1, $limit = 10, $filters = array())
	{
		global $wpdb;

		$orderby = 'ID';
		$order = 'ASC';
		$where = array();
		$offset = ($page - 1) * $limit;

		if (!empty($filters['orderby']) AND !empty($filters['order']))
		{
			if (isset($this->fields[ $filters['orderby'] ]))
			{
				$orderby = $filters['orderby'];
				$order = $filters['order'] === 'desc' ? 'DESC' : 'ASC';
			}
		}
		if (!empty($filters['search']))
		{
			$where[] = strtr(
				"(mail_newsletter LIKE '%:search%' OR nom LIKE '%:search%' OR prenom LIKE '%:search%')",
				array(':search' => esc_sql(like_escape($filters['search'])))
			);
		}
		// if (isset($filters['supplier_status']))
		// {
			// $where[] = sprintf("(supplier_status = %d)", (int) $filters['supplier_status']);
		// }
		
		$results = $wpdb->get_results(strtr(
			'SELECT :table.ID, :table.mail_newsletter, :table.offre_devicemed, :table.offre_partenaires, :table.nom, :table.prenom, :table.ville, :table.cp, :table.actif'.
			' FROM '.$this->table().
			// ' LEFT JOIN :table_category ON :table.supplier_category_id = :table_category.ID'.
			($where ? ' WHERE '.implode(' AND ', $where) : '').
			' ORDER BY '.$orderby.' '.$order.
			' LIMIT '.$offset.', '.$limit,
			array(
				':table' => $this->table()
			)
		));

		$count = $wpdb->get_var(
			'SELECT COUNT(*)'.
			' FROM '.$this->table().
			($where ? ' WHERE '.implode(' AND ', $where) : '')
		);
		
		return array(
			'results' => $results,
			'count' => $count,
			'pages' => ceil($count / $limit)
		);
	}
	public function admin_list_count_all()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table());
	}
	public function admin_list_count_active()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_status > 0');
	}
	public function admin_list_count_inactive()
	{
		global $wpdb;
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_status = 0');
	}
	public function admin_list_bulk_enable($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'UPDATE '.$this->table().
			' SET supplier_status = 1'.
			' WHERE ID IN ('.implode(', ', $where).')'
		);
	}
	public function admin_list_bulk_disable($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'UPDATE '.$this->table().
			' SET supplier_status = 0'.
			' WHERE ID IN ('.implode(', ', $where).')'
		);
	}
	public function admin_list_bulk_delete($ids = array())
	{
		global $wpdb;
		
		$where = array();
		foreach ($ids as $id)
		{
			$where[] = (int) $id;
		}
		
		return $wpdb->query(
			'DELETE FROM '.$this->table().
			' WHERE ID IN ('.implode(', ', $where).')'
		);
	}
	public function admin_edit_get_newsletter($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function admin_edit_get_admin($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function admin_edit_update_archive($fields, $id)
	{
		return $this->save($fields, $id ? (int) $id : NULL);
	}
	public function admin_get_suppliers()
	{
		global $wpdb;
		return $wpdb->get_results(
			'SELECT ID, supplier_name'.
			' FROM '.$this->table()
		);
	}
	public function get_archives($limit = '')
	{
		global $wpdb;
		
		if($limit == '') {
			return $wpdb->get_results(
				'SELECT *'.
				' FROM '.$this->table().
				' ORDER BY ID DESC'
			, ARRAY_A);
		}else {
			return $wpdb->get_results(
				'SELECT *'.
				' FROM '.$this->table().
				' ORDER BY ID DESC LIMIT 0, '. $limit
			, ARRAY_A);
		}
	}
	public function get_suppliers_by_category_id($category_id)
	{
		global $wpdb;
		return $wpdb->get_results(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE supplier_category_id = '.((int) $category_id).' AND supplier_status = 1'
		, ARRAY_A);
	}
	
	public function extractBdd() {
		// configuration de la base de données base de données
		$host = DB_HOST;
		$user = DB_USER;
		$pass = DB_PASS;
		$db = DB_NAME;
		$nom_fichier = 'newsletter_'. date('Y-m-d H:i') .'.csv';

		//format du CSV
		$csv_terminated = "\n";
		$csv_separator = ";";
		$csv_enclosed = '"';
		$csv_escaped = "\\";

		// requête MySQL
		$sql_query = "SELECT * FROM wordpress_dm_newsletter";

		// connexion à la base de données
		$link = mysql_connect($host, $user, $pass) or die("Je ne peux me connecter." . mysql_error());
		mysql_select_db($db) or die("Je ne peux me connecter.");

		// exécute la commande
		$result = mysql_query($sql_query);
		$fields_cnt = mysql_num_fields($result);

		$schema_insert = '';

		for ($i = 0; $i < $fields_cnt; $i++)
		{
			$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
		stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
			$schema_insert .= $l;
			$schema_insert .= $csv_separator;
		} // fin for

		$out = trim(substr($schema_insert, 0, -1));
		$out .= $csv_terminated;

		// Format des données
		while ($row = mysql_fetch_array($result))
		{
			$schema_insert = '';
			for ($j = 0; $j < $fields_cnt; $j++)
			{
		if ($row[$j] == '0' || $row[$j] != '')
		{

			if ($csv_enclosed == '')
			{
		$schema_insert .= $row[$j];
			} else
			{
		$schema_insert .= $csv_enclosed .
			str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
			}
		} else
		{
			$schema_insert .= '';
		}

		if ($j < $fields_cnt - 1)
		{
			$schema_insert .= $csv_separator;
		}
			} // fin for

			$out .= $schema_insert;
			$out .= $csv_terminated;
		} // fin while

		// Envoie au fureteur pour le téléchargement
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Length: " . strlen($out));
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=" . $nom_fichier);
		echo $out;
		exit;
	}
}