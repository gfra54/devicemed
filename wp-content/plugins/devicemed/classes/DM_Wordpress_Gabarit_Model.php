<?php

class DM_Wordpress_Gabarit_Model extends DM_Wordpress_Model
{
	protected $table = 'dm_gabarits_newsletter';
	protected $fields = array(
		'nom_gabarit'			=> '',
		'contenu_gabarit' => '',
		'date_created' => '',
		'date_modified' => ''
	);
	public function save($data, $gabarit_id = '', $dynamique = 0)
	{
		global $wpdb;
		
		if($dynamique == 0) {
			$nom_gabarit = $data['nom_gabarit'];
			$contenu_gabarit = $data['contenu_gabarit'];
			$mail_test = $data['mail_test'];
			$date_created = date('Y-m-d H:i:s');
			$date_modified = date('Y-m-d H:i:s');

			if($gabarit_id == '') {
				$sqlSave =  "INSERT INTO ".$this->table()."(nom_gabarit, contenu_gabarit, mail_test, date_created, date_modified)";
				$sqlSave .= " VALUES ('$nom_gabarit','$contenu_gabarit', '$mail_test', '$date_created', '$date_modified')";
			}else {
				$sqlSave =  "UPDATE ".$this->table()." SET nom_gabarit='$nom_gabarit', contenu_gabarit=$contenu_gabarit, mail_test='$mail_test', date_modified='$date_modified'";
				$sqlSave .= " WHERE ID=$gabarit_id";
			}
		}else {
			$nom_gabarit = $data['nom_gabarit'];
			$mail_test = $data['mail_test'];
			$nom_pub = $_POST['nom_pub'];
			$nom_entreprise_pub = $_POST['nom_entreprise_pub'];
			$lien_pub = $_POST['lien_pub'];
			$contenu_pub =  stripslashes($_POST['contenu_pub']);
			$date_created = date('Y-m-d H:i:s');
			$date_modified = date('Y-m-d H:i:s');
		
			if(!$_FILES['image_pub']['error']) {
				$image_pub = $_FILES['image_pub']['name'];
			}

			$sqlSave =  "UPDATE ".$this->table()." SET nom_gabarit='$nom_gabarit', nom_pub='$nom_pub', nom_entreprise_pub='$nom_entreprise_pub', lien_pub='$lien_pub', contenu_pub='$contenu_pub', mail_test='$mail_test', date_modified='$date_modified'";
			if(!$_FILES['image_pub']['error']) {
				$sqlSave .= ", image_pub='". $image_pub ."'";
			}
			$sqlSave .= " WHERE ID=$gabarit_id";
		}
		
		if($wpdb->query($sqlSave)) {
			return $wpdb->insert_id;
		}else {
			return FALSE;
		}
	}
	public function get_contenu_mail_dynamique($gabarit_id, $mail, $avant_civilite='Cher', $civilite='Monsieur', $nom='jean', $prenom='test') {
		if($civilite == 'Monsieur' && $avant_civilite == '') {
			$avant_civilite = 'Cher';
		}elseif($civilite == 'Madame' && $avant_civilite == '') {
			$avant_civilite = 'Chère';
		}
	
		// On récupére les infos de la pub
		$contenu_string = '<!DOCTYPE html>';
		$contenu_string .= '<html>';
		$contenu_string .= '<body>';
			$contenu_string .= '<div style="width:850px !important;margin:0 auto;">';
			$contenu_string .= '<table cellspacing="0" cellpadding="0" width="850" border="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin:auto;" id="wrapper">'; 			
		$contenu_string .= '<tbody><tr>'; 				
		$contenu_string .= '<td width="700" valign="top" style="background-color:#F1F1F1">';				 					
		$contenu_string .= "<table style='border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;margin-left:10px;' width='700'>";						 						
			$contenu_string .= '<tbody>';
				$contenu_string .= '<tr>';
					$contenu_string .= '<td>';
						$contenu_string .= '<a style="font-family:Arial;font-size:12px;text-decoration:none;" href="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/newsletter/newsletter16-15.php?mail='. $mail .'">Si la newsletter ne s\'affiche pas correctement, veuillez cliquer ici.</a>';
					$contenu_string .= '</td>';
				$contenu_str .= '</tr>';
				$contenu_string .= '<tr>';
					$contenu_string .= '<td>';
						$contenu_string .= '<a style="border:none" href="http://www.devicemed.fr/"><img width="700" height="91" title="logo" alt="newsletter" src="http://www.device-med.fr/wp-content/uploads/newsletter/original.jpg"></a>';
					$contenu_string .= '</td>'; 						
				$contenu_string .= '</tr>';	
				// $contenu_string .= '<tr><td><br /><b>'. $avant_civilite .' '. $civilite .' '. $nom .',</b><br /></td></tr>';				 					
			$contenu_string .= '</tbody>';
		$contenu_string .= '</table>';		
		// $contenu_string .= '<p style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; margin-left:10px; margin-top:0px; margin-bottom:0px; text-align:left">Annonce</p>';				
		// $contenu_string .= '<table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;margin-left:10px;margin-top:10px;margin-bottom:10px;" width="700" id="top_news">';
			// $contenu_string .= '<tbody>';
				// $contenu_string .= '<tr>';
					// $contenu_string .= '<td align="center">';
						// $urlBanniere = urlencode("http://www.ni.com/gate/gb/GB_SEMINARSLIDES103/F?cid=Advertising-701i0000001KXrJAAW-France-none&metc=mt8pck");
						// $contenu_string .= '<a target="_blank" href="http://www.device-med.fr/?url='. $urlBanniere .'&id=56"><img src="http://devicemed.fr/wp-content/uploads/banniere/medical_468x60.gif" border="0" alt="" style="width:468px;text-align:center;"></a>';
					// $contenu_string .= '</td>';
				// $contenu_string .= '</tr> ';						
			// $contenu_string .= '</tbody>';
		// $contenu_string .= '</table>';
		// $contenu_string .= "\n\r";
		$contenu_string .= '<table  style="border-collapse:collapse;mso-table-lspace:0pt; mso-table-rspace:0pt;margin-left:10px;margin-top:10px;" width="700" id="top_news">';
			$contenu_string .= '<tbody>';
				$contenu_string .= '<tr>';
					$contenu_string .= '<td align="left">';
						$contenu_string .= "<h1 style='font-size:20px;color:#000000;font-family:Arial;'>Sommaire de la newsletter du 22 juillet 2015</h1>";
					$contenu_string .= '</td>';
				$contenu_string .= '</tr> ';						
			$contenu_string .= '</tbody>';
		$contenu_string .= '</table>';
		$contenu_string .= '<table width="700" style="border-bottom:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px;" id="inhaltsverzeichnis">';
			$contenu_string .= '<tbody>';
				$contenu_string .= '<tr>';
					$contenu_string .= '<td>';
						$contenu_string .= '<ul style="padding-left:20px;margin-top:0px;margin-bottom:0;">';

						// On récupére les derniers articles
						$recentPosts = new WP_Query();
						$recentPosts->query('showposts=6');
						$nbPost = 0;

						while ($recentPosts->have_posts()) : $recentPosts->the_post();
							// if($nbPost > 0) {
								// On récupére la source de la photo
								$idPost = get_the_ID();
								$titreArticle = get_the_title();
								$titreArticle = str_replace("Forums LNE sur la réglementation", "Forums sur la réglementation", $titreArticle);
								
								if ($thumbnail = devicemed_get_post_featured_thumbnail($idPost)):
									$sourcePhoto = $thumbnail->post_title;
									
									if($sourcePhoto == 'Jeong lab, Univ. of Colorado') {
										$sourcePhoto = 'NIH';
									}elseif($sourcePhoto == 'Bêta Gamma Services GmbH') {
										$sourcePhoto = 'Beta Gamma Service GmbH';
									}
								endif;

								// if($sourcePhoto != 'Watson-Marlow') {
									$contenu_string .= "\n\r";
									$contenu_string .= '<li style="font-family:Arial;">';
										$contenu_string .= '<a style="color:#333333;text-decoration:none;" href="'.get_permalink().'" target="_blank">';
											$contenu_string .= '<span style="color:#333333;font-size:14px;line-height:19px;text-decoration:none;color:#333333 !important;">'.$sourcePhoto.'&nbsp;- </span>';
										$contenu_string .= '</a><!----><a style="color:#005ea8;font-size:14px;text-decoration:none;" href="'.get_permalink().'" target="_blank">';
											$contenu_string .= '<span style="color:#005ea8;font-size:14px;line-height:19px;text-decoration:none;">'.$titreArticle.'</span>';
										$contenu_string .='</a>';
									$contenu_string .= '</li><!---->';
									$contenu_string .= "\n\r";
									//$contenu_string .= '</li>';
								// }
							// }
							$nbPost++;
						endwhile;
						$contenu_string .= '</ul>'; 									
					$contenu_string .= '</td>';								
				$contenu_string .= '</tr>';		
			$contenu_string .= '</tbody>';
		$contenu_string .= '</table>';	
		$contenu_string .= "\n\r";		
		$contenu_string .= '<table width="700" style="margin-top:10px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px;" id="content">';
			$contenu_string .= '<tbody>';
				// On récupére les derniers articles
				$recentPosts = new WP_Query();
				$recentPosts->query('showposts=6;');
				$i = 0;
				
				while ($recentPosts->have_posts()) : $recentPosts->the_post();
					// if($i > 0) {
						// On récupére la source de la photo
						$lienArticle = get_permalink();
						$titreArticle = get_the_title();
						$titreArticle = str_replace("Forums LNE sur la réglementation", "Forums sur la réglementation", $titreArticle);
						
						$idPost = get_the_ID();
						
						if ($thumbnail = devicemed_get_post_featured_thumbnail($idPost)):
							$urlPhoto = $thumbnail->url;
							$sourcePhoto = $thumbnail->post_title;
									
							if($sourcePhoto == 'Jeong lab, Univ. of Colorado') {
								$sourcePhoto = 'NIH';
							}elseif($sourcePhoto == 'Bêta Gamma Services GmbH') {
								$sourcePhoto = 'Beta Gamma Service GmbH';
							}
						endif;				
						
						/*if($i == 0) {
							$contenu_string .= '<tr>';
						}else {
							$contenu_string .= '--><tr>';
						}*/

						if($i == 2) {
							// TEXT AD
							// $urlTextAd = urlencode("http://p.protolabs.fr/medical-white-paper?utm_campaign=fr-sos&utm_medium=email&utm_source=devicemed&utm_content=en-medwp-0715");
							
							// $contenu_string .= "\n\r";
							// $contenu_string .= '<tr><td colspan=2 style="border-top:1px dotted #555;padding-left:90px;"><p style="line-height:9.5pt;mso-line-height-rule:exactly;margin:0px;margin-top:10px;">';
								// $contenu_string .= '<span style="font-size:12px;font-family:Helvetica,Arial,sans-serif;color:#999;">Annonce</span>';
							// $contenu_string .= '</p></td></tr>';	
							// $contenu_string .= '<tr>';
								// $contenu_string .= '<td colspan=2 width="128" valign="top" style="width:128px;padding-bottom: 10px;padding-left:90px;">';
									// $contenu_string .= "\n\r";
									// $contenu_string .= '<div style="padding:10px;width:500px;border:1px solid #333;">';
									// $contenu_string .= "\n\r";
									// $contenu_string .= '<a href="http://www.device-med.fr/?url='. $urlTextAd .'&id=57" target="_blank">';
									// $contenu_string .= "\n\r";
									// $contenu_string .= '<img style="border:solid 1px #FFFFFF;padding-right:10px;" width="100" height="auto" align="left" alt="img6" src="http://www.devicemed.fr/wp-content/uploads/banniere/medical-prototyping.jpg" />';
									// $contenu_string .= "\n\r";
									// $contenu_string .= '</a>';
									// $contenu_string .= "\n\r";
									// $contenu_string .= '<p style="margin:0px;padding-left:140px;">';
										// $contenu_string .= '<a style="margin:0px;text-decoration:none;" href="http://www.device-med.fr/?url='. $urlTextAd .'&id=57" target="_blank"><span style="font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;color:black;">Le prototypage pour le secteur médical</span></a>';
									// $contenu_string .= '</p>';
									// $contenu_string .= "\n\r";
									// $contenu_string .= "<p style='padding-left:140px;font-size:12px;line-height:21px;font-family:Arial;color:#333;margin:0px;'>";
									// $contenu_string .= "Ce livre blanc examine les diverses options de fabrication rapide à la disposition des ingénieurs-concepteurs et ";
									// $contenu_string .= "\n\r";
									// $contenu_string .= "développeurs de produits du secteur médical. Analysez points forts et points faibles de chaque processus, ";
									// $contenu_string .= "facilitant les choix de matériaux adaptés pour votre application.";
									// $contenu_string .= "<a style='text-decoration:none;' href='http://www.device-med.fr/?url=$urlTextAd&id=57' target='_blank'>Télécharger</a>.";
									// $contenu_string .= "\n\r";				            	
								// $contenu_string .= '</div></td>';
							// $contenu_string .= '</tr>';	
						}

						// if($sourcePhoto != 'Watson-Marlow') {
							$contenu_article = get_the_excerpt();
							$contenu_article = str_replace("Le salon EPHJ-EPMT-SMT a franchi", "Le salon a franchi", $contenu_article);
							$contenu_article = str_replace("Molex acquiert Soligie et ses", "Le fabricant acquiert Soligie et ses", $contenu_article);
							
							$contenu_string .= "\n\r";		
							$contenu_string .= '<tr>';
								$contenu_string .= '<td width="128" valign="top" style="width:128px;padding-bottom:15px;padding-top:10px;border-top:1px dotted #555;"><a href="'.$lienArticle.'" target="_blank"><img style="border:solid 1px #FFFFFF;" width="120" height="auto" align="left" alt="img6" src="'.$urlPhoto.'" /></a></td><td style="width:557px;padding-bottom:15px;padding-top:10px;border-top:1px dotted #555" width="557" valign="top">';
									$contenu_string .= '<p style="line-height:9.5pt;mso-line-height-rule:exactly;margin:0px;">';
										$contenu_string .= '<a style="margin:0px;text-decoration:none;" href="'.$lienArticle.'" target="_blank">';
										$contenu_string .= "\n\r";
										$contenu_string .= '<span style="font-size:12px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;color:#333333;">'.$sourcePhoto.'</span></a>';
									$contenu_string .= '</p>';
									$contenu_string .= "\n\r";
									$contenu_string .= '<p style="margin:0px;">';
										$contenu_string .= '<a style="margin:0px;text-decoration:none;" href="'.$lienArticle.'" target="_blank"><span style="font-size:16px;font-weight:bold;font-family:Helvetica,Arial,sans-serif;color:#005ea8;">'.$titreArticle.'</span></a>';
									$contenu_string .= '</p>';
									$contenu_string .= "<p style='font-size:14px;line-height:21px;font-family:Arial;color:#333;margin:0px;'>".$contenu_article."<a style='text-decoration:none;' href='$lienArticle' target='_blank'><span style='color:#005ea8;'>Lire la suite</span></a></p>"; 				            	
								$contenu_string .= '</td>';
							$contenu_string .= '</tr>';	
							$contenu_string .= "\n\r";
						// }
						/*if($i == 7) {
							$contenu_string .= '</tr>';
						}else {
							$contenu_string .= '</tr><!--';
						}*/
					// }
					$i++;
				endwhile;
			$contenu_string .= '</tbody>';
		$contenu_string .= '</table><!--';			
		$contenu_string .= '--><table width="704" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:0px" id="footer"><tbody><tr><td style="font-family:Arial; font-size:12px"><table cellspacing="0" width="702">';
			 $contenu_string .= '<tbody>';
				 $contenu_string .= '<tr>';
					 $contenu_string .= '<td style="padding-bottom:10px;padding-top:10px;padding-left:10px;padding-right:10px;background-color:#c7c7c7">';
					 $contenu_string .= '<table width="700">';
						 $contenu_string .= '<tbody>';
							 $contenu_string .= '<tr>';
								 $contenu_string .= '<td align="left"><a href="http://news.vogel.de/inxmail2/d?q00wueoq0eqfngbii000000000000000ietwqbri3277"><img src="http://www.devicemed.fr/wp-content/themes/devicemed-responsive/images/newsletter/nl20/vogel_logo.gif" alt="Vogel Logo"></a></td>';
								 $contenu_string .= '<td align="right"></td>';
							 $contenu_string .= '</tr>';
						 $contenu_string .= '</tbody>';
					 $contenu_string .= '</table>';
					 $contenu_string .= '</td>';
				 $contenu_string .= '</tr><!--';
				 $contenu_string .= '--><tr>';
					 $contenu_string .= '<td align="center" style="font-size:11px;font-family:Arial,Helvetica,sans-serif;padding:10px;background-color:#d2d2d2;text-align:center;"><a style="text-decoration:none;" href="http://www.devicemed.fr/nous-contacter"><span style="font-size:12px;color:#b30f1d;text-align:center;">Contact</span></a></td>';
				 $contenu_string .= '</tr><!--';
				 $contenu_string .= '--><tr>';
					 $contenu_string .= '<td style="PADDING-BOTTOM: 10px; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND-COLOR: #616161">';
					 $contenu_string .= '<p style="FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #ffffff; LINE-HEIGHT: 18px">© The French language edition of DeviceMed is a publication of Evelyne Gisselbrecht, licensed by Vogel Business Media GmbH & Co. KG, 97082 Wuerzburg/Germany.<br>';
				     $contenu_string .= "\n\r";
					 $contenu_string .= '© Copyright of the trademark « DeviceMed » by Vogel Business Media GmbH & Co. KG, 97082 Wuerzburg/Germany.<br>';
					 $contenu_string .= "\n\r";
					 $contenu_string .= 'Responsable du contenu rédactionnel sur <a style="text-decoration:none;color:#fff;" href="http://www.devicemed.fr/">www.devicemed.fr</a> : Evelyne Gisselbrecht, éditrice de DeviceMed, 33 rue du Puy-de-Dôme, 63370 Lempdes France</p>';
					 $contenu_string .= '</td>';
				 $contenu_string .= '</tr>';
			 $contenu_string .= '</tbody>';
		 $contenu_string .= '</table><!--';
		 $contenu_string .= '--><p></p></td></tr><tr><td style="text-align:center;font-family:Arial;font-size:11px">Le bulletin est adressé à '. $mail .'</td></tr>';
		 $contenu_string .= "\n\r";
		 $contenu_string .= '<tr style="font-family:Arial;font-size:11px;color:#005ea8;text-decoration:underline;text-align:center;"><td><a style="text-decoration:none;" href="http://www.devicemed.fr/newsletter/desinscrire/'. $mail .'"><span>Se désabonner</span></a></td></tr></tbody></table></td><td width="10" valign="top"></td><td width="160" valign="top"><table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tbody><tr><td style="padding-bottom:10px;"><a target="_blank" href="http://www.device-med.fr/?url=http://www.devicemed.de/&id=60"><img src="http://www.device-med.fr/wp-content/uploads/newsletter/devicemed_de.jpg" width="127px" /></a></td></tr>';
		 $contenu_string .= "\n\r";
		 // $contenu_string .= "<tr><td><div style='width:100%;padding-top:15px;'><a href='http://www.devicemed.fr/wp-content/uploads/archives/pdf/003_gesamt.pdf' target='_blank'>";
		 // $contenu_string .= "\n\r";
		 // $contenu_string .= "<img width='127px' src='http://devicemed.fr/wp-content/uploads/newsletter/pave_magazine.png' /></a></div>";
		 $contenu_string .= "<tr><td><div style='width:100%;padding-top:15px;'><a href='http://www.devicemed.fr/wp-content/uploads/archives/pdf/guide_acheteur2015.pdf' target='_blank'>";
		 $contenu_string .= "\n\r";
		 $contenu_string .= "<img width='127px' src='http://devicemed.fr/wp-content/uploads/banniere/pave_guide.jpg' /></a></div>";
		 //$contenu_string .= "\n\r";
		 // $contenu_string .= "<div style='color:#3336ff;text-transform:uppercase;font-size: 12px;font-weight: bold;font-family: Helvetica,Arial,sans-serif;color: #005ea8;width: 100%;padding-top:5px;text-align:center;'>Découvrez notre dernier numéro</div></td></tr>";
	     // $contenu_string .= "\n\r";
		 $contenu_string .= '</tbody></table></td></tr></tbody></table></div>';
		$contenu_string .= '</body></html>';
		
		// $contenu_string =utf8_decode($contenu_string);
		// $contenu_string = str_replace("?","'", $contenu_string);
		// $contenu_string = str_replace("'mail=","?mail=", $contenu_string);
		// $contenu_string = str_replace("%20","", $contenu_string);
		
		// echo $contenu_string;
		// exit();
		
		return $contenu_string;
	}
	public function envoi_mail_newsletter_dynamique($gabarit_id, $mail_test = '') {
		if($mail_test != '') {
			$contenu_string = $this->get_contenu_mail_dynamique($gabarit_id, $mail_test);
			
			$to = "$mail_test";
			$subject = "Implant cérébral microscopique – BGS mise gros sur les rayons gamma – Forums LNE sur la règlementation";
			$message = $contenu_string;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= "From: \"DeviceMed France\"<info@devicemed.fr>";

			if(mail($to, $subject, $message, $headers)) {
				return true;
				exit();
			}else {
				return false;
				exit();
			}
		}else {
			// On récupére tous les mails inscrits à la newsletter et qui accepte la newsletter devicemed
			global $wpdb;
			/*****
				ENVOI DEFINITIF
			*****/
			// $inscriptionNewsletter = $wpdb->get_results("SELECT * FROM wordpress_dm_newsletter WHERE offre_devicemed=1 AND actif=1");
			
			/*****
				ENVOI TEST
			*****/
			// $inscriptionNewsletter = $wpdb->get_results("SELECT * FROM wordpress_dm_newsletter_test WHERE offre_devicemed=1 AND actif=1");
			
			/***** 
				ENVOI TEST AVANT DEFINITIF
			*****/
			// $inscriptionNewsletter = $wpdb->get_results("SELECT * FROM wordpress_dm_newsletter_test WHERE offre_devicemed=1 AND actif=1 AND ID IN(25,10,8)");
			
			/*****
				ENVOI TEST PERSO
			*****/
			$inscriptionNewsletter = $wpdb->get_results("SELECT * FROM wordpress_dm_newsletter_test WHERE offre_devicemed=1 AND actif=1 AND ID IN(19,20,21,30)");
			
			/*****
				ENVOI TEST PERSO + PATRICK
			*****/
			// $inscriptionNewsletter = $wpdb->get_results("SELECT * FROM wordpress_dm_newsletter_test WHERE offre_devicemed=1 AND actif=1 AND ID IN(19,20,21,26,30)");
			
			/*****
				ENVOI TEST PERSO AVEC DAMIEN
			*****/
			// $inscriptionNewsletter = $wpdb->get_results("SELECT * FROM wordpress_dm_newsletter_test WHERE offre_devicemed=1 AND actif=1 AND ID IN(19,20,21, 22,30)");
			
			
			// print_r($inscriptionNewsletter);
			$errors = '';
			$nbMailEnvoyé = 0;
			
			set_time_limit(3600);
			for($i = 0; $i <= count($inscriptionNewsletter); $i++) {
				$inscrits = $inscriptionNewsletter[$i];
				// print_r($inscrits);
				$ID = $inscrits->ID;
				$mail = $inscrits->mail_newsletter;
				$avant_civilite = $inscrits->avant_civilite;
				$civilite = $inscrits->civilite;
				$nom = $inscrits->nom;
				$prenom = $inscrits->prenom;
				$nl_envoyee = $inscrits->nl_envoyee;

				$contenu_string = $this->get_contenu_mail_dynamique($gabarit_id, $mail, $avant_civilite, $civilite, $nom, $prenom);
				
				$to = "$mail";
				$subject = "Implant cérébral microscopique – BGS mise gros sur les rayons gamma – Forums LNE sur la règlementation";
				$subject = mb_encode_mimeheader($subject, "UTF-8");
				$message = $contenu_string;	
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= "From: \"DeviceMed France\"<info@devicemed.fr>";

				if($nl_envoyee == 0) {
					if(mail($to, $subject, $message, $headers)) {
						$errors = false;
						
						// On mets à jour, la newsletter a été envoyée
						$sqlUpdateNLEnvoyee = "UPDATE wordpress_dm_newsletter_test SET nl_envoyee = '1' WHERE ID=$ID";
						$resultUpdateNLEnvoyee = mysql_query($sqlUpdateNLEnvoyee);
						
						$sqlUpdateNLEnvoyee2 = "UPDATE wordpress_dm_newsletter SET nl_envoyee = '1' WHERE ID=$ID";
						$resultUpdateNLEnvoyee2 = mysql_query($sqlUpdateNLEnvoyee2);
						
						if($resultUpdateNLEnvoyee!==FALSE || $resultUpdateNLEnvoyee2!==FALSE) {
							$nbMailEnvoyé++;
						}
					}else {
						$errors = true;break;
					}
				}
			}
			
			echo "nbMailEnvoyé : ". $nbMailEnvoyé;exit();
			
			return $errors;
		}
	}
	public function get_pub($gabarit_id) {
		global $wpdb;
		
		return $wpdb->get_row($wpdb->prepare("SELECT * FROM wordpress_dm_gabarits_newsletter WHERE ID = $gabarit_id"), ARRAY_A);
	}
	
	public function get_gabarit($gabarit_id) {
		global $wpdb;

		$sqlNewsletter = 'SELECT :table.ID, :table.nom_gabarit, :table.contenu_gabarit, :table.date_created, :table.date_modified'.
		' FROM '.$this->table().
		' WHERE ID = '. $gabarit_id;

		return $wpdb->get_results(strtr($sqlNewsletter,
			array(
				':table' => $this->table()
			)
		));
	}
	public function envoyer_newsletter($gabarit_id, $mail = '0') {
		$results = $this->get_gabarit($gabarit_id);
		$nom_gabarit = $results[0]->nom_gabarit;
		$contenu_gabarit = stripslashes($results[0]->contenu_gabarit);

		if($mail != '0') {
			$to = $mail;
			$subject = "Devicemed - $nom_gabarit";
			// $message = "$contenu_gabarit";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

			if(mail($to, $subject, $message, $headers)) {
				return true;
			}else {
				return false;
			}
		}else {
			$result = true;
			$newsletter = new DM_Wordpress_Newsletter_Model();
			$resultMail = $newsletter->get_mail_newsletter();
			$arrayMail = array();
			
			for($i = 0;$i < count($resultMail);$i++) {
				$mail = $resultMail[$i]->mail_newsletter;
				
				array_push($arrayMail, $mail);
			}
			
			$subject = "Devicemed - $nom_gabarit";
			$message = $contenu_gabarit;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			
			foreach($arrayMail as $to)
			{
				if(!mail($to, $subject, $message, $headers)) {
					$result = false;
				}
			}

			if($result != FALSE) {
				return true;
			}else {
				return false;
			}
		}
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
				"(titre_archive LIKE '%:search%') AND gabarit_dynamique=0",
				array(':search' => esc_sql(like_escape($filters['search'])))
			);
		}
		// if (isset($filters['supplier_status']))
		// {
			// $where[] = sprintf("(supplier_status = %d)", (int) $filters['supplier_status']);
		// }
		
		$results = $wpdb->get_results(strtr(
			'SELECT :table.ID, :table.nom_gabarit, :table.contenu_gabarit, :table.date_created, :table.date_modified'.
			' FROM '.$this->table().
			// ' LEFT JOIN :table_category ON :table.supplier_category_id = :table_category.ID'.
			($where ? ' WHERE '.implode(' AND ', $where) : '').
			($where ? ' AND gabarit_dynamique=0' : ' WHERE gabarit_dynamique=0').
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
	public function admin_edit_get_gabarit($id)
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
		$host = 'devicemedrbdd.mysql.db';
		$user = 'devicemedrbdd';
		$pass = 'QuXRzEeVCzHV';
		$db = 'devicemedrbdd';
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