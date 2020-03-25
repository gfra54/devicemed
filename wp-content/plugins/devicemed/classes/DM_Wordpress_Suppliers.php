<?php
class DM_Wordpress_Suppliers
{
	/**
	 * Initialize section
	 * @return void
	 */
	static public function initialize()
	{
		// ----------------------------------------------------------
		// Register Wordpress Routes
/*
		DM_Wordpress_Router::add('/suppliers/@category/@category_id/@supplier_name/@supplier_id/articles/@article_title/@article_id', array(__CLASS__, 'article'));
		DM_Wordpress_Router::add('/suppliers/@category/@category_id/@supplier_name/@supplier_id/products/@product_title/@product_id', array(__CLASS__, 'product'));
		DM_Wordpress_Router::add('/suppliers/@category/@category_id/@supplier_name/@supplier_id/about', array(__CLASS__, 'about'));
*/
		DM_Wordpress_Router::add('/suppliers/inscription', array(__CLASS__, 'inscription'));
		DM_Wordpress_Router::add('/suppliers/@supplier_name/@supplier_id', array(__CLASS__, 'supplier'));
		DM_Wordpress_Router::add('/suppliers/@category/@category_id', array(__CLASS__, 'category'));
		DM_Wordpress_Router::add('/suppliers', array(__CLASS__, 'suppliers'));
		DM_Wordpress_Router::add('/validation/@code_temporaire', array(__CLASS__, 'validation'));
		DM_Wordpress_Router::add('/fournisseurs_partenaires', array(__CLASS__, 'partners'));
	}
	
	static public function inscription($params)
	{	
		wp_redirect('/nouveau-fournisseur',301);
		exit;
		$supplier = new DM_Wordpress_Suppliers_Model();

		$data = array();
		$errors = array();
		$success = array();
		
		if (!empty($_POST))
		{
			$data['nom_societe'] = $_POST['nom_societe'];
			$data['adresse'] = $_POST['adresse'];
			$data['code_postal'] = $_POST['code_postal'];
			$data['ville'] = $_POST['ville'];
			$data['pays'] = $_POST['pays'];
			$data['telephone'] = $_POST['telephone'];
			$data['site_web'] = $_POST['site_web'];
			$data['contact_fiche_complete'] = $_POST['contact_fiche_complete'];
			
			// On récupére les catégories cochés
			if(isset($_POST['categories'])){
				$i = 0;
				foreach($_POST['categories'] as $chkbx){
					if($i == 0) {
						$data['supplier_category_id'] = $chkbx;
					}else {
						$data['supplier_category_id'] .= ",". $chkbx;
					}
					$i++;
				}
			}else {
				$errors['categories'] = 'Veuillez cocher au moins une catégorie.';
			}
			
			$data['nom'] = $_POST['nom'];
			$data['prenom'] = $_POST['prenom'];
			$data['email'] = $_POST['email'];

			$data['supplier_contact_nom'] = $_POST['supplier_contact_nom'];
			$data['supplier_contact_tel'] = $_POST['supplier_contact_tel'];
			$data['supplier_contact_mail'] = $_POST['supplier_contact_mail'];

			if (!$data['nom_societe'])
			{
				$errors['nom_societe'] = 'Veuillez indiquer le nom de votre société.';
			}
			
			if (!$data['adresse'])
			{
				$errors['adresse'] = 'Veuillez indiquer l\'adresse de votre société.';
			}
			
			if (!$data['code_postal'])
			{
				$errors['code_postal'] = 'Veuillez indiquer le code postal de votre société.';
			}
			
			if (!$data['ville'])
			{
				$errors['ville'] = 'Veuillez indiquer la ville de votre société.';
			}
			
			if (!$data['pays'])
			{
				$errors['pays'] = 'Veuillez indiquer le pays de votre société.';
			}
			
			if (!$data['nom'])
			{
				$errors['nom'] = 'Veuillez indiquer votre nom.';
			}
			
			if (!$data['prenom'])
			{
				$errors['prenom'] = 'Veuillez indiquer votre prénom.';
			}

			if (!$data['supplier_contact_tel'])
			{
				$errors['supplier_contact_tel'] = 'Veuillez indiquer le numéro de téléphone de la personne à contacter.';
			}
			
			if (!$data['supplier_contact_nom'])
			{
				$errors['supplier_contact_nom'] = "Veuillez indiquer le nom d'une personne à contacter.";
			}
			
			if(!$data['email']) {
				$errors['email'] = 'Veuillez indiquer votre adresse mail.';
			}elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = 'Veuillez indiquer une adresse mail valide.';
			}
			
			if(!$data['supplier_contact_mail']) {
				$errors['supplier_contact_mail'] = "Veuillez indiquer l'adresse mail de la personne à contacter.";
			}elseif(!filter_var($data['supplier_contact_mail'], FILTER_VALIDATE_EMAIL)) {
				$errors['supplier_contact_mail'] = 'Veuillez indiquer une adresse mail valide.';
			}		

			if(!$errors) {
				$arrayMail = $supplier->verifmail($data['email']);
				if(count($arrayMail) == 0) {
					if($supplier->save($data)) {
						$success['general'] = 'Merci de votre demande d’inscription. Pour la valider, veuillez cliquer sur le lien contenu dans l\'email que vous allez bientôt recevoir.';
					}else {
						$errors['general'] = 'Une erreur est survenue lors de l\'inscription au répertoire des fournisseurs. Veuillez contacter un administrateur.';
					}
				}else {
					$errors['general'] = 'Un fournisseur est déjà inscrit avec cette adresse email.';
				}
			}
		}
		
		DM_Wordpress::title(array('Fournisseurs', 'Figurer dans le répertoire'));
		DM_Wordpress_Template::theme('suppliers/inscription', array(
			'data' => $data,
			'errors' => $errors,
			'success' => $success
		));
	}
	
	static public function validation($params) {	
		$supplier = new DM_Wordpress_Suppliers_Model();
		$data = array();
		$errors = array();
		$success = array();
		$code_temporaire = $params['code_temporaire'];
		
		$arrayCodeTemporaire = $supplier->verifCodeTemporaire($code_temporaire);

		if(count($arrayCodeTemporaire) == 0 || $code_temporaire = '') {
			wp_redirect(home_url().'/suppliers/inscription'); exit;
		}else {
			$idUser = $arrayCodeTemporaire['ID'];
			$idSupplier = $arrayCodeTemporaire['supplier_id'];
			
			// echo "idUser : $idUser / idSupplier : $idSupplier";exit();
			
			if($supplier->valideInscription($idUser, $idSupplier)) {
				$success['general'] = 'Nous avons bien reçu votre demande d’inscription, qui ne sera effective qu\'après vérification et validation par nos soins.';
			}else {
				$errors['general'] = 'Une erreur est survenue. Veuillez contacter un administrateur.';
			}
		}
		
		DM_Wordpress::title(array('Fournisseurs', 'Validation d\'inscription'));
		DM_Wordpress_Template::theme('suppliers/validation', array(
			'data' => $data,
			'errors' => $errors,
			'success' => $success
		));
	}
	static public function suppliers($params)
	{
		$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
		$suppliers = new DM_Wordpress_Suppliers_Model();
		$categories = array();
		$results = array();
		
		foreach ($suppliers_categories->get_categories() as $category)
		{
			$categories[ $category['ID'] ] = $category;
		}
		
		$rechercheFournisseur = !empty($_GET['recherche_fournisseur']) ? $_GET['recherche_fournisseur'] : 0;
		$category_id = 0;
		foreach ($suppliers->get_suppliers_by_category_id($category_id, $rechercheFournisseur, true) as $supplier)
		{
			$results[ $supplier['ID'] ] = $supplier;
		}

		DM_Wordpress::title(array('Fournisseurs'));
		DM_Wordpress_Template::theme('suppliers/suppliers', array(
			'categories' => $categories,
			'suppliers' => $results
		));
	}
	static public function partners($params)
	{
		DM_Wordpress::title(array('Fournisseurs partenaires'));
		DM_Wordpress_Template::theme('suppliers/suppliers_partners', array());
	}
	static public function category($params)
	{
		$category_id = (int) $params['category_id'];
		$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
		$category = $suppliers_categories->get_category($category_id);
		$suppliers = new DM_Wordpress_Suppliers_Model();
		$results = array();
		foreach ($suppliers->get_suppliers_by_category_id($category_id) as $supplier)
		{
			$results[ $supplier['ID'] ] = $supplier;
		}
		
		DM_Wordpress::title(array('Fournisseurs', esc_html($category['supplier_category_title'])));
		DM_Wordpress_Template::theme('suppliers/category', array(
			'category' => $category,
			'suppliers' => $results
		));
	}
	static public function supplier($params)
	{
		$supplier_id = (int) $params['supplier_id'];
		
		$supplier = $posts = $products = $galleries = $medias = $events = $downloads = array();

		$suppliers = new DM_Wordpress_Suppliers_Model();
		if ($supplier = $suppliers->get_supplier($supplier_id))
		{
			if ($supplier['supplier_status'] == 1)
			{
				$suppliers_posts = new DM_Wordpress_Suppliers_Posts_Model();
				$posts = $suppliers_posts->get_last_posts_by_supplier_id($supplier['ID']);
				$suppliers_products = new DM_Wordpress_Suppliers_Products_Model();
				$products = $suppliers_products->get_last_products_by_supplier_id($supplier['ID']);
				$suppliers_galleries = new DM_Wordpress_Suppliers_Galleries_Model();
				$galleries = $suppliers_galleries->get_last_galleries_by_supplier_id($supplier['ID']);
				$suppliers_videos = new DM_Wordpress_Suppliers_Videos_Model();
				$videos = $suppliers_videos->get_last_videos_by_supplier_id($supplier['ID']);
				$suppliers_downloads = new DM_Wordpress_Suppliers_Download_Model();
				$downloads = $suppliers_downloads->get_last_downloads_by_supplier_id($supplier['ID']);
				$suppliers_events = new DM_Wordpress_Suppliers_Event_Model();
				$events = $suppliers_events->get_last_events_by_supplier_id($supplier['ID']);
		
				$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
				$category = $suppliers_categories->get_categories($supplier['supplier_category_id']);
				
				DM_Wordpress::title(array('Fournisseurs', esc_html($supplier['supplier_name'])));
			}
		}
		DM_Wordpress_Template::theme('suppliers/supplier', array(
			'supplier' => $supplier,
			'posts' => $posts,
			'products' => $products,
			'galleries' => $galleries,
			'videos' => $videos,
			'medias' => $medias,
			'events' => $events,
			'downloads' => $downloads,
			'category' => $category
		));
	}
	static public function url_category($category_id)
	{
		$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
		if ($category = $suppliers_categories->get_category($category_id))
		{
			return site_url(sprintf('/suppliers/%s/%d',
				sanitize_title($category['supplier_category_title']),
				(int) $category['ID']
			));
		}
	}
	static public function url_supplier($supplier_id)
	{
		$suppliers = new DM_Wordpress_Suppliers_Model();
		if ($supplier = $suppliers->get_supplier($supplier_id))
		{
			$suppliers_categories = new DM_Wordpress_Suppliers_Categories_Model();
			if ($category = $suppliers_categories->get_category($supplier['supplier_category_id']))
			{
				return site_url(sprintf('/suppliers/%s/%d',
					sanitize_title($supplier['supplier_name']),
					(int) $supplier['ID']
				));
			}
		}
	}
}
