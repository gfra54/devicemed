<?php

	require_once("../../../../wp-load.php");
	if(isset($_GET['empty'])) {
		$args = array(
			'numberposts' => 5000,
			'post_status'=>array('draft','publish'),
			'post_type' =>'fournisseur'
		);
		$posts = get_posts( $args );
		if (is_array($posts)) {
		   foreach ($posts as $post) {
		       wp_delete_post( $post->ID, true);
		   }
		}
 	}

	$res = mysql_query('SELECT * FROM wordpress_dm_suppliers');

	while($fournisseur = mysql_fetch_assoc($res)) {
		$post = array(
			'post_type'=>'fournisseur',
			'post_date'=>$fournisseur['supplier_created'],
			'post_modified'=>$fournisseur['supplier_modified'],
			'post_content'=>$fournisseur['supplier_about'],
			'post_title'=>$fournisseur['supplier_name'],
			'post_status'=> $fournisseur['supplier_valide'] ? 'publish' : 'draft',
			'meta_input'=>array(
				'adresse'=>$fournisseur['supplier_address'],
				'code_postal'=>$fournisseur['supplier_postalcode'],
				'ville'=>$fournisseur['supplier_city'],
				'pays'=>$fournisseur['supplier_country'],
				'telephone'=>$fournisseur['supplier_telephone'],
				'url'=>http($fournisseur['supplier_website']),
				'blog'=>http($fournisseur['supplier_social_blog']),
				'facebook'=>http($fournisseur['supplier_social_facebook']),
				'twitter'=>http($fournisseur['supplier_social_twitter']),
				'youtube'=>http($fournisseur['supplier_social_youtube']),
				'googleplus'=>http($fournisseur['supplier_social_google_plus']),
				'linkedin'=>http($fournisseur['supplier_social_linkedin']),
				'premium'=>$fournisseur['supplier_premium'],
				'nom_contact'=>$fournisseur['supplier_contact_nom'],
				'email_contact'=>$fournisseur['supplier_contact_mail'],
				'telephone_contact'=>$fournisseur['supplier_contact_tel'],
				'optin'=>$fournisseur['supplier_souhait_contact']
				)
		);

		echo ($fournisseur['supplier_name']).'<br>';


		$post_id = wp_insert_post($post);


		foreach($post['meta_input'] as $k=>$v) {
			update_field($k,$v,$post_id);
		}


		$cats = explode(',',$fournisseur['supplier_category_id']);
		$$cats_nouveau=array();
		foreach($cats as $cat) {
			if($cat = nouvelIdCategorie($cat)) {
				$cats_nouveau[] = $cat;
			}
		}
		wp_set_post_terms( $post_id, $cats_nouveau, 'categorie' );

//m($fournisseur['supplier_logo']);
		$url = site_url('/wp-content/uploads/logo_suppliers/').$fournisseur['supplier_logo'];
		if(strstr($url, '.local')===false) {
			Generate_Featured_Image($url,$post_id);
		}
	}
