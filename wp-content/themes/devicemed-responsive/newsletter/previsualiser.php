<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<title>Prévisualisation</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<!-- Bootstrap -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<?php wp_head(); ?>
</head>
<body>
	<?php 
		$nom_gabarit = $results->nom_gabarit; 
		$contenu_string = stripslashes($result->contenu_gabarit);
		
		if($dynamique == 1) {
			// On récupére les infos de la pub
			$gabarit_model = new DM_Wordpress_Gabarit_Model();
			$pub = $gabarit_model->get_pub($results->ID);
		
			$contenu_string = '';
			$contenu_string = "<!DOCTYPE html>";
			$contenu_string .= "<table align='center'><tr><td><a href='http://www.device-med.fr/newsletter/previsualiser/21?dynamique=1'>Si la newsletter ne s'affiche pas correctement, cliquez ici</a></td></tr></table>";
			$contenu_string .= "<html>";
			$contenu_string .= "<body>";
				$contenu_string .= "<div style=\"width:850px !important;margin:0 auto;\">";  		
			$contenu_string .= "<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->"; 		
			$contenu_string .= "<table cellspacing=\"0\" cellpadding=\"0\" width=\"850\" border=\"0\" align=\"center\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin:auto;\" id=\"wrapper\">";			
			$contenu_string .= "<tbody><tr> 				<!-- TD Content -->"; 				
			$contenu_string .= "<td width=\"680\" valign=\"top\" style=\"background-color:#F1F1F1\">";				 					
			$contenu_string .= "<table style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\" id=\"header\">"; 						 						
				$contenu_string .= "<tbody>";
					$contenu_string .= "<tr>";
						$contenu_string .= "<td>";
								$contenu_string .= "<img width='700px' height='91px' src='http://www.device-med.fr/wp-content/uploads/newsletter/original.jpg' />";
						$contenu_string .= "</td>";						
					$contenu_string .= "</tr>"; 	
							 $contenu_string .= "<tr><td><br /><b>&nbsp;&nbsp;$avant_civilite $civilite $nom,</b><br /></td></tr>";				 					
				$contenu_string .= "</tbody>";
			$contenu_string .= "</table>"; 					 					
			$contenu_string .= "<!-- table editorial -->"; 					
			$contenu_string .= "<table width=\"680\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px dotted #555; margin-left:10px\" id=\"editorial\">";
				$contenu_string .= "<tbody>";
					$contenu_string .= "<tr>";						
						$contenu_string .= "<td>";
						$contenu_string .= "</td>";
					$contenu_string .= "</tr>";
				$contenu_string .= "</tbody>";
			$contenu_string .= "</table>";
			$contenu_string .= "<!--  Banner Position 10 -->";
			$contenu_string .= "<p style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; margin-left:10px; margin-top:0px; margin-bottom:0px; text-align:left\">Annonce</p>";
			$contenu_string .= "<table width=\"680\" style=\"border-bottom:1px dotted #555; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px\">";
				$contenu_string .= "<tbody>";
					$contenu_string .= "<tr>";              	
						$contenu_string .= "<td style=\"text-align:center; padding-top:5px; padding-bottom:5px\">";
							$contenu_string .= "<a target=\"_blank\" href=\"http://ad.de.doubleclick.net/N2686/jump/Newsletter_Vogel/dmf_pos10;sz=468x60,680x140,300x250,680x250;date=260814;dcove=r;ord=123456789\">";
								$contenu_string .= "<img border=\"0\" src=\"http://www.device-med.fr/wp-content/uploads/newsletter/keep_calme.jpg\" alt=\"\" style=\"display: none !important;\">";
							$contenu_string .= "</a>";
						$contenu_string .= "</td>";
					$contenu_string .= "</tr>";
				$contenu_string .= "</tbody>";
			$contenu_string .= "</table>";
			$contenu_string .= "<!-- table top news -->"; 	 				
			if(!empty($pub)) {				
				$nom_pub = $pub['nom_pub'];
				$nom_entreprise_pub = $pub['nom_entreprise_pub'];
				$lien_pub = $pub['lien_pub'];
				$contenu_pub = $pub['contenu_pub'];
				$image_pub = $pub['image_pub'];
				
				$contenu_string .= "<table width=\"680\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px dotted #555; margin-left:10px\" id=\"top_news\">";
					$contenu_string .= "<tbody>";
						$contenu_string .= "<tr>";
							$contenu_string .= "<td width=\"320\" valign=\"top\" hspace=\"0\" vspace=\"0\" style=\"padding-top:10px; padding-bottom:10px;margin-top:0px\">";
								$contenu_string .= "<a target=\"_blank\" href=\"$lien_pub\">";
									$contenu_string .= "<span><img width=\"300\" align=\"left\" class=\"image_fix\" alt=\"img6\" src=\"http://www.device-med.fr/wp-content/uploads/newsletter/$image_pub\" /></span>";
								$contenu_string .= "</a>"; 	 		                
							$contenu_string .= "</td>";
							$contenu_string .= "<td valign=\"top\" hspace=\"0\" vspace=\"0\" style=\"padding-bottom:10px;padding-top:10px;margin-top:0px;\">";
								$contenu_string .= "<p style=\"line-height:9.0pt;mso-line-height-rule:exactly;margin: 0px\">";
									$contenu_string .= "<a target=\"_blank\" style=\"color:#333333;font-size:12px; text-decoration: none;font-weight:bold; margin-top:0px;vertical-align:top;\" href=\"$lien_pub\">";
										$contenu_string .= "$nom_entreprise_pub";
									$contenu_string .= "</a>";                                 
								$contenu_string .= "</p>";
								$contenu_string .= "<span style=\"font-size:4px;line-height:22px;\"> </span>";
								$contenu_string .= "<p style=\"font-size:20px; font-weight:bold; margin-top:0px; margin-bottom:8px\">";
									$contenu_string .= "<a style=\"color:#005EA8; text-decoration:none\" target=\"_blank\" href=\"$lien_pub\">$nom_pub</a>";
								$contenu_string .= "</p>";
								$contenu_string .= "<p style=\"margin:0;\">$contenu_pub";  
									$contenu_string .= "<a target=\"_blank\" style=\"color:#005EA8;text-decoration: none;\" href=\"$lien_pub\">plus</a>";													
								$contenu_string .= "</p>";
							$contenu_string .= "</td>";
						$contenu_string .= "</tr>";						
					$contenu_string .= "</tbody>";
				$contenu_string .= "</table>";
				$contenu_string .= "<!--  Banner Position 15 // Erscheint nur wenn die Topmeldung angezeigt wird -->";
				$contenu_string .= "<p style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; margin-left:10px; margin-top:0px; margin-bottom:0px; text-align:left\">Annonce</p>";
			}
			$contenu_string .= "<table width=\"680\" style=\"border-bottom:1px dotted #555;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px\">";
				$contenu_string .= "<tbody>";
					$contenu_string .= "<tr>";
						$contenu_string .= "<td style=\"text-align:center; padding-top:5px; padding-bottom:5px\">";
							$contenu_string .= "<a target=\"_blank\" href=\"http://ad.de.doubleclick.net/N2686/jump/Newsletter_Vogel/dmf_pos15;sz=468x60,680x140,300x250,680x250;date=260814;dcove=r;ord=123456789\">";
								$contenu_string .= "<img border=\"0\" src=\"http://ad.de.doubleclick.net/N2686/ad/Newsletter_Vogel/dmf_pos15;sz=468x60,680x140,300x250,680x250;date=260814;dcove=r;ord=123456789\" alt=\"\" style=\"display: none !important;\">";
							$contenu_string .= "</a>";
						$contenu_string .= "</td>";
					$contenu_string .= "</tr>";						
				$contenu_string .= "</tbody>";
			$contenu_string .= "</table>";
			$contenu_string .= "<!-- table inhaltsverzeichnis -->";
			$contenu_string .= "<table width=\"680\" style=\"border-bottom:1px dotted #555;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px\" id=\"inhaltsverzeichnis\">";
				$contenu_string .= "<tbody>";
					$contenu_string .= "<tr>";
						$contenu_string .= "<td style=\"padding-top:8px;\">";
							$contenu_string .= "<h1 style=\"font-size:20px; color:#000000 !important\">Sommaire</h1>"; 
						$contenu_string .= "</td>";							
					$contenu_string .= "</tr>";
					$contenu_string .= "<tr>";
						$contenu_string .= "<td>";
							$contenu_string .= "<ul style=\"padding-left:20px;margin-top:0px;margin-bottom:0;\">";
								$newsletter_model = new DM_Wordpress_Newsletter_Model();
								$posts = $newsletter_model::getLastPostsNewsletter();
									foreach($posts as $post) {
										$postContent = $post['post_content'];
										$posContact = strripos($postContent, "Contact");
										$nomEntreprise = substr($postContent, $posContact);
										$posContact2 = strripos($nomEntreprise, "Contact");
										$posPremiereVirgule = strpos($nomEntreprise,",");
										$length = $posPremiereVirgule - $posContact2;
										$nomEntreprise = substr($nomEntreprise, $posContact2, $length);
										$nomEntreprise = str_replace("Contact :", "", $nomEntreprise);
										$postTitle = $post['post_title'];
										$url = $post['guid'];
										$contenu_string .= "<li style=\"font-family:Arial\">";
										$contenu_string .= "<a target=\"_blank\" style=\"color:#333333; font-size:14px; line-height:19px; text-decoration: none; text-decoration: none;\" href=\"$url\">$nomEntreprise: </a>";
										$contenu_string .= "<a target=\"_blank\" style=\"color:#005EA8; text-decoration: none;  font-size:14px; line-height:19px;\" href=\"$url\">$postTitle</a></li>";
									}
							$contenu_string .= "</ul>";									
						$contenu_string .= "</td>"; 								
					$contenu_string .= "</tr>";							
					$contenu_string .= "<tr>";
						$contenu_string .= "<td> </td>";
					$contenu_string .= "</tr>";
				$contenu_string .= "</tbody>";
			$contenu_string .= "</table>";
			$contenu_string .= "<!--    Position 20  -->";							 					 						 											 					
				$contenu_string .= "<!-- table content -->"; 				
			$contenu_string .= "<table width=\"684\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px\" id=\"content\">";
				$contenu_string .= "<tbody>";
					foreach($posts as $post) {
						$postId = $post['ID'];
						$postThumbnail = DM_Wordpress_Newsletter_Model::getThumbnailNewsletter($postId);
						$postTitle = $post['post_title'];
						$url = $post['guid'];
						
						// On tronque la description
						$max_caracteres=250;
						$postContent = $post['post_content'];
						$postContent2 =htmlentities($postContent);
						$posContact = strripos($postContent2, "Contact");
						$nomEntreprise = substr($postContent2, $posContact);
						$posContact2 = strripos($nomEntreprise, "Contact");
						$posPremiereVirgule = strpos($nomEntreprise,",");
						$length = $posPremiereVirgule - $posContact2;
						$nomEntreprise = substr($nomEntreprise, $posContact2, $length);
						$nomEntreprise = str_replace("Contact :", "", $nomEntreprise);
						
						if (strlen($postContent)>$max_caracteres)
						{  
							$postContent = substr($postContent, 0, $max_caracteres);
							$position_espace = strrpos($postContent, " ");    
							$postContent = substr($postContent, 0, $position_espace);    
							$postContent = $postContent .'...&nbsp;';
						}
						
						$contenu_string .= "<tr>";
							$contenu_string .= "<td width=\"128\" valign=\"top\" style=\" width:128px; padding-bottom:15px; padding-top:10px;border-bottom: 1px dotted #555;\">";
								$contenu_string .= "<a target=\"_blank\" href=\"$url\">";
									$contenu_string .= "<img width=\"100\" align=\"left\" style=\"border: solid 1px #FFFFFF;\" alt=\"img6\" src=\"$postThumbnail\" />";
								$contenu_string .= "</a>";
							$contenu_string .= "</td>";
							$contenu_string .= "<td width=\"557\" valign=\"top\" style=\"width:557px; padding-bottom:15px; padding-top:10px;border-bottom: 1px dotted #555; \">";
								$contenu_string .= "<p style=\"line-height:9.5pt;mso-line-height-rule:exactly;margin: 0px\">";
									$contenu_string .= "<a target=\"_blank\" style=\"font-size: 12px; font-weight:bold; font-family: Helvetica, Arial, sans-serif; color:#333333; margin: 0px;text-decoration: none\" href=\"$url\">$nomEntreprise</a>";
								$contenu_string .= "</p>"; 			                                
								$contenu_string .= "<p style=\"margin: 0px;\">";
									$contenu_string .= "<a target=\"_blank\" style=\"font-size: 16px; font-weight:bold; font-family: Helvetica, Arial, sans-serif; color:#005EA8; margin: 0px;text-decoration: none\" href=\"$url\">$postTitle </a>";
								$contenu_string .= "</p>";
								$contenu_string .= "<p style=\"font-size: 14px; line-height: 21px; font-family: Arial; color: #333; margin: 0px;\">";
									$contenu_string .= "$postContent";			                                
									$contenu_string .= "<a target=\"_blank\" style=\"color:#005EA8;text-decoration: none;\" href=\"$url\">plus</a>"; 				                        	
								$contenu_string .= "</p>";
							$contenu_string .= "</td>";
						$contenu_string .= "</tr>";
					}
				$contenu_string .= "</tbody>";
			$contenu_string .= "</table>";
			$contenu_string .= "<table width=\"704\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:0px\" id=\"footer\"><tbody><tr><td style=\"font-family:Arial; font-size:12px\"><table cellspacing=\"0\" width=\"702\">";
				 $contenu_string .= "<tbody>";
					 $contenu_string .= "<tr>";
						 $contenu_string .= "<td style=\"PADDING-BOTTOM: 10px; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND-COLOR: #c7c7c7\">";
						 $contenu_string .= "<table width=\"680\">";
							$contenu_string .= " <tbody>";
								$contenu_string .= " <tr>";
									 $contenu_string .= "<td align=\"left\"><a href=\"http://news.vogel.de/inxmail2/d?q00wueoq0eqfngbii000000000000000ietwqbri3277\"><img src=\"http://www.device-med.fr/wp-content/uploads/newsletter/unnamed.gif\" alt=\"Vogel Logo\"></a></td>";
									 $contenu_string .= "<td align=\"right\">      </td>";
								 $contenu_string .= "</tr>";
							 $contenu_string .= "</tbody>";
						 $contenu_string .= "</table>";
						 $contenu_string .= "</td>";
					 $contenu_string .= "</tr>";
					 $contenu_string .= "<tr>";
						 $contenu_string .= "<td style=\"FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif; PADDING-BOTTOM: 10px; TEXT-ALIGN: center; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND-COLOR: #d2d2d2\"><a href=\"http://news.vogel.de/inxmail2/d/d.cfm?q00wueoy0eqfngbii000000000000000ietw3mj03277\" style=\"COLOR: #b30f1d\">Politique de confidentialité</a>   <a href=\"http://news.vogel.de/inxmail2/d?q00wuep00eqfngbii000000000000000ietw3yq03277\" style=\"COLOR: #b30f1d\">Abonnement</a>    <a href=\"http://news.vogel.de/inxmail2/d?q00wuepi0eqfngbii000000000000000ietwqvii3277\" style=\"COLOR: #b30f1d\">Contact</a>    <a href=\"http://news.vogel.de/inxmail2/d?q00wuepq0eqfngbii000000000000000ietw5pqy3277\" style=\"COLOR: #b30f1d\">Médias</a></td>";
					$contenu_string .= " </tr>";
					$contenu_string .= " <tr>";
						 $contenu_string .= "<td style=\"PADDING-BOTTOM: 10px; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND-COLOR: #616161\">";
						 $contenu_string .= "<p style=\"FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #ffffff; LINE-HEIGHT: 18px\">© The French language edition of DeviceMed is a publication of Evelyne Gisselbrecht, licensed by Vogel Business Media GmbH & Co. KG, 97082 Wuerzburg/Germany.<br>";
						$contenu_string .= " © Copyright of the trademark « DeviceMed » by Vogel Business Media GmbH & Co. KG, 97082 Wuerzburg/Germany.<br>";
						$contenu_string .= " Responsable du contenu rédactionnel sur <a href=\"http://news.vogel.de/inxmail2/d?q00wuepy0eqfngbii000000000000000ietwwciq3277\">www.devicemed.fr</a> : Evelyne Gisselbrecht, éditrice de DeviceMed, 33 rue du Puy-de-Dôme, 63370 Lempdes France</p>";
						$contenu_string .= " </td>";
					 $contenu_string .= "</tr>";
				$contenu_string .= " </tbody>";
			$contenu_string .= " </table>";
			$contenu_string .= "<p> </p></td></tr> 						<tr><td style=\"text-align:center; font-family:Arial; font-size:11px\">Le bulletin est adressé à $mail</td></tr> 						<tr><td style=\"text-align:center; font-family:Arial; font-size:11px\">                          		<a href=\"http://www.device-med.fr/newsletter/desinscrire/$mail\" style=\"color:#005EA8;text-decoration: underline;\">Se désinscrire</a>                          	</td>                         </tr>                          					</tbody></table> 				</td><!-- TD Spacer --> 				<td width=\"10\" valign=\"top\"> </td> 				<!-- TD Skyscraper --> 				<td width=\"160\" valign=\"top\">		 					<!--  Banner Position 100  --> 					<table style=\"border-top:0px dotted #555;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"> 							<tbody><tr> 	                            <td>			 									<a target=\"_blank\" href=\"http://ad.de.doubleclick.net/N2686/jump/Newsletter_Vogel/dmf_pos100;sz=160x600,160x150,120x600,300x600;date=260814;dcove=r;ord=123456789\"> 										<img border=\"0\" src=\"http://ad.de.doubleclick.net/N2686/ad/Newsletter_Vogel/dmf_pos100;sz=160x600,160x150,120x600,300x600;date=260814;dcove=r;ord=123456789\" alt=\"\" style=\"display: none !important;\">  									</a> 						        </td> 	                        </tr> 					</tbody></table> 					<!--  Banner Position 105  --><!--  Banner Position 110  --><!--  Banner Position 115  --></td></tr> 		</tbody></table> 		<!-- End example table -->  		<!-- Yahoo Link color fix updated: Simply bring your link styling inline.  		<a  href=\"http://news.vogel.de/inxmail2/d?q00wueq00eqfngbii000000000000000ietwvc0q3277\"  target =\"_blank\" title=\"Styling Links\" style=\"color: orange; text-decoration: none;\">Coloring Links appropriately</a> 		--> 		<!-- Gmail/Hotmail image display fix  		<img class=\"image_fix\" src=\"full path to image\" alt=\"Your alt text\" title=\"Your title text\" width=\"x\" height=\"x\" /> 		-->  		</div>";

			$contenu_string .= "</body></html>";
		}
		
		echo "<div style='width:850px !important;margin:0 auto;'>$contenu_string</div>";
	?>
</body>
</html>
