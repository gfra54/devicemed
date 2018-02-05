<?php
	define('SHORT_URL', str_replace('www.','',site_url()).'/');
	$break = PHP_EOL.PHP_EOL;
	$lignes = array();

//	$lignes[] = mb_strtoupper($newsletter->post_title);
	if(!empty($titre_disp)) {
		$lignes[] = $titre_disp; 
	} else {
		$lignes[] = 'Newsletter du '.$date;
	}	
	$lignes[] = 'Cette semaine dans la newsletter DeviceMed';

	if($pub_id = get_field('banniere_horizontale_en_haut',$newsletter->ID)) {
		$lignes = pub_texte_brut($pub_id,$lignes);
	}
	$lignes[] = '[À LA UNE]';

	$cpt=0;
	foreach($articles as $article) {
		$ligne_article=array();
		$ligne_article[] = '== '.convertToSmallCaps($article['category']).' == ';
		$ligne_article[] = mb_strtoupper($article['title']);
		$ligne_article[] = strip_tags($article['text']).PHP_EOL.'=> '.SHORT_URL.$article['id'];
		$lignes[]=implode(PHP_EOL,$ligne_article);
		if($cpt==2) {
			if($pub_id = get_field('banniere_dans_articles',$newsletter->ID)) {
				$lignes = pub_texte_brut($pub_id,$lignes);
			}
		}

  	$cpt++;
	}

	foreach(get_field('bannieres_verticales') as $pub) {
		$lignes = pub_texte_brut($pub['banniere_verticale'],$lignes);
	}


	$lignes[] = '[FOURNISSEURS PARTENAIRES]';
	$lignes[] = bloc_partenaires_brut();

	if($pub_id = get_field('banniere_horizontale_en_bas',$newsletter->ID)) {
		$lignes = pub_texte_brut($pub_id,$lignes);
	}


	$lignes[] = '- - - - - -';
	$lignes[] = 'Si vous ne visualisez pas bien cet email, cliquez sur le lien suivant pour voir la version en ligne: *|ARCHIVE|*';

	$lignes[] = 'Cet email a été envoyé par DeviceMed à *|EMAIL|*, Suivez le lien suivant pour vous désabonner *|UNSUB|*';


	$lignes[] = '- - - - - -';
	$lignes[] = '© The French language edition of DeviceMed is a publication of Tipise SAS, licensed by Vogel Business Media GmbH & Co. KG, 97082 Wuerzburg/Germany.';
$lignes[] = '© Copyright of the trademark « DeviceMed » by Vogel Business Media GmbH & Co. KG, 97082 Wuerzburg/Germany. Responsable du contenu rédactionnel sur www.devicemed.fr : TIPISE SAS, Evelyne Gisselbrecht, éditrice de DeviceMed, 33 rue du Puy-de-Dôme, 63370 Lempdes France';

	foreach($lignes as $k=>$ligne) {
		// if(strstr($ligne, PHP_EOL)===false) {
			$lignes[$k] = mb_wordwrap($ligne,80,PHP_EOL);
		// }
	}
	echo '<pre>'.implode($break,$lignes).'</pre>';

  $GLOBALS['bloc_partenaires_brut']=false;
	function bloc_partenaires_brut() {
		global $afficher_le_bloc_partenaire;
		if($afficher_le_bloc_partenaire && !$GLOBALS['bloc_partenaires_brut']) {
			$fournisseurs = get_fournisseurs(array('premium'=>true));
			foreach($fournisseurs as $fournisseur) {
				$nom = wp_trim_words($fournisseur['post_title'],2,'');
				$nom = str_replace('Composites','Comp.',$nom);
				$nom = str_replace('Medical','Med.',$nom);
				$nom = str_replace('Medical','Med.',$nom);
				$nom = str_replace('Balzers','',$nom);
				$nom = str_replace('Technologies','Tech.',$nom);
				$data_fournisseurs[$fournisseur['ID']]=array('nom'=>$nom,'url'=>$fournisseur['permalink']);
			}

			$GLOBALS['bloc_partenaires_brut']=true;
			$tab=array();
			$cpt=0;foreach($data_fournisseurs as $id=>$data) {

				// $ret[]=mb_str_pad(mb_strtoupper($data['nom']), 20,' ').SHORT_URL.$id;
				$tab[]=mb_strtoupper($data['nom']);
				// $ret[]=SHORT_URL.$id.PHP_EOL;
			}

			return 'Comme chaque semaine, retrouvez notre liste de fournisseurs partenaires: '.PHP_EOL.implode(', ',$tab).PHP_EOL.'Voir la liste de nos fournisseurs partenaires en ligne http://devicemed.fr/partenaires';
			// return implode(PHP_EOL,$ret);
		}
	}

	function pub_texte_brut($pub_id,$lignes) {

		if($pub_id == 14187) {

			$args = array( 
				'posts_per_page'=>1,
				'order'=>'DESC',
				'orderby'=>'date',
				'category_name'=> 'magazine'
			);
			if($posts = new WP_Query($args)) {
				$magazine = $posts->posts[0];

				$surtitre = '';
				$titre_texte_brut = $magazine->post_title;
				$texte_brut = 'A la une: '.get_field('texte_home',$magazine->ID).'.'.PHP_EOL.'Consultez ce numéro et abonnez-vous en ligne au magazine DeviceMed '.SHORT_URL.$magazine->ID;
			}

		} else {
			$surtitre = 'Annonce';
			$titre_texte_brut = get_field('titre_texte_brut',$pub_id);
			$texte_brut = get_field('texte_brut',$pub_id);
		}
		if(!$titre_texte_brut && !$texte_brut) {
		      $titre_texte_brut = get_field('titre_pub',$pub_id);
		      $texte_brut = get_field('texte',$pub_id).PHP_EOL.'=> '.get_field('url_cible',$pub_id);
		}
		if($titre_texte_brut && $texte_brut) {
			$lignes[] = '== '.($surtitre ? $surtitre.' - ' : '').convertToSmallCaps($titre_texte_brut).' =='.PHP_EOL.$texte_brut;
		}
		return $lignes;
	}
