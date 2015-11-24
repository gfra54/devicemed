<?php get_header(); ?>
<div class="row column-content page-members">
	<div class="col-md-9 col-sm-8 column-main">
	<section class="profile">
		<h2 class="title">Les fournisseurs des fabricants de dispositifs médicaux</h2>
		<!--<form name='search_suppliers' action='' method='GET'>
			<input type='text' name='recherche_fournisseur' value='<?php echo $_GET['recherche_fournisseur']; ?>' placeHolder="indiquer un nom d'entreprise ..." />
			<input type='submit' value='Rechercher'/>
			<?php $urlTemp = get_bloginfo('url'); ?>
			<a href='?recherche_fournisseur='><div class='remise_a_zero'>Remise à zéro</div></a>
		</form>-->
		<!--<ul class="categories">
<?php if(count($suppliers) > 0) { ?>
	<?php foreach ($suppliers as $supplier): ?>
				<div class="title_supplier"><a href="<?php echo DM_Wordpress_Suppliers::url_supplier($supplier['ID']); ?>"><?php echo esc_html($supplier['supplier_name']); ?></a></div>
	<?php endforeach; ?>
<?php }else { ?>
	<?php foreach ($categories as $category): ?>
				<li><a href="<?php echo site_url('/suppliers/'.esc_attr(sanitize_title($category['supplier_category_title'])).'/'.$category['ID']); ?>"><?php echo esc_html($category['supplier_category_title']); ?></a></li>
	<?php endforeach; ?>
<?php } ?>
		</ul>-->
		<!--<a href='http://www.devicemed.fr/wp-content/uploads/archives/pdf/juillet_aout2014.pdf' target='_blank'><h3 class="title5">Consulter le Guide de l’acheteur de DeviceMed</h3></a><br />-->
		<?php 
			if(isset($_POST['motCleFournisseur']) && $_POST['motCleFournisseur'] != '') {
				$motCleFournisseur = $_POST['motCleFournisseur'];
				$arrayFournisseursTemp = array();
				
				echo "<h3 class='title5' id='retour_fournisseurs'><a href='http://www.devicemed.fr/suppliers/'>Retour à la page de recherche d'un fournisseur</a></h3>";
				echo "<h3 class='title5'>Résultat de recherche correspondant au mot-clé '$motCleFournisseur' :</h3>";
				
				// On récupére les fournisseurs qui ressemble au mot clé
				$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE (supplier_name LIKE '%$motCleFournisseur%' OR supplier_category_id IN(SELECT ID FROM wordpress_dm_suppliers_categories WHERE supplier_category_title LIKE '%$motCleFournisseur%') OR supplier_category_id IN(SELECT ID FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent IN(SELECT ID FROM wordpress_dm_suppliers_categories WHERE supplier_category_title LIKE '%$motCleFournisseur%'))) AND supplier_status=1";
				// echo "sqlFournisseurs : ". $sqlFournisseurs;
				$resultFournisseurs = mysql_query($sqlFournisseurs);
				$nbFournisseurs = mysql_num_rows($resultFournisseurs);
				
				echo "<div id='bloc_supplier_search'>";
					if($nbFournisseurs > 0) {
						while($rowFournisseurs = mysql_fetch_array($resultFournisseurs)) {
							$idFournisseur = $rowFournisseurs['ID'];
							$nomFournisseur = $rowFournisseurs['supplier_name'];
							$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
							$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
							
							array_push($arrayFournisseursTemp, $nomFournisseur);
							echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></div>";
						}
					}
				echo "</div>";

				/*** RECHERCHE PAR CATEGORIE QUI CORRESPONDENT AU MOT CLE ***/
				// On récupére les catégories qui correspondent au mot clé
				$sqlCategorie = "SELECT ID FROM wordpress_dm_suppliers_categories WHERE supplier_category_title LIKE '%$motCleFournisseur%'";
				$resultCategorie = mysql_query($sqlCategorie);
				$nbCategorie = mysql_num_rows($resultCategorie);
				$arrayCategorie = array();

				if($nbCategorie > 0) {
					while($rowCategorie = mysql_fetch_array($resultCategorie)) {
						$idCategorie = $rowCategorie['ID'];

						array_push($arrayCategorie, $idCategorie);
					}
				}

				$nbFournisseurs2 = 0;

				for($i = 0;$i < sizeOf($arrayCategorie); $i++) {
					$idCategorieTemp = $arrayCategorie[$i];				

					$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers";
					$sqlFournisseurs .= " WHERE (";
					$sqlFournisseurs .= " (supplier_category_id LIKE '$idCategorieTemp,%' OR supplier_category_id LIKE '%,$idCategorieTemp,%' OR supplier_category_id LIKE '%,$idCategorieTemp' OR supplier_category_id = '$idCategorieTemp')";
					$sqlFournisseurs .= " OR (supplier_category_id IN (SELECT ID FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=$idCategorieTemp))";
					$sqlFournisseurs .= " )";
					$sqlFournisseurs .= " AND supplier_status=1";
					$sqlFournisseurs .= " ORDER BY supplier_name ASC";
					$resultFournisseurs = mysql_query($sqlFournisseurs);
				
					echo "<div id='bloc_supplier_search'>";
						while($rowFournisseurs = mysql_fetch_array($resultFournisseurs)) {
							$idFournisseur = $rowFournisseurs['ID'];
							$nomFournisseur = $rowFournisseurs['supplier_name'];
							$supplierPremium = $rowFournisseurs['supplier_premium'];
							$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
							$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);

							if(!in_array($nomFournisseur, $arrayFournisseursTemp)) {
								array_push($arrayFournisseursTemp, $nomFournisseur);
							
								if($supplierPremium == '1') {
									echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'><b>$nomFournisseur</b></a></div>";
								}else {
									echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></div>";
								}
							}
						}
					echo "</div>";

					$nbFournisseurs2++;
				}

				if($nbFournisseurs == 0 && $nbFournisseurs2 == 0) {
					echo "<p>Aucun fournisseur ne correspond à votre recherche.</p>";
				}
			}elseif(isset($_GET['initiale']) && $_GET['initiale'] != '') {
				$initiale = $_GET['initiale'];
				
				// On récupére les fournisseurs qui ressemble au mot clé
				if($initiale == '*') {
					echo "<h3 class='title5' id='retour_fournisseurs'><a href='http://www.devicemed.fr/suppliers/'>Retour à la page de recherche d'un fournisseur</a></h3>";
					echo "<h3 class='title5'>Résultat de recherche correspondant à un chiffre :</h3>";
					$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE (supplier_name LIKE '%0%' OR supplier_name LIKE '%1%' OR supplier_name LIKE '%2%' OR supplier_name LIKE '%3%' OR supplier_name LIKE '%4%' OR supplier_name LIKE '%5%' OR supplier_name LIKE '%6%' OR supplier_name LIKE '%7%' OR supplier_name LIKE '%8%' OR supplier_name LIKE '%9%') AND supplier_status=1 ORDER BY supplier_name ASC";
					$resultFournisseurs = mysql_query($sqlFournisseurs);
					$nbFournisseurs = mysql_num_rows($resultFournisseurs);
				}else {
					echo "<h3 class='title5' id='retour_fournisseurs'><a href='http://www.devicemed.fr/suppliers/'>Retour à la page de recherche d'un fournisseur</a></h3>";
					echo "<h3 class='title5'>Résultat de recherche correspondant à la lettre '$initiale' :</h3>";
					$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE supplier_name LIKE '$initiale%' AND supplier_status=1 ORDER BY supplier_name";
					$resultFournisseurs = mysql_query($sqlFournisseurs);
					$nbFournisseurs = mysql_num_rows($resultFournisseurs);
				}
				
				echo "<div id='bloc_supplier_search'>";
					if($nbFournisseurs > 0) {
						while($rowFournisseurs = mysql_fetch_array($resultFournisseurs)) {
							$idFournisseur = $rowFournisseurs['ID'];
							$nomFournisseur = $rowFournisseurs['supplier_name'];
							$supplierPremium = $rowFournisseurs['supplier_premium'];
							$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
							$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
							
							if($supplierPremium == '1') {
								echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'><b>$nomFournisseur</b></a></div>";
							}else {
								echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></div>";
							}
						}
					}else {
						echo "<p>Aucun fournisseur ne correspond à votre recherche.</p>";
					}
				echo "</div>";
			}elseif(isset($_GET['type']) && $_GET['type'] != '') {
				$type = $_GET['type'];
				
				// On récupére les fournisseurs qui ressemble au mot clé
				if($type == 'liste') {
					echo "<h3 class='title5' id='retour_fournisseurs'><a href='http://www.devicemed.fr/suppliers/'>Retour à la page de recherche d'un fournisseur</a></h3>";
					echo "<h3 class='title5'>Liste alphabétique complète des fournisseurs :</h3>";
					$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE supplier_status=1 ORDER BY supplier_name ASC";
					$resultFournisseurs = mysql_query($sqlFournisseurs);
					$nbFournisseurs = mysql_num_rows($resultFournisseurs);
				
					echo "<div id='bloc_supplier_search'>";
						if($nbFournisseurs > 0) {
							while($rowFournisseurs = mysql_fetch_array($resultFournisseurs)) {
								$idFournisseur = $rowFournisseurs['ID'];
								$nomFournisseur = $rowFournisseurs['supplier_name'];
								$supplierPremium = $rowFournisseurs['supplier_premium'];
								$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
								$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
							
								if($supplierPremium == '1') {
									echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'><b>$nomFournisseur</b></a></div>";
								}else {
									echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></div>";
								}
							}
						}else {
							echo "<p>Aucun fournisseur ne correspond à votre recherche.</p>";
						}
					echo "</div>";
				}
			}elseif(isset($_GET['categorie']) && $_GET['categorie'] != '') {
				$categorie = $_GET['categorie'];

				// On vérifies si la catégorie a une catégorie parente
				$sqlCategorieParent = "SELECT supplier_category_parent FROM wordpress_dm_suppliers_categories WHERE ID=$categorie";
				$resultCategorieParent = mysql_query($sqlCategorieParent);

				if($rowCategorieParent = mysql_fetch_array($resultCategorieParent)) {
					$categorieParent = $rowCategorieParent['supplier_category_parent'];
				}
				
				echo "<h3 class='title5' id='retour_fournisseurs'><a href='http://www.devicemed.fr/suppliers/'>Retour à la page de recherche d'un fournisseur</a></h3>";
				if($categorieParent == 0) {
					// On récupére le nom de la catégorie
					$sqlCategorieParent = "SELECT supplier_category_title FROM wordpress_dm_suppliers_categories WHERE ID=$categorie";
					$resultCategorieParent = mysql_query($sqlCategorieParent);

					if($rowCategorieParent = mysql_fetch_array($resultCategorieParent)) {
						$nomCategorie = $rowCategorieParent['supplier_category_title'];
					}

					echo "<h3 class='title5'>Résultat de recherche pour $nomCategorie :</h3>";
				}else {
					// On récupére le nom de la catégorie parente
					$sqlCategorieParent = "SELECT supplier_category_title FROM wordpress_dm_suppliers_categories WHERE ID=$categorieParent";
					$resultCategorieParent = mysql_query($sqlCategorieParent);

					if($rowCategorieParent = mysql_fetch_array($resultCategorieParent)) {
						$nomCategorieParent = $rowCategorieParent['supplier_category_title'];
					}

					// On récupére le nom de la catégorie
					$sqlCategorieParent = "SELECT ID, supplier_category_title FROM wordpress_dm_suppliers_categories WHERE ID=$categorie";
					$resultCategorieParent = mysql_query($sqlCategorieParent);

					if($rowCategorieParent = mysql_fetch_array($resultCategorieParent)) {
						$idCategorie = $rowCategorieParent['ID'];
						$nomCategorie = $rowCategorieParent['supplier_category_title'];
					}

					// On récupére la sous catégorie intermédiaire s'il y en a une
					$sqlSousCat = "SELECT supplier_souscategorie_parent FROM wordpress_dm_suppliers_categories WHERE ID=$idCategorie";
					$resultSousCat = mysql_query($sqlSousCat);

					if($rowSousCat = mysql_fetch_array($resultSousCat)) {
						$sousCatID = $rowSousCat['supplier_souscategorie_parent'];
					}

					if($sousCatID != 0) {
						$sqlNomSousCat = "SELECT supplier_souscategorie_name FROM wordpress_dm_suppliers_souscategories WHERE ID=$sousCatID";
						$resultNomSousCat = mysql_query($sqlNomSousCat);

						if($rowNomSousCat = mysql_fetch_array($resultNomSousCat)) {
							$souscategorieIntermediaire = $rowNomSousCat['supplier_souscategorie_name'];
						}
					}else {
						$souscategorieIntermediaire = '';
					}

					if($souscategorieIntermediaire != '') {
						echo "<h3 class='title5'>Résultat de recherche pour $nomCategorieParent > $souscategorieIntermediaire > $nomCategorie :</h3>";
					}else {
						echo "<h3 class='title5'>Résultat de recherche pour $nomCategorieParent > $nomCategorie :</h3>";
					}
				}

				// $sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE (supplier_category_id LIKE '%$categorie,%' OR supplier_category_id LIKE '%,$categorie%') AND supplier_status=1 ORDER BY supplier_name ASC";
				// On récupére toutes les catégories enfants
				$sqlCatEnfant = "SELECT ID FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=$categorie";
				$resultCatEnfant = mysql_query($sqlCatEnfant);
				$arraySqlCatEnfant = array();
				
				while($rowCatEnfant = mysql_fetch_array($resultCatEnfant)) {
					$idEnfant = $rowCatEnfant['ID'];
					$sqlIDEnfant = "supplier_category_id LIKE '$idEnfant,%' OR supplier_category_id LIKE '%,$idEnfant,%' OR supplier_category_id LIKE '%,$idEnfant' OR supplier_category_id = '$idEnfant'";
					
					array_push($arraySqlCatEnfant, $sqlIDEnfant);
				}
				
				$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers";
				$sqlFournisseurs .= " WHERE (";
					$sqlFournisseurs .= " (supplier_category_id LIKE '$categorie,%' OR supplier_category_id LIKE '%,$categorie,%' OR supplier_category_id LIKE '%,$categorie' OR supplier_category_id = '$categorie')";
				for($i = 0; $i < sizeOf($arraySqlCatEnfant);$i++) {
					$sqlIDEnfant2 = $arraySqlCatEnfant[$i];
					$sqlFournisseurs .= " OR ($sqlIDEnfant2)";
				}
				$sqlFournisseurs .= " )";
				$sqlFournisseurs .= " AND supplier_status=1";
				$sqlFournisseurs .= " ORDER BY supplier_name ASC";
				
				$resultFournisseurs = mysql_query($sqlFournisseurs);
				$nbFournisseurs = mysql_num_rows($resultFournisseurs);
			
				echo "<div id='bloc_supplier_search'>";
					if($nbFournisseurs > 0) {
						while($rowFournisseurs = mysql_fetch_array($resultFournisseurs)) {
							$idFournisseur = $rowFournisseurs['ID'];
							$nomFournisseur = $rowFournisseurs['supplier_name'];
							$supplierPremium = $rowFournisseurs['supplier_premium'];
							$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
							$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
							
							if($supplierPremium == '1') {
								echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'><b>$nomFournisseur</b></a></div>";
							}else {
								echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></div>";
							}
						}
					}else {
						echo "<p>Aucun fournisseur ne correspond à votre recherche.</p>";
					}
				echo "</div>";
			}elseif(isset($_GET['souscat']) && $_GET['souscat'] != '') {
				$sousCat = $_GET['souscat'];

				echo "<h3 class='title5' id='retour_fournisseurs'><a href='http://www.devicemed.fr/suppliers/'>Retour à la page de recherche d'un fournisseur</a></h3>";
				
				// On récupére l'ID de la catégorie parente
				$sqlCategorieParent = "SELECT supplier_category_parent FROM wordpress_dm_suppliers_souscategories WHERE ID=$sousCat";
				$resultCategorieParent = mysql_query($sqlCategorieParent);

				if($rowCategorieParent = mysql_fetch_array($resultCategorieParent)) {
					$categorieParentID = $rowCategorieParent['supplier_category_parent'];
				}

				// On récupére le nom de la catégorie parente
				$sqlNomCategorieParente = "SELECT * FROM wordpress_dm_suppliers_categories WHERE ID=$categorieParentID";
				$resultNomCategorieParente = mysql_query($sqlNomCategorieParente);

				if($rowNomCategorieParente = mysql_fetch_array($resultNomCategorieParente)) {
					$nomCategorieParent = $rowNomCategorieParente['supplier_category_title'];
				}

				// On récupére le nom de la catégorie intermédiaire
				$sqlCategorieIntermedaire = "SELECT supplier_souscategorie_name FROM wordpress_dm_suppliers_souscategories WHERE ID=$sousCat";
				$resultCategorieIntermedaire = mysql_query($sqlCategorieIntermedaire);

				if($rowCategorieIntermedaire = mysql_fetch_array($resultCategorieIntermedaire)) {
					$souscategorieIntermediaire = $rowCategorieIntermedaire['supplier_souscategorie_name'];
				}

				echo "<h3 class='title5'>Résultat de recherche pour $nomCategorieParent > $souscategorieIntermediaire :</h3>";

				// On récupére toutes les catégories de la sous catégorie
				$sqlCategorieSousCat = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_souscategorie_parent=$sousCat";
				$resultCategorieSousCat = mysql_query($sqlCategorieSousCat);
				$arrayFournisseurs = array();
				$i = 0;

				while($rowCategorieSousCat = mysql_fetch_array($resultCategorieSousCat)) {
					$categorie = $rowCategorieSousCat['ID'];

					// $sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers WHERE (supplier_category_id LIKE '%$categorie,%' OR supplier_category_id LIKE '%,$categorie%') AND supplier_status=1 ORDER BY supplier_name ASC";
					$sqlFournisseurs = "SELECT * FROM wordpress_dm_suppliers";
					$sqlFournisseurs .= " WHERE (";
						$sqlFournisseurs .= " (supplier_category_id LIKE '$categorie,%' OR supplier_category_id LIKE '%,$categorie,%' OR supplier_category_id LIKE '%,$categorie' OR supplier_category_id = '$categorie')";
						$sqlFournisseurs .= " OR (supplier_category_id IN (SELECT ID FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=$categorie))";
					$sqlFournisseurs .= " )";
					$sqlFournisseurs .= " AND supplier_status=1";
					$sqlFournisseurs .= " ORDER BY supplier_name ASC";
					// echo "sqlFournisseurs : ". $sqlFournisseurs;
					$resultFournisseurs = mysql_query($sqlFournisseurs);
					$nbFournisseurs = mysql_num_rows($resultFournisseurs);
				
					echo "<div id='bloc_supplier_search'>";
						if($nbFournisseurs > 0) {
							while($rowFournisseurs = mysql_fetch_array($resultFournisseurs)) {
								$idFournisseur = $rowFournisseurs['ID'];

								if(!in_array($idFournisseur, $arrayFournisseurs)) {
									$nomFournisseur = $rowFournisseurs['supplier_name'];
									$supplierPremium = $rowFournisseurs['supplier_premium'];
									$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
									$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
							
									if($supplierPremium == '1') {
										echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'><b>$nomFournisseur</b></a></div>";
									}else {
										echo "<div class='supplier_search'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></div>";
									}
									
									array_push($arrayFournisseurs, $idFournisseur);
								}
							}
							$i++;
						}
					echo "</div>";
				}

				if($i == 0) {
					echo "<p>Aucun fournisseur ne correspond à votre recherche.</p>";
				}
			}else {
		?>
			<h3 class='title5'>Quatre façons de trouver un fournisseur...</h3><br />
			<h3 class='title5'><p class='par_nom_motcle'>1- Par son nom ou par mot-clé :</p> <form name='search_suppliers' method='POST' action=''><input type='text' name='motCleFournisseur' placeHolder='Rechercher...' /><input type='submit' value='Rechercher' /></form></h3><br />
			<div id='suppliers_autocomplete'></div>
			<h3 class='title5'>
				2- Par son initiale : <a href='?initiale=*'>#</a>
				<?php
					$arrayAlphabetique = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
					
					for($i = 0; $i < sizeOf($arrayAlphabetique);$i++) {
						$lettre = $arrayAlphabetique[$i];
						echo "- <a href='?initiale=$lettre'>$lettre</a>";
					}
				?>
			</h3><br />
			<h3 class='title5'><a href='?type=liste'>3- Par la liste alphabétique complète</a></h3><br />
			<h3 class='title52'>4- Par sa catégorie de produits et services</h3>
			<div id='bloc_categories_fournisseurs'>
				<?php
					// On récupére les category parente et on créer une colonne toutes les 7 catégories
					$sqlCategorieParente = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent='0' ORDER BY supplier_category_title ASC";
					$resultCategorieParente = mysql_query($sqlCategorieParente);
					$i = 1;

					while($rowCategorieParent = mysql_fetch_array($resultCategorieParente)) {
						$idCategorieParent = $rowCategorieParent['ID'];
						$nomCategorieParent = $rowCategorieParent['supplier_category_title'];

						if($i == 1) {
							echo "<div class='colonne'>";
						}elseif($i == 8) {
							echo "</div><div class='colonne'>";
						}elseif($i == 15) {
							echo "</div><div class='colonne'>";
						}elseif($i == 20) {
							echo "</div>";
						}

						echo "<h4 class='title32'><a href='http://www.devicemed.fr/suppliers/?categorie=$idCategorieParent'>$nomCategorieParent</a></h4>";

						$sqlCategorieSupplier = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=$idCategorieParent ORDER BY supplier_category_title ASC";
						$resultCategorieSupplier = mysql_query($sqlCategorieSupplier);
						
						echo "<select name='souscat_$idCategorieParent'>";
						echo "<option value='0'>***Sous-catégories***</option>";

						/*** RECUPERATION DES SOUS CATEGORIES ***/	
						// On récupére les sous catégorie de la catégorie courante
						$sqlSousCategorieId = "SELECT *	 FROM wordpress_dm_suppliers_souscategories WHERE supplier_category_parent=$idCategorieParent";
						$resultSousCategorieId = mysql_query($sqlSousCategorieId);
						$nbSousCategorieId = mysql_num_rows($resultSousCategorieId);

						if($nbSousCategorieId > 0) {
							while($rowSousCategorie = mysql_fetch_array($resultSousCategorieId)) {
								$idSousCategorie = $rowSousCategorie['ID'];
								$nomSousCategorie = $rowSousCategorie['supplier_souscategorie_name'];

								echo "<option value='s_$idSousCategorie'>$nomSousCategorie</option>";

								// On récupére les catégories de la sous catégorie
								$sqlCategorieSupplier = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_souscategorie_parent=$idSousCategorie ORDER BY supplier_category_title";
								$resultCategorieSupplier = mysql_query($sqlCategorieSupplier);
								$nomSousCatTemp = '';

								while($rowCategorieSupplier = mysql_fetch_array($resultCategorieSupplier)) {
									$idCategorieSupplier = $rowCategorieSupplier['ID'];
									$titleCategorieSupplier = $rowCategorieSupplier['supplier_category_title'];

									echo "<option value='$idCategorieSupplier'>--- $titleCategorieSupplier</option>";
								}
							}
						}else {
							$sqlCategorieSupplier = "SELECT * FROM wordpress_dm_suppliers_categories WHERE supplier_category_parent=$idCategorieParent ORDER BY supplier_category_title";
							$resultCategorieSupplier = mysql_query($sqlCategorieSupplier);
							$nomSousCatTemp = '';

							while($rowCategorieSupplier = mysql_fetch_array($resultCategorieSupplier)) {
								$idCategorieSupplier = $rowCategorieSupplier['ID'];
								$titleCategorieSupplier = $rowCategorieSupplier['supplier_category_title'];

								echo "<option value='$idCategorieSupplier'>--- $titleCategorieSupplier</option>";
							}
						}
						/*** FIN RECUPERATION SOUS CATEGORIES ***/
						
						echo "</select>";

						$i++;
					}
				?>
			</div>
			<div class='bloc_infos_fournisseurs'>
				<div class='image_repertoire'><img src='<?php echo get_template_directory_uri(); ?>/images/sidebar-issues-icon.png' /></div>
				<div class='texte_repertoire'>
					Le répertoire existe en version papier au sein du Guide de l'acheteur.<br />
					<?php if ($session = DM_Wordpress_Members::session()): ?>
						<a href='http://www.devicemed.fr/wp-content/uploads/archives/pdf/juillet_aout2014.pdf' target='_blank'><b>Accéder au PDF du guide.</b></a>
					<?php else: ?>
						<span id='bloc_guide_acheteur2'><b>Accéder au PDF du guide.</b></span>
					<?php endif; ?>
				</div>
			</div>
			<div class='bloc_infos_fournisseurs'>
				<div class='image_repertoire'><img src='<?php echo get_template_directory_uri(); ?>/images/sidebar-supplier-registration-icon.png' /></div>
				<div class='texte_repertoire'>Vous êtes fournisseur des fabricants de dispositifs médicaux ?<br /><a href='http://www.devicemed.fr/suppliers/inscription'><b>Figurez, vous aussi dans le répertoire. C'est rapide et gratuit.</b></a></div>
			</div>
		<?php } ?>
		<!--<p class='noms_suppliers'>
			<a href='http://www.devicemed.fr/suppliers/accessoires-in-vitro/clippard-europe-s-a/5'>Clippard Europe S.A.</a><br />
			<a href='http://www.devicemed.fr/suppliers/pompes-et-valves/qosina/6'>Qosina</a>
		</p>-->
	</section>
</div><!-- .column-main -->
<!-- FOOTER -->
	<?php
		if($_GET['inscription_fournisseur'] == 1) {
			$success['general'] = 'L\'inscription a bien été prise en compte.';
		}

		$suppliers_users = new DM_Wordpress_Suppliers_Users_Model();
		$supplier_user_id = !empty($_GET['supplier_user_id']) ? (int) $_GET['supplier_user_id'] : 0;
		
		$errors = array();
		$sucess = array();

		$data = array(
			'supplier_id' => 0,
			'supplier_user_id' => $supplier_user_id,
			'supplier_user_login' => '',
			'supplier_user_lastname' => '',
			'supplier_user_firstname' => '',
			'supplier_user_e-mail' => '',
			'supplier_user_sex' => 'M',
			'supplier_user_address' => '',
			'supplier_user_postalcode' => '',
			'supplier_user_city' => '',
			'supplier_user_country' => '',
			'supplier_user_created' => date('Y-m-d H:i:s'),
			'supplier_user_modified' => date('Y-m-d H:i:s'),
			'supplier_user_status' => '1',
			'supplier_user_new_password' => '',
			'supplier_user_new_password_confirm' => '',
			'supplier_user_password' => '',
			'supplier_user_password_confirm' => ''
		);

		if (!empty($_GET))
		{
			foreach ($data as $field => $value)
			{
				if (isset($_GET[ $field ]))
				{
					$data[ $field ] = trim(stripslashes($_GET[ $field ]));
				}
			}
			if (!$data['supplier_user_e-mail'])
			{
				$errors['supplier_user_e-mail'] = 'email manquant.';
			}
			else
			{
				$data['supplier_user_e-mail'] = strtolower($data['supplier_user_e-mail']);
				if (!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $data['supplier_user_e-mail']))
				{
					$errors['supplier_user_e-mail'] = 'email invalide.';
				}
			}
			if (!$supplier_user_id)
			{
				if (!$data['supplier_user_e-mail'])
				{
					$errors['supplier_user_e-mail'] = 'Identifiant manquant.';
				}
				else
				{
					$duplicate = $suppliers_users->admin_edit_check_duplicate_login($data['supplier_user_e-mail']);
					if ($duplicate)
					{
						$errors['supplier_user_e-mail'] = 'Cet identifiant est déjà utilisé.';
					}
				}
			}
			
			if(!$data['supplier_user_password']) {
				$errors['supplier_user_password'] = 'Mot de passe manquant.';
			}
			
			if (!$errors)
			{
				$data['supplier_user_password'] = md5(md5($data['supplier_user_password']).DM_Wordpress_Config::get('Security.Password.Salt'));
				$data['supplier_user_login'] = $data['supplier_user_e-mail'];

				$saved = $suppliers_users->admin_edit_update_profile($data, $supplier_user_id);

				
				if ($saved)
				{
					$to      = $data['supplier_user_e-mail'];
					$subject = 'DeviceMed.fr - Création d\'un compte fournisseur';
					$message = 'Bonjour ! Bienvenue sur DeviceMed.fr.<br />Votre inscription a bien été prise en compte, vous pouvez désormais vous connecter à votre compte avec les identifiants suivants :<br /><br />';
					$message .= '<a href=\'http://www.device-med.fr/members/login\'>http://www.device-med.fr/members/login</a><br />';
					$message .= 'Identifiant : '. $data['supplier_user_e-mail'] .'<br />Mot de passe : Seul vous le connaissez !<br /><br />';
					$message .= 'Vous pourrez gérer votre société une fois qu\'une société sera assigné à votre compte, par un administrateur.';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					
					if (!mail($to, $subject, $message, $headers))
					{
						$errors['general'] = 'Une erreur est survenue lors de l\'envoi du message de confirmation.';
					}
					else
					{
						header('Location:http://www.device-med.fr/?inscription_fournisseur=1');
						$data['supplier_user_e-mail'] = '';
					}
				}
			}
		}
	?>
	<div id="sidebar" class="column col-md-3 col-sm-4 column-sidebar">
		<!--<section id="sidebar-annual-guide">
			<div class="right-side">
				<h1 class="title">Guide annuel</h1>
				<span class="download">Télécharger</span>
			</div>
			<div class="left-side">
				<img src="<?php echo get_template_directory_uri(); ?>/images/devicemed-issue-sample.png" />
			</div>
		</section>-->
		<section id="sidebar-fiches">
			<header>
				<div class="right-side">
					<h1 class="title">Fournisseurs partenaires</h1>
				</div>
			</header>	
			<article>
				<?php
					// On récupére les fournisseurs partenaires
					$sqlPartners = "SELECT * FROM wordpress_dm_suppliers WHERE supplier_premium=1";
					// echo "sqlPartners : ". $sqlPartners;
					$resultPartners = mysql_query($sqlPartners);
					$nbPartners = mysql_num_rows($resultPartners);
					$j = 1;

					while($rowPartners = mysql_fetch_array($resultPartners)) {
						$idFournisseur = $rowPartners['ID'];
						$nomFournisseur = $rowPartners['supplier_name'];
						$nomFournisseur2 = DM_Wordpress_Suppliers_Model::string_sanitize_nicename($nomFournisseur);
						$nomFournisseur2 = str_replace(' ','-', $nomFournisseur2);
						
						if($j == $nbPartners) {
							echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></h3>";
						}else {
							echo "<h3 class='title2'><a href=\"http://www.devicemed.fr/suppliers/$nomFournisseur2/$idFournisseur?premiere_visite=1\" target='_blank'>$nomFournisseur</a></h3><br />";
						}

						$j++;
					}
				?>
			</article>
		</section>
		<?php
			$banniere_model = new DM_Wordpress_Banniere_Model();
			$banniereAfficher = $banniere_model->display_banniere(1, $_SESSION['arrayBanniereAfficher']);
			
			$banniere_id = $banniereAfficher[0]['ID'];
			$_SESSION['arrayBanniereAfficher'] .= ','. $banniere_id;
			$image = $banniereAfficher[0]['image'];
			$lien = $banniereAfficher[0]['lien'];
			
			if($banniere_id != '') {
		?>
			<section id='sidebar-banniere'>
			<?php
				echo "<a href='http://www.device-med.fr/?url=$lien&id=$banniere_id' id='$banniere_id' target=_blank><img src='http://www.device-med.fr/wp-content/uploads/banniere/$image' /></a>";
			?>
			</section>
		<?php } ?>
		<!--<section id="sidebar-supplier-registration">
			<header>
				<div class="left-side">
					<img src="<?php echo get_template_directory_uri(); ?>/images/sidebar-supplier-registration-icon.png"" />
				</div>
				<div class="right-side">
					<h1 class="title">S'inscrire comme fournisseur</h1>
				</div>
			</header>
			<div class="supplier-registration-form">
				<form method='GET' action="http://www.device-med.fr/">
					<input type="text" name="supplier_user_e-mail" value="<?php echo $data['supplier_user_e-mail']; ?>" placeholder="email" />
					<div><?php if($errors['supplier_user_e-mail']) { ?><div class='form-error'><?php echo $errors['supplier_user_e-mail'] ?></div><?php } ?></div>
					<input type="password" name="supplier_user_password" value="" placeholder="Mot de passe" />
					<div><?php if($errors['supplier_user_password']) { ?><div class='form-error'><?php echo $errors['supplier_user_password'] ?></div><?php } ?></div>
					<div><?php if($success['general']) { ?><div class='form-success'><?php echo $success['general'] ?></div><?php } ?><?php if($errors['general']) { ?><div class='form-error'><?php echo $errors['general'] ?></div><?php } ?></div>
					<input type="submit" value="Valider" />
				</form>
			</div>
		</section>-->
		<?php include_once('agenda.php'); ?>
		<section id="sidebar-issues">
			<header>
				<div class="right-side">
					<h1 class="title"><a href='http://www.devicemed.fr/archives'>Dernier numéro</a></h1>
				</div>
			</header>	
			<?php
				$archiveModel = new DM_Wordpress_Archive_Model();
				$archives = array();
				$urlTemp = get_bloginfo('url');
				
				foreach ($archiveModel->get_archives(1) as $archive)
				{
					$titreArchive = $archive['titre_archive'];
					$urlImg = $urlTemp ."/wp-content/uploads/archives/apercu/". $archive['apercu_archive'];
					$lienPdf = $urlTemp ."/wp-content/uploads/archives/pdf/". $archive['pdf_archive'];
					
					echo "<a href='$lienPdf' target='_blank'><article class='article_numero'>";
						echo "<div class='right-side'>";
							echo "<span class='issue'>$titreArchive</span>";
							echo "<span class='download'>Consulter ce numéro</span>";
						echo "</div>";
						echo "<div class='left-side' style=\"background-image:url('$urlImg');\">";
							// echo "<img src='$urlImg' />";
						echo "</div>";
					echo "</article></a>";
				}
			?>
			<a href="<?php echo $urlTemp; ?>/archives" class="more">Consulter d'autres numéros</a>
		</section>
		<!--<section id="sidebar-issues">
			<header>
				<div class="right-side">
					<h1 class="title">Guide de l'acheteur</h1>
				</div>
			</header>	
			<?php
				if ($session = DM_Wordpress_Members::session()):
					echo "<a href='http://www.devicemed.fr/wp-content/uploads/archives/pdf/juillet_aout2014.pdf' target='_blank'><article>";
						echo "<div class='right-side'>";
							echo "<span class='issue'>Guide de l'acheteur</span>";
							echo "<span class='download'>Consulter le guide</span>";
						echo "</div>";
						echo "<div class='left-side' style=\"background-image:url('http://www.devicemed.fr/wp-content/uploads/archives/apercu/juillet_aout2014.PNG');\">";
							// echo "<img src='$urlImg' />";
						echo "</div>";
					echo "</article></a>";
				else:
					echo "<article id='bloc_guide_acheteur'>";
						echo "<div class='right-side'>";
							echo "<span class='issue'>Guide de l'acheteur</span>";
							echo "<span class='download'>Consulter le guide</span>";
						echo "</div>";
						echo "<div class='left-side' style=\"background-image:url('http://www.devicemed.fr/wp-content/uploads/archives/apercu/juillet_aout2014.PNG');\">";
							// echo "<img src='$urlImg' />";
						echo "</div>";
					echo "</article>";
				endif;
			?>
		</section>-->
		<!--<section id="sidebar-video">
			<header>
				<h1 class="title">Vidéo</h1>
			</header>
			<div class="video-wrapper">
				<img src="http://placehold.it/350x250" alt="" />
			</div>
		</section>-->
		<!--<section id="sidebar-agenda">
			<header>
				<div class="left-side">
					<img src="<?php echo get_template_directory_uri(); ?>/images/sidebar-supplier-registration-icon.png"" />
				</div>
				<div class="right-side">
					<h1 class="title">Agenda</h1>
				</div>
			</header>
			<div class="events">Aucun événement à venir</div>
		</section>-->
	</div> 
	</div><!-- .column-content -->

<footer id="footer">
	<div class="copyright">Deviced.fr est une marque de Vogel Business Media. <a href='http://www.devicemed.de/' target='_blank'>Cliquer ici pour découvrir le site de DeviceMed Allemagne</a>.</div>
	<div class="pages"><?php devicemed_footer_menu('Bas de page - Première ligne'); ?></div>
	<div class="credits"><?php devicemed_footer_menu('Bas de page - Deuxième ligne'); ?></div>
</footer>

</div><!-- .container -->
<?php wp_footer(); ?>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.bxslider.min.js"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/colorbox/jquery.colorbox-min.js"></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$("select").change(function() {
			var categorie = $(this).val();
		
			if(categorie.search("s_") != -1) {
				categorie = categorie.replace("s_","");
				document.location.href ='http://www.devicemed.fr/suppliers/?souscat='+ categorie;
			}else {
				document.location.href ='http://www.devicemed.fr/suppliers/?categorie='+ categorie;
			}
		});
		
		$("input[name='motCleFournisseur']").keyup(function() {
			var fournisseur = $(this).val();
			
			if(fournisseur != '') {
				$.ajax({
					url: 'http://www.devicemed.fr/wp-content/themes/devicemed-responsive/suppliers/functions.php?pattern=rechercheFournisseur&q='+ fournisseur,
					dataType: 'html',
					success: function(json) {
						$("#suppliers_autocomplete").empty();
						
						if(json != '') {
							var suppliers_name = json.split('|');
							
							for(var i=0; i < suppliers_name.length;i++) {
								var supplier_name = suppliers_name[i];
								supplier_name = $.parseHTML(supplier_name);

								$("#suppliers_autocomplete").append("<div class='supplier_name_autocomplete' id='supplier_name_autocomplete"+ i +"'></div>");
								$("#supplier_name_autocomplete"+ i).html(supplier_name);
							}
							
							$("#suppliers_autocomplete").show();

							$(".supplier_name_autocomplete").click(function() {
								var supplier_name = $(this).html();
								$("input[name='motCleFournisseur']").val(supplier_name);
								$("#suppliers_autocomplete").hide();
								setTimeout(function(){ $("form[name='search_suppliers']").submit(); }, 500);
							});
						}else {
							$("#suppliers_autocomplete").hide();
						}
					}
				});
			}else {
				$("#suppliers_autocomplete").hide();
			}
		});
	});
</script>
</body>
</html>
<!-- FIN FOOTER -->
