<?php

class DM_Wordpress_Suppliers_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_suppliers';
	protected $fields = array(
		'supplier_category_id' => 0,
		'supplier_name' => '',
		'supplier_address' => '',
		'supplier_postalcode' => '',
		'supplier_telephone' => '',
		'supplier_city' => '',
		'supplier_country' => '',
		'supplier_website' => '',
		'supplier_social_blog' => '',
		'supplier_social_facebook' => '',
		'supplier_social_twitter' => '',
		'supplier_social_youtube' => '',
		'supplier_social_google_plus' => '',
		'supplier_social_linkedin' => '',
		'supplier_about' => '',
		'supplier_created' => '0',
		'supplier_modified' => '0',
		'supplier_status' => '0',
		'supplier_premium' => 0,
		'supplier_contact_nom' => '',
		'supplier_contact_tel' => '',
		'supplier_contact_mail' => '',
		'supplier_events' => '',
		'souhait_contact' => 0,
		'supplier_valide' => 0
	);
	
	public function save($data, $supplier_id)
	{
		global $wpdb;
		$nomSociete = $data['nom_societe'];
		$adresse = $data['adresse'];
		$codePostal = $data['code_postal'];
		$ville = $data['ville'];
		$pays = $data['pays'];
		$telephone = $data['telephone'];
		$siteWeb = $data['site_web'];
		$contact_fiche_complete = $data['contact_fiche_complete'];
		
		// On récupére les catégories cochés
		$i = 0;
		
		$categories = $data['supplier_category_id'];

		$nom = $data['nom'];
		$prenom = $data['prenom'];
		$email = $data['email'];
		$dateHeureActuelle = date('Y-m-d H:i:s');

		// Personne à contacter
		$supplierContactNom = addslashes($data['supplier_contact_nom']);
		$supplierContactTel = addslashes($data['supplier_contact_tel']);
		$supplierContactMail = addslashes($data['supplier_contact_mail']);
		$supplierEvents = addslashes($data['supplier_events']);
		
		if($contact_fiche_complete != '') {
			$souhait_contact = 1;
		}else {
			$souhait_contact = 0;
		}
	
		// Generate verification code
		$chrs2 = 30;
		$list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

		mt_srand((double)microtime()*1000000);
		$codeTemp="";
		
		while( strlen( $codeTemp )< $chrs2 ) {
			$codeTemp .= $list[mt_rand(0, strlen($list)-1)];
		}
		
		if($supplier_id != '') {
			$nomSociete = addslashes($data['supplier_name']);
			$adresse = addslashes($data['supplier_address']);
			$codePostal = addslashes($data['supplier_postalcode']);
			$ville = addslashes($data['supplier_city']);
			$pays = addslashes($data['supplier_country']);
			$siteWeb = addslashes($data['supplier_website']);
			$supplierStatus = addslashes($data['supplier_status']);
			$supplierBlog = addslashes($data['supplier_social_blog']);
			$supplierFb = addslashes($data['supplier_social_facebook']);
			$supplierTw = addslashes($data['supplier_social_twitter']);
			$supplierYt = addslashes($data['supplier_social_youtube']);
			$supplierGplus = addslashes($data['supplier_social_google_plus']);
			$supplierLd = addslashes($data['supplier_social_linkedin']);
			$supplierAbout = addslashes($data['supplier_about']);

			// Personne à contacter
			$supplierContactNom = addslashes($data['supplier_contact_nom']);
			$supplierContactTel = addslashes($data['supplier_contact_tel']);
			$supplierContactMail = addslashes($data['supplier_contact_mail']);
			$supplierEvents = addslashes($data['supplier_events']);

			$supplierPremium = $data['supplier_premium'];
			
			// On vérifie si l'utilisateur est déjà validé ou non
			$sqlSupplierValide = "SELECT supplier_valide FROM wordpress_dm_suppliers WHERE ID=$supplier_id";
			$resultSupplierValide = mysql_query($sqlSupplierValide);
			
			if($rowSupplierValide = mysql_fetch_array($resultSupplierValide)) {
				$supplierStatusTemp = $rowSupplierValide['supplier_valide'];
			}
			
			if($supplierStatus == 1 && $supplierStatusTemp == 0) {
				$sqlSave = "UPDATE wordpress_dm_suppliers SET souhait_contact=$souhait_contact, supplier_events='$supplierEvents', supplier_contact_nom='$supplierContactNom', supplier_contact_tel='$supplierContactTel', supplier_contact_mail='$supplierContactMail', supplier_category_id='$categories', supplier_social_blog='$supplierBlog', supplier_social_facebook='$supplierFb', supplier_social_twitter='$supplierTw', supplier_social_youtube='$supplierYt', supplier_social_google_plus='$supplierGplus', supplier_social_linkedin='$supplierLd', supplier_about='$supplierAbout', supplier_premium='$supplierPremium', supplier_name='$nomSociete', supplier_address='$adresse', supplier_postalcode='$codePostal', supplier_city='$ville', supplier_country='$pays', supplier_website='$siteWeb', supplier_modified='$dateHeureActuelle', supplier_status='$supplierStatus', supplier_valide=1 WHERE ID = $supplier_id";
				$this->envoiMailValidationSupplier($supplier_id);
			}else {
				$sqlSave = "UPDATE wordpress_dm_suppliers SET souhait_contact=$souhait_contact, supplier_events='$supplierEvents', supplier_contact_nom='$supplierContactNom', supplier_contact_tel='$supplierContactTel', supplier_contact_mail='$supplierContactMail', supplier_category_id='$categories', supplier_social_blog='$supplierBlog', supplier_social_facebook='$supplierFb', supplier_social_twitter='$supplierTw', supplier_social_youtube='$supplierYt', supplier_social_google_plus='$supplierGplus', supplier_social_linkedin='$supplierLd', supplier_about='$supplierAbout', supplier_premium='$supplierPremium', supplier_name='$nomSociete', supplier_address='$adresse', supplier_postalcode='$codePostal', supplier_city='$ville', supplier_country='$pays', supplier_website='$siteWeb', supplier_modified='$dateHeureActuelle', supplier_status='$supplierStatus' WHERE ID = $supplier_id";
			}
			
			if($wpdb->query($sqlSave)) {
				$motPasse = md5(md5($data['password']).DM_Wordpress_Config::get('Security.Password.Salt'));
				$sqlSave2 =  "UPDATE wordpress_dm_suppliers_users SET supplier_user_status=$supplierStatus WHERE supplier_id=$supplier_id";
				// echo "sqlSave2 : $sqlSave2";exit();
				
				if($wpdb->query($sqlSave2)) {
					return true;
				}else {
					return false;
				}
			}else {
				return false;
			}
		}else {
			$sqlSave =  "INSERT INTO wordpress_dm_suppliers(souhait_contact, supplier_events, supplier_category_id, supplier_name, supplier_address, supplier_postalcode, supplier_city, supplier_country, supplier_telephone, supplier_website, supplier_created, supplier_modified, supplier_status, supplier_contact_nom, supplier_contact_tel, supplier_contact_mail)";
			$sqlSave .= " VALUES ($souhait_contact, '$supplierEvents','$categories','$nomSociete','$adresse','$codePostal','$ville','$pays','$telephone','$siteWeb', '$dateHeureActuelle', '$dateHeureActuelle', 0, '$supplierContactNom','$supplierContactTel', '$supplierContactMail')";

			if($wpdb->query($sqlSave)) {
				$supplierId = mysql_insert_id();
			
				$motPasse = md5(md5($data['password']).DM_Wordpress_Config::get('Security.Password.Salt'));
				$sqlSave2 =  "INSERT INTO wordpress_dm_suppliers_users(supplier_user_password, supplier_id, supplier_user_login, supplier_user_nicename, supplier_user_lastname, supplier_user_firstname, supplier_user_email, supplier_user_address, supplier_user_city, supplier_user_country, supplier_user_lostpassword_key, supplier_user_created, supplier_user_modified)";
				$sqlSave2 .= " VALUES ('$motPasse', $supplierId,'$email','$prenom $nom','$nom','$prenom','$email','$adresse','$ville', '$pays', '$codeTemp', '$dateHeureActuelle', '$dateHeureActuelle')";
				
				if($wpdb->query($sqlSave2)) {
					$to      = $email;
					$subject = 'Inscription au répertoire des fournisseurs de DeviceMed';
					$subject = mb_encode_mimeheader($subject, "UTF-8");
					$message = 'Bonjour et merci de l\'intérêt que vous portez au répertoire des fournisseurs de DeviceMed France.<br /><br />Veuillez cliquer sur le lien suivant (ou le coller dans votre navigateur) pour confirmer votre demande d\'inscription gratuite : <a href=\'http://www.devicemed.fr/validation/'. $codeTemp .'\'>http://www.devicemed.fr/validation/'. $codeTemp .'</a><br /><br />Attention, l\'inscription  ne sera effective qu\'après vérification et validation par nos soins.<br /><br />Bien cordialement,<br />L\'équipe de DeviceMed France';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					$headers .= "From: \"DeviceMed France\"<info@devicemed.fr>";
					
					$to2      = "laurence.jaffeux@devicemed.fr";
					// $to2 = "salvatore.eric@gmail.com";
					$subject2 = 'Nouvelle inscription au répertoire des fournisseurs';
					$subject2 = mb_encode_mimeheader($subject2, "UTF-8");
					if($contact_fiche_complete != '') {
						$contact_fiche_complete = 'Oui';
					}else {
						$contact_fiche_complete = 'Non';
					}
					$message2 = "Un nouveau fournisseur s'est récemment inscrit à votre répertoire des fournisseurs. Voici ces coordonnées :<br /><br />Société : $nomSociete<br />Adresse : $adresse<br />Code postal : $codePostal<br />Ville : $ville<br />Pays : $pays<br />Téléphone : $telephone<br />Site web : $siteWeb<br /><br />Voici les coordonnées de la personne qui s'est inscrite :<br /><br />Nom : $nom<br />Prenom : $prenom<br />email : $email<br /><br />Le fournisseur souhaite être contacté pour souscrire une fiche complète : $contact_fiche_complete";
					$headers2  = 'MIME-Version: 1.0' . "\r\n";
					$headers2 .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					$headers2 .= "From: \"DeviceMed France\"<info@devicemed.fr>";

					if(mail($to, $subject, $message, $headers) && mail($to2, $subject2, $message2, $headers2)) {
						return true;
					}else {
						return false;
					}
				}else {
					return false;
				}
			}else {
				return false;
			}
		}
	}
	public function envoiMailValidationSupplier($supplier_id) {
		// On récupére le mail de l'utilisateur qui s'est inscris
		$sqlMailSupplier = "SELECT * FROM wordpress_dm_suppliers_users WHERE supplier_id=$supplier_id";
		$resultMailSupplier = mysql_query($sqlMailSupplier);
		
		if($rowMailSupplier = mysql_fetch_array($resultMailSupplier)) {
			$mailSupplier = $rowMailSupplier['supplier_user_email'];
		}

		// On récupére le nom du fournisseur qui s'est inscris
		$sqlSupplier = "SELECT * FROM wordpress_dm_suppliers WHERE ID=$supplier_id";
		$resultSupplier = mysql_query($sqlSupplier);
		
		if($rowSupplier = mysql_fetch_array($resultSupplier)) {
			$nomFournisseur = $rowSupplier['supplier_name'];
			$nomFournisseur = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
			$nomFournisseur = str_replace(' ','-', $nomFournisseur);
		}

		$to = "$mailSupplier";
		$subject = 'Validation de votre inscription au répertoire des fournisseurs de DeviceMed';
		$subject = mb_encode_mimeheader($subject, "UTF-8");
		$message = "Bonjour et merci de votre inscription.<br /><br />";
		$message .= "Celle-ci a été validée et votre fiche est accessible à l'adresse suivante : <a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur/$supplier_id\" target='_blank'>http://www.devicemed.fr/suppliers/$nomFournisseur/$supplier_id</a><br /><br />";
		$message .= "N'hésitez pas à nous indiquer le besoin d'éventuelles corrections, à l'adresse info@devicemed.fr ou au 04 73 61 95 57.<br /><br />";
		$message .= "Bien cordialement,<br /><br />";
		$message .= "L'équipe de DeviceMed France";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: \"DeviceMed\"<info@devicemed.fr>";

		if(mail($to, $subject, $message, $headers)) {
			return true;
		}else {
			return false;
		}
	}
	public function valideInscription($idUser, $idSupplier) {
		global $wpdb;
		
		$sqlUpdateUser = 'UPDATE wordpress_dm_suppliers_users SET supplier_user_lostpassword_key="", supplier_user_status=2 WHERE ID='. $idUser;
		$resultUpdateUser = $wpdb->query($sqlUpdateUser);
		
		$sqlUpdateSupplier = 'UPDATE wordpress_dm_suppliers SET supplier_status=2 WHERE ID='. $idSupplier;
		$resultUpdateSupplier = $wpdb->query($sqlUpdateSupplier);

		if($resultUpdateSupplier && $resultUpdateUser) {
			return true;
		}else {
			return false;
		}
	}
	public function verifCodeTemporaire($code) {
		global $wpdb;
		$sqlCodeTemporaire = 'SELECT * FROM wordpress_dm_suppliers_users WHERE supplier_user_lostpassword_key = "'. $code .'"';

		return $wpdb->get_row($wpdb->prepare($sqlCodeTemporaire), ARRAY_A);
	}
	public function admin_list($page = 1, $limit = 10, $filters = array())
	{
		global $wpdb;

		$supplier_categories = new DM_Wordpress_Suppliers_Categories_Model();

		$orderby = 'supplier_created';
		$order = 'DESC';
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
				"(supplier_name LIKE '%:search%')",
				array(':search' => esc_sql(like_escape($filters['search'])))
			);
		}
		if (isset($filters['supplier_status']))
		{
			$where[] = sprintf("(supplier_status = %d)", (int) $filters['supplier_status']);
		}
		
		$results = $wpdb->get_results(strtr(
			'SELECT :table.ID, :table.supplier_category_id, :table_category.supplier_category_title, :table.supplier_name, :table.supplier_status, :table.supplier_created, :table.supplier_modified'.
			' FROM '.$this->table().
			' LEFT JOIN :table_category ON :table.supplier_category_id = :table_category.ID'.
			($where ? ' WHERE '.implode(' AND ', $where) : '').
			' ORDER BY '.$orderby.' '.$order.
			' LIMIT '.$offset.', '.$limit,
			array(
				':table' => $this->table(),
				':table_category' => $supplier_categories->table()
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
		return (int) $wpdb->get_var('SELECT COUNT(*) FROM '.$this->table().' WHERE supplier_status = 1');
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
	public function admin_edit_get_supplier($id)
	{
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare(
			'SELECT *'.
			' FROM '.$this->table().
			' WHERE ID = %d',
			(int) $id
		), ARRAY_A);
	}
	public function admin_edit_update_supplier($fields, $id)
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
	public function get_supplier($supplier_id)
	{
		global $wpdb;
		return $wpdb->get_row(
			'SELECT *'.
			' FROM '.$this->table().' WHERE ID = '.((int) $supplier_id)
		, ARRAY_A);
	}
	public function get_suppliers_by_category_id($category_id, $rechercheFournisseur, $affichage_suppliers = false)
	{
		global $wpdb;
		
		if($rechercheFournisseur != '') {
			if($category_id != 0) {
				$sqlFournisseur = 'SELECT * FROM '.$this->table(). ' WHERE supplier_category_id = '.((int) $category_id).' AND supplier_status = 1 AND supplier_name LIKE \'%'. $rechercheFournisseur .'%\'';
				return $wpdb->get_results($sqlFournisseur , ARRAY_A);
			}else {
				$sqlFournisseur = 'SELECT * FROM '.$this->table(). ' WHERE supplier_status = 1 AND supplier_name LIKE \'%'. $rechercheFournisseur .'%\'';
				return $wpdb->get_results($sqlFournisseur , ARRAY_A);
			}
		}elseif($affichage_suppliers == false) {
			if($category_id != 0) {
				$sqlCategoriesFournisseurs = "SELECT * FROM ".$this->table()." WHERE (supplier_category_id LIKE '%$category_id,%' OR supplier_category_id LIKE '%,$category_id%' OR supplier_category_id = '$category_id') AND supplier_status = 1";
				return $wpdb->get_results($sqlCategoriesFournisseurs, ARRAY_A);
			}else {
				$sqlCategoriesFournisseurs = "SELECT * FROM ".$this->table()." WHERE (supplier_category_id LIKE '%,$category_id%' OR supplier_category_id = '$category_id') AND supplier_status = 1";
				return $wpdb->get_results($sqlCategoriesFournisseurs, ARRAY_A);
			}
		}
	}
	public function verifmail($email) {
		global $wpdb;
		return $wpdb->get_row(
			'SELECT *'.
			' FROM wordpress_dm_suppliers_users WHERE supplier_user_login = "'. $email .'"'
		, ARRAY_A);
	}
	public function string_sanitize_nicename($string)
	{
		return str_replace(' - ', '-', preg_replace('/\s+/', ' ',
			mb_convert_case(
				str_replace('-', ' - ', strtolower(trim($string))
			), MB_CASE_TITLE, 'UTF-8')
		));
	}
	
	public function extractBdd() {
		// configuration de la base de données base de données
		$host = DB_HOST;
		$user = DB_USER;
		$pass = DB_PASSWORD;
		$db = DB_NAME;
		$nom_fichier = 'suppliers_'. date('Y-m-d H:i') .'.csv';

		//format du CSV
		$csv_terminated = "\n";
		$csv_separator = ";";
		$csv_enclosed = '"';
		$csv_escaped = "\\";
		
		// On récupére les catégories
		$sqlCategories = "SELECT * FROM `wordpress_dm_suppliers_categories` WHERE supplier_category_parent=0";
		$resultCategories = mysql_query($sqlCategories);
		$out = '';
		
		while($rowCategories = mysql_fetch_array($resultCategories)) {
			// requête MySQL
			// On récupére toutes les catégories enfants
			$categorie = $rowCategories['ID'];
			$sqlCatEnfant = "SELECT ID FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=$categorie";
			$resultCatEnfant = mysql_query($sqlCatEnfant);
			$arraySqlCatEnfant = array();
			
			while($rowCatEnfant = mysql_fetch_array($resultCatEnfant)) {
				$idEnfant = $rowCatEnfant['ID'];
				$sqlIDEnfant = "supplier_category_id LIKE '$idEnfant,%' OR supplier_category_id LIKE '%,$idEnfant,%' OR supplier_category_id LIKE '%,$idEnfant' OR supplier_category_id = '$idEnfant'";
				
				array_push($arraySqlCatEnfant, $sqlIDEnfant);
			}
			
			$sql_query = "SELECT ID, supplier_name, supplier_category_id, supplier_city, supplier_country, supplier_website FROM wordpress_dm_suppliers";
			$sql_query .= " WHERE (";
				$sql_query .= " (supplier_category_id LIKE '$categorie,%' OR supplier_category_id LIKE '%,$categorie,%' OR supplier_category_id LIKE '%,$categorie' OR supplier_category_id = '$categorie')";
			for($i = 0; $i < sizeOf($arraySqlCatEnfant);$i++) {
				$sqlIDEnfant2 = $arraySqlCatEnfant[$i];
				$sql_query .= " OR ($sqlIDEnfant2)";
			}
			$sql_query .= " )";
			$sql_query .= " AND supplier_status=1";
			$sql_query .= " ORDER BY supplier_name ASC";
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
			
			// On récupére le nom de la catégorie
			$sqlCategoriePrincipale = "SELECT * FROM `wordpress_dm_suppliers_categories` WHERE ID=$categorie";
			$resultCategoriePrincipale = mysql_query($sqlCategoriePrincipale);
			
			if($rowCategoriePrincipale = mysql_fetch_array($resultCategoriePrincipale)) {
				$nomCategoriePrincipale = $rowCategoriePrincipale['supplier_category_title'];
			}
			
			$schema_insert = '"'. utf8_decode($nomCategoriePrincipale) .'";';
			
			// On récupére les sous catégorie de la catégorie courante
			$sqlSousCategorieId = "SELECT * FROM `wordpress_dm_suppliers_categories` WHERE supplier_category_parent=$categorie";
			$resultSousCategorieId = mysql_query($sqlSousCategorieId);
			$nbSousCategorieId = mysql_num_rows($resultSousCategorieId);
			$nbSousCategorie = 0;

			while($rowSousCategorie = mysql_fetch_array($resultSousCategorieId)) {
				$idSousCategorie = $rowSousCategorie['ID'];
				$nomSousCategorie = utf8_decode($rowSousCategorie['supplier_category_title']);
				$schema_insert .= '"'. $nomSousCategorie .'";';
				$nbSousCategorie++;
			}				
			
			for($z = $nbSousCategorie; $z <=35;$z++) {
				$schema_insert .= "\"\";";
			}
			
			$schema_insert .= '"SITE WEB";';

			$out .= trim(substr($schema_insert, 0, -1));
			$out .= $csv_terminated;
			
			$schema_insert2 = '"SOCIETES";';
			
			// On récupére les sous catégorie de la catégorie courante
			$sqlSousCategorieId = "SELECT * FROM `wordpress_dm_suppliers_categories` WHERE supplier_category_parent=$categorie";
			$resultSousCategorieId = mysql_query($sqlSousCategorieId);
			$nbSousCategorieId = mysql_num_rows($resultSousCategorieId);

			while($rowSousCategorie = mysql_fetch_array($resultSousCategorieId)) {
				$idSousCategorie = $rowSousCategorie['ID'];
				$nomSousCategorie = utf8_decode($rowSousCategorie['supplier_category_title']);
				$schema_insert2 .= '"'. $idSousCategorie .'";';
			}
			
			$schema_insert2 .= "\"\";\n";
			
			$out .= $schema_insert2;
			
			// On récupére les sous catégories
			$arraySousCategorie = array();
			
			// On récupére les sous catégorie de la catégorie courante
			$sqlSousCategorieId = "SELECT * FROM `wordpress_dm_suppliers_categories` WHERE supplier_category_parent=$categorie";
			$resultSousCategorieId = mysql_query($sqlSousCategorieId);
			$nbSousCategorieId = mysql_num_rows($resultSousCategorieId);

			while($rowSousCategorie = mysql_fetch_array($resultSousCategorieId)) {
				$idSousCategorie = $rowSousCategorie['ID'];
				array_push($arraySousCategorie, $idSousCategorie);
			}

			// Format des données
			while ($row = mysql_fetch_array($result))
			{
				$schema_insert3 = '';
				$supplier_id = $row['ID'];
				$supplierName = utf8_decode($row['supplier_name']);
				$supplierCity = utf8_decode($row['supplier_city']);
				$supplierCountry = utf8_decode($row['supplier_country']);
				
				$website = $row['supplier_website'];
				
				$schema_insert3 .= '"'. $supplierName .','. $supplierCity .','. $supplierCountry .'";';
				
				for($k=0;$k<sizeOf($arraySousCategorie);$k++) {
					$idSousCategorie = $arraySousCategorie[$k];
					
					$sqlFournisseursCategorie = "SELECT * FROM wordpress_dm_suppliers";
					$sqlFournisseursCategorie .= " WHERE (supplier_category_id LIKE '$idSousCategorie,%' OR supplier_category_id LIKE '%,$idSousCategorie,%' OR supplier_category_id LIKE '%,$idSousCategorie' OR supplier_category_id = '$idSousCategorie')";
					$sqlFournisseursCategorie .= " AND supplier_status=1 AND ID=$supplier_id";
					$sqlFournisseursCategorie .= " ORDER BY supplier_name ASC";
					$resultFournisseursCategorie = mysql_query($sqlFournisseursCategorie);
					$nbFournisseursCategorie = mysql_num_rows($resultFournisseursCategorie);
					
					if($nbFournisseursCategorie == 0) {
						$schema_insert3 .= '"";';
					}else {
						$schema_insert3 .= '"'. $idSousCategorie .'";';
					}
				}
			
				for($z = $nbSousCategorie; $z <=35;$z++) {
					$schema_insert3 .= "\"\";";
				}
				
				$schema_insert3 .= '"'. $website .'";';

				$out .= $schema_insert3;
				$out .= $csv_terminated;
			} // fin while	
			
			$out .= "\n";
		}

		// Envoie au fureteur pour le téléchargement
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Length: " . strlen($out));
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=" . $nom_fichier);
		echo $out;
		exit;
	}
}
