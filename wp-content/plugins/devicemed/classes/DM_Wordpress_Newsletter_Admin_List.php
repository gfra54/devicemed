<?php

class DM_Wordpress_Newsletter_Admin_List extends DM_Wordpress_Admin_Submenu_Page
{
	protected $parent_slug = 'devicemed-newsletter';
	protected $page_title = 'Tous les inscrits';
	protected $menu_title = 'Tous les inscrits';
	protected $capability = 'manage_options';
	protected $menu_slug = 'devicemed-inscrits-newsletter';

	public function render()
	{
		$filters = array();
		$current_page = 1;
		$results_per_page = 20;

		$newsletter = new DM_Wordpress_Newsletter_Model();
		
		// if($_GET['dynamique'] == 1) {
			// $contenu_string = '';
			// $contenu_string = "<!DOCTYPE html>";
			// $contenu_string .= "<span style='text-align:center;'><a href='http://www.device-med.fr/newsletter/previsualiser/21?dynamique=1'>Si la newsletter ne s'affiche pas correctement, cliquez ici</a></span>";
			// $contenu_string .= "<html>";
			// $contenu_string .= "<body>";
				// $contenu_string .= "<div style=\"width:850px !important;margin:0 auto;\">";  		
			// $contenu_string .= "<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->"; 		
			// $contenu_string .= "<table cellspacing=\"0\" cellpadding=\"0\" width=\"850\" border=\"0\" align=\"center\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin:auto;\" id=\"wrapper\">";			
			// $contenu_string .= "<tbody><tr> 				<!-- TD Content -->"; 				
			// $contenu_string .= "<td width=\"680\" valign=\"top\" style=\"background-color:#F1F1F1\">";				 					
			// $contenu_string .= "<table style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\" id=\"header\">"; 						 						
				// $contenu_string .= "<tbody>";
					// $contenu_string .= "<tr>";
						// $contenu_string .= "<td>";
								// $contenu_string .= "<img style='width:700px;' src='http://www.device-med.fr/wp-content/uploads/newsletter/original.jpg' />";
								// $contenu_string .= "<img style='width:294px;' src='http://www.device-med.fr/wp-content/uploads/newsletter/original.jpg' />";
						// $contenu_string .= "</td>";						
					// $contenu_string .= "</tr>"; 	
							 // $contenu_string .= "<tr><td><br /><b>&nbsp;&nbsp;Chère Madame Gisselbrecht,</b><br /></td></tr>";				 					
				// $contenu_string .= "</tbody>";
			// $contenu_string .= "</table>"; 					 					
			// $contenu_string .= "<!-- table editorial -->"; 					
			// $contenu_string .= "<table width=\"680\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px dotted #555; margin-left:10px\" id=\"editorial\">";
				// $contenu_string .= "<tbody>";
					// $contenu_string .= "<tr>";						
						// $contenu_string .= "<td>";
						// $contenu_string .= "</td>";
					// $contenu_string .= "</tr>";
				// $contenu_string .= "</tbody>";
			// $contenu_string .= "</table>";
			// $contenu_string .= "<!--  Banner Position 10 -->"; 					
			// $contenu_string .= "<p style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; margin-left:10px; margin-top:0px; margin-bottom:0px; text-align:left\">Annonce</p>";
			// $contenu_string .= "<table width=\"680\" style=\"border-bottom:1px dotted #555; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px\">";
				// $contenu_string .= "<tbody>";
					// $contenu_string .= "<tr>";              	
						// $contenu_string .= "<td style=\"text-align:center; padding-top:5px; padding-bottom:5px\">";
							// $contenu_string .= "<a target=\"_blank\" href=\"http://ad.de.doubleclick.net/N2686/jump/Newsletter_Vogel/dmf_pos10;sz=468x60,680x140,300x250,680x250;date=260814;dcove=r;ord=123456789\">";
								// $contenu_string .= "<img border=\"0\" src=\"http://ad.de.doubleclick.net/N2686/ad/Newsletter_Vogel/dmf_pos10;sz=468x60,680x140,300x250,680x250;date=260814;dcove=r;ord=123456789\" alt=\"\" style=\"display: none !important;\">";
							// $contenu_string .= "</a>";
						// $contenu_string .= "</td>";
					// $contenu_string .= "</tr>";
				// $contenu_string .= "</tbody>";
			// $contenu_string .= "</table>";
			// $contenu_string .= "<!-- table top news -->"; 					
			// $contenu_string .= "<table width=\"680\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px dotted #555; margin-left:10px\" id=\"top_news\">";
				// $contenu_string .= "<tbody>";
					// $contenu_string .= "<tr>";
						// $contenu_string .= "<td width=\"320\" valign=\"top\" hspace=\"0\" vspace=\"0\" style=\"padding-top:10px; padding-bottom:10px;margin-top:0px\">";
							// $contenu_string .= "<a target=\"_blank\" href=\"http://news.vogel.de/inxmail2/d?q00wueiq0eqfngbii000000000000000ietw7fui3277\">";
								// $contenu_string .= "<img width=\"300\" align=\"left\" class=\"image_fix\" alt=\"img6\" src=\"http://www.device-med.fr/wp-content/uploads/newsletter/en-us Stainless 100x100px.jpg\" />";
							// $contenu_string .= "</a>"; 	 		                
						// $contenu_string .= "</td>";
						// $contenu_string .= "<td valign=\"top\" hspace=\"0\" vspace=\"0\" style=\"padding-bottom:10px;padding-top:10px;margin-top:0px;\">";
							// $contenu_string .= "<p style=\"line-height:9.0pt;mso-line-height-rule:exactly;margin: 0px\">";
								// $contenu_string .= "<a target=\"_blank\" style=\"color:#333333;font-size:12px; text-decoration: none;font-weight:bold; margin-top:0px;vertical-align:top;\" href=\"http://www.smalley.com/fr/a-propos-des-anneaux-smalley?utm_source=DevMed&utm_medium=Enews&utm_content=SS&utm_campaign=DevMed%2010-7\">";
									// $contenu_string .= "Smalley";
								// $contenu_string .= "</a>";                                 
							// $contenu_string .= "</p>";
							// $contenu_string .= "<span style=\"font-size:4px;line-height:22px;\"> </span>";
							// $contenu_string .= "<p style=\"font-size:20px; font-weight:bold; margin-top:0px; margin-bottom:8px\">";
								// $contenu_string .= "<a style=\"color:#005EA8; text-decoration:none\" target=\"_blank\" href=\"http://www.smalley.com/fr/a-propos-des-anneaux-smalley?utm_source=DevMed&utm_medium=Enews&utm_content=SS&utm_campaign=DevMed%2010-7\">Anneau d’arrêt en acier inoxydable en stock</a>";
							// $contenu_string .= "</p>";
							// $contenu_string .= "<p style=\"margin:0;\">Smalley propose plus de 6000 anneaux d’arrêt Spirolox® en acier inoxydable 302 et 316 de 6 à 400 mm de diamètre. Fabrications spéciales de 5 à 3000 mm. Le procédé de fabrication Smalley permet la fabrication économique d’anneaux d’arrêt en acier inoxydable. Échantillons gratuits.";  
								// $contenu_string .= "<a target=\"_blank\" style=\"color:#005EA8;text-decoration: none;\" href=\"http://www.smalley.com/fr/a-propos-des-anneaux-smalley?utm_source=DevMed&utm_medium=Enews&utm_content=SS&utm_campaign=DevMed%2010-7\">plus</a>";													
							// $contenu_string .= "</p>";
						// $contenu_string .= "</td>";
					// $contenu_string .= "</tr>";						
				// $contenu_string .= "</tbody>";
			// $contenu_string .= "</table>";
			// $contenu_string .= "<!--  Banner Position 15 // Erscheint nur wenn die Topmeldung angezeigt wird -->";
			// $contenu_string .= "<p style=\"font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; margin-left:10px; margin-top:0px; margin-bottom:0px; text-align:left\">Annonce</p>";
			// $contenu_string .= "<table width=\"680\" style=\"border-bottom:1px dotted #555;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px\">";
				// $contenu_string .= "<tbody>";
					// $contenu_string .= "<tr>";
						// $contenu_string .= "<td style=\"text-align:center; padding-top:5px; padding-bottom:5px\">";
							// $contenu_string .= "<a target=\"_blank\" href=\"http://ad.de.doubleclick.net/N2686/jump/Newsletter_Vogel/dmf_pos15;sz=468x60,680x140,300x250,680x250;date=260814;dcove=r;ord=123456789\">";
								// $contenu_string .= "<img border=\"0\" src=\"http://ad.de.doubleclick.net/N2686/ad/Newsletter_Vogel/dmf_pos15;sz=468x60,680x140,300x250,680x250;date=260814;dcove=r;ord=123456789\" alt=\"\" style=\"display: none !important;\">";
							// $contenu_string .= "</a>";
						// $contenu_string .= "</td>";
					// $contenu_string .= "</tr>";						
				// $contenu_string .= "</tbody>";
			// $contenu_string .= "</table>";
			// $contenu_string .= "<!-- table inhaltsverzeichnis -->";
			// $contenu_string .= "<table width=\"680\" style=\"border-bottom:1px dotted #555;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px\" id=\"inhaltsverzeichnis\">";
				// $contenu_string .= "<tbody>";
					// $contenu_string .= "<tr>";
						// $contenu_string .= "<td style=\"padding-top:8px;\">";
							// $contenu_string .= "<h1 style=\"font-size:20px; color:#000000 !important\">Sommaire</h1>"; 
						// $contenu_string .= "</td>";							
					// $contenu_string .= "</tr>";
					// $contenu_string .= "<tr>";
						// $contenu_string .= "<td>";
							// $contenu_string .= "<ul style=\"padding-left:20px;margin-top:0px;margin-bottom:0;\">";
								// $newsletter_model = new DM_Wordpress_Newsletter_Model();
								// $posts = $newsletter_model::getLastPostsNewsletter();
									// foreach($posts as $post) {
										// $postContent = $post['post_content'];
										// $posContact = strripos($postContent, "Contact");
										// $nomEntreprise = substr($postContent, $posContact);
										// $posContact2 = strripos($nomEntreprise, "Contact");
										// $posPremiereVirgule = strpos($nomEntreprise,",");
										// $length = $posPremiereVirgule - $posContact2;
										// $nomEntreprise = substr($nomEntreprise, $posContact2, $length);
										// $nomEntreprise = str_replace("Contact :", "", $nomEntreprise);
										// $postTitle = $post['post_title'];
										// $url = $post['guid'];
										// $contenu_string .= "<li style=\"font-family:Arial\">";
										// $contenu_string .= "<a target=\"_blank\" style=\"color:#333333; font-size:14px; line-height:19px; text-decoration: none; text-decoration: none;\" href=\"$url\">$nomEntreprise: </a>";
										// $contenu_string .= "<a target=\"_blank\" style=\"color:#005EA8; text-decoration: none;  font-size:14px; line-height:19px;\" href=\"$url\">$postTitle</a></li>";
									// }
							// $contenu_string .= "</ul>";									
						// $contenu_string .= "</td>"; 								
					// $contenu_string .= "</tr>";							
					// $contenu_string .= "<tr>";
						// $contenu_string .= "<td> </td>";
					// $contenu_string .= "</tr>";
				// $contenu_string .= "</tbody>";
			// $contenu_string .= "</table>";
			// $contenu_string .= "<!--    Position 20  -->";							 					 						 											 					
				// $contenu_string .= "<!-- table content -->"; 				
			// $contenu_string .= "<table width=\"684\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:10px\" id=\"content\">";
				// $contenu_string .= "<tbody>";
					// foreach($posts as $post) {
						// $postId = $post['ID'];
						// $postThumbnail = DM_Wordpress_Newsletter_Model::getThumbnailNewsletter($postId);
						// $postTitle = $post['post_title'];
						// $url = $post['guid'];
						
						// On tronque la description
						// $max_caracteres=250;
						// $postContent = $post['post_content'];
						// $postContent2 =htmlentities($postContent);
						// $posContact = strripos($postContent2, "Contact");
						// $nomEntreprise = substr($postContent2, $posContact);
						// $posContact2 = strripos($nomEntreprise, "Contact");
						// $posPremiereVirgule = strpos($nomEntreprise,",");
						// $length = $posPremiereVirgule - $posContact2;
						// $nomEntreprise = substr($nomEntreprise, $posContact2, $length);
						// $nomEntreprise = str_replace("Contact :", "", $nomEntreprise);
						
						// if (strlen($postContent)>$max_caracteres)
						// {  
							// $postContent = substr($postContent, 0, $max_caracteres);
							// $position_espace = strrpos($postContent, " ");    
							// $postContent = substr($postContent, 0, $position_espace);    
							// $postContent = $postContent .'...&nbsp;';
						// }
						
						// $contenu_string .= "<tr>";
							// $contenu_string .= "<td width=\"128\" valign=\"top\" style=\" width:128px; padding-bottom:15px; padding-top:10px;border-bottom: 1px dotted #555;\">";
								// $contenu_string .= "<a target=\"_blank\" href=\"$url\">";
									// $contenu_string .= "<img width=\"100\" align=\"left\" style=\"border: solid 1px #FFFFFF;\" alt=\"img6\" src=\"$postThumbnail\" />";
								// $contenu_string .= "</a>";
							// $contenu_string .= "</td>";
							// $contenu_string .= "<td width=\"557\" valign=\"top\" style=\"width:557px; padding-bottom:15px; padding-top:10px;border-bottom: 1px dotted #555; \">";
								// $contenu_string .= "<p style=\"line-height:9.5pt;mso-line-height-rule:exactly;margin: 0px\">";
									// $contenu_string .= "<a target=\"_blank\" style=\"font-size: 12px; font-weight:bold; font-family: Helvetica, Arial, sans-serif; color:#333333; margin: 0px;text-decoration: none\" href=\"$url\">$nomEntreprise</a>";
								// $contenu_string .= "</p>"; 			                                
								// $contenu_string .= "<p style=\"margin: 0px;\">";
									// $contenu_string .= "<a target=\"_blank\" style=\"font-size: 16px; font-weight:bold; font-family: Helvetica, Arial, sans-serif; color:#005EA8; margin: 0px;text-decoration: none\" href=\"$url\">$postTitle </a>";
								// $contenu_string .= "</p>";
								// $contenu_string .= "<p style=\"font-size: 14px; line-height: 21px; font-family: Arial; color: #333; margin: 0px;\">";
									// $contenu_string .= "$postContent";			                                
									// $contenu_string .= "<a target=\"_blank\" style=\"color:#005EA8;text-decoration: none;\" href=\"$url\">plus</a>"; 				                        	
								// $contenu_string .= "</p>";
							// $contenu_string .= "</td>";
						// $contenu_string .= "</tr>";
					// }
				// $contenu_string .= "</tbody>";
			// $contenu_string .= "</table>";
			// $contenu_string .= "<table width=\"704\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; margin-left:0px\" id=\"footer\"><tbody><tr><td style=\"font-family:Arial; font-size:12px\"><table cellspacing=\"0\" width=\"702\">";
				 // $contenu_string .= "<tbody>";
					 // $contenu_string .= "<tr>";
						 // $contenu_string .= "<td style=\"PADDING-BOTTOM: 10px; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND-COLOR: #c7c7c7\">";
						 // $contenu_string .= "<table width=\"680\">";
							// $contenu_string .= " <tbody>";
								// $contenu_string .= " <tr>";
									 // $contenu_string .= "<td align=\"left\"><a href=\"http://news.vogel.de/inxmail2/d?q00wueoq0eqfngbii000000000000000ietwqbri3277\"><img src=\"http://www.device-med.fr/wp-content/uploads/newsletter/unnamed.gif\" alt=\"Vogel Logo\"></a></td>";
									 // $contenu_string .= "<td align=\"right\">      </td>";
								 // $contenu_string .= "</tr>";
							 // $contenu_string .= "</tbody>";
						 // $contenu_string .= "</table>";
						 // $contenu_string .= "</td>";
					 // $contenu_string .= "</tr>";
					 // $contenu_string .= "<tr>";
						 // $contenu_string .= "<td style=\"FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif; PADDING-BOTTOM: 10px; TEXT-ALIGN: center; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND-COLOR: #d2d2d2\"><a href=\"http://news.vogel.de/inxmail2/d/d.cfm?q00wueoy0eqfngbii000000000000000ietw3mj03277\" style=\"COLOR: #b30f1d\">Politique de confidentialité</a>   <a href=\"http://news.vogel.de/inxmail2/d?q00wuep00eqfngbii000000000000000ietw3yq03277\" style=\"COLOR: #b30f1d\">Abonnement</a>    <a href=\"http://news.vogel.de/inxmail2/d?q00wuepi0eqfngbii000000000000000ietwqvii3277\" style=\"COLOR: #b30f1d\">Contact</a>    <a href=\"http://news.vogel.de/inxmail2/d?q00wuepq0eqfngbii000000000000000ietw5pqy3277\" style=\"COLOR: #b30f1d\">Médias</a></td>";
					// $contenu_string .= " </tr>";
					// $contenu_string .= " <tr>";
						 // $contenu_string .= "<td style=\"PADDING-BOTTOM: 10px; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; BACKGROUND-COLOR: #616161\">";
						 // $contenu_string .= "<p style=\"FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #ffffff; LINE-HEIGHT: 18px\">© The French language edition of DeviceMed is a publication of Evelyne Gisselbrecht, licensed by Vogel Business Media GmbH & Co. KG, 97082 Wuerzburg/Germany.<br>";
						// $contenu_string .= " © Copyright of the trademark « DeviceMed » by Vogel Business Media GmbH & Co. KG, 97082 Wuerzburg/Germany.<br>";
						// $contenu_string .= " Responsable du contenu rédactionnel sur <a href=\"http://news.vogel.de/inxmail2/d?q00wuepy0eqfngbii000000000000000ietwwciq3277\">www.devicemed.fr</a> : Evelyne Gisselbrecht, éditrice de DeviceMed, 33 rue du Puy-de-Dôme, 63370 Lempdes France</p>";
						// $contenu_string .= " </td>";
					 // $contenu_string .= "</tr>";
				// $contenu_string .= " </tbody>";
			// $contenu_string .= " </table>";
			// $contenu_string .= "<p> </p></td></tr> 						<tr><td style=\"text-align:center; font-family:Arial; font-size:11px\">Le bulletin est adressé à evelyne.gisselbrecht@vogel.de</td></tr> 						<tr><td style=\"text-align:center; font-family:Arial; font-size:11px\">                          		<a href=\"http://news.vogel.de/inxmail2/d/d.cfm?q00wuei00eqfngbii000000000000000ietwzsuq3277&nlid=226&user=evelyne.gisselbrecht@vogel.de&nomobile=1\" style=\"color:#005EA8;text-decoration: underline;\">Se désinscrire</a>                          	</td>                         </tr>                          					</tbody></table> 				</td><!-- TD Spacer --> 				<td width=\"10\" valign=\"top\"> </td> 				<!-- TD Skyscraper --> 				<td width=\"160\" valign=\"top\">		 					<!--  Banner Position 100  --> 					<table style=\"border-top:0px dotted #555;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"> 							<tbody><tr> 	                            <td>			 									<a target=\"_blank\" href=\"http://ad.de.doubleclick.net/N2686/jump/Newsletter_Vogel/dmf_pos100;sz=160x600,160x150,120x600,300x600;date=260814;dcove=r;ord=123456789\"> 										<img border=\"0\" src=\"http://ad.de.doubleclick.net/N2686/ad/Newsletter_Vogel/dmf_pos100;sz=160x600,160x150,120x600,300x600;date=260814;dcove=r;ord=123456789\" alt=\"\" style=\"display: none !important;\">  									</a> 						        </td> 	                        </tr> 					</tbody></table> 					<!--  Banner Position 105  --><!--  Banner Position 110  --><!--  Banner Position 115  --></td></tr> 		</tbody></table> 		<!-- End example table -->  		<!-- Yahoo Link color fix updated: Simply bring your link styling inline.  		<a  href=\"http://news.vogel.de/inxmail2/d?q00wueq00eqfngbii000000000000000ietwvc0q3277\"  target =\"_blank\" title=\"Styling Links\" style=\"color: orange; text-decoration: none;\">Coloring Links appropriately</a> 		--> 		<!-- Gmail/Hotmail image display fix  		<img class=\"image_fix\" src=\"full path to image\" alt=\"Your alt text\" title=\"Your title text\" width=\"x\" height=\"x\" /> 		-->  		</div>";

			// $contenu_string .= "</body></html>";
			
			// $to = "salvatore.eric@gmail.com";
			// $subject = "Devicemed - Newsletter DeviceMed France 17/2014";
			// $message = "$contenu_string";
			// $headers  = 'MIME-Version: 1.0' . "\r\n";
			// $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

			// if(mail($to, $subject, $message, $headers)) {
				// echo "true";
			// }else {
				// echo "false";
			// }
		// }

		if (!empty($_GET['action']) AND !empty($_GET['inscrits']))
		{
			if ($_GET['action'] == 'enable')
			{
				$newsletter->admin_list_bulk_enable($_GET['inscrits']);
			}
			elseif ($_GET['action'] == 'disable')
			{
				$newsletter->admin_list_bulk_disable($_GET['inscrits']);
			}
			elseif ($_GET['action'] == 'delete')
			{
				$newsletter->admin_list_bulk_delete($_GET['inscrits']);
			}
		}
		
		if (!empty($_GET['orderby']) AND !empty($_GET['order']))
		{
			$filters+= array(
				'orderby' => (string) $_GET['orderby'],
				'order' => (string) $_GET['order']
			);
		}
		if (!empty($_GET['search']) AND trim($_GET['search']))
		{
			// WordPress magic_quotes hell...
			$_GET['search'] = stripslashes($_GET['search']);
			$filters+= array('search' => (string) $_GET['search']);
		}
		
		if (isset($_GET['supplier_status']) AND $_GET['supplier_status'] != '-1')
		{
			$filters+= array('supplier_status' => (int) $_GET['supplier_status']);
		}
		if (!empty($_GET['paged']))
		{
			$current_page = (int) $_GET['paged'];
		}

		
		$results = $newsletter->admin_list($current_page, $results_per_page, $filters);
		$count_all = $newsletter->admin_list_count_all();
		$count_active = $newsletter->admin_list_count_active();
		$count_inactive = $newsletter->admin_list_count_inactive();

		$navigation = array(
			'first' => 1,
			'previous' => $current_page > 1 ? $current_page - 1 : 1,
			'current' => $current_page,
			'next' => $current_page < $results['pages'] ? $current_page + 1 : $current_page,
			'last' => $results['pages'],
			'count' => $results['count']
		);

		$columns = array(
			'mail_newsletter' => array(
				'id' => 'newsletter-mail',
				'title' => 'Adresse mail',
				'sortable' => true
			),
			'offre_devicemed' => array(
				'id' => 'newsletter-offre-devicemed',
				'title' => 'Offre devicemed',
				'sortable' => true
			),
			'offre_partenaires' => array(
				'id' => 'newsletter-offre-partenaires',
				'title' => 'Offre partenaires',
				'sortable' => true
			),
			'nom' => array(
				'id' => 'newsletter-nom',
				'title' => 'Nom',
				'sortable' => true
			),
			'prenom' => array(
				'id' => 'newsletter-prenom',
				'title' => 'Prénom',
				'sortable' => true
			),
			'ville' => array(
				'id' => 'newsletter-ville',
				'title' => 'Ville',
				'sortable' => true
			),
			'cp' => array(
				'id' => 'newsletter-cp',
				'title' => 'Code postal',
				'sortable' => true
			),
			'actif' => array(
				'id' => 'newsletter-actif',
				'title' => 'Actif',
				'sortable' => false
			),
		);
		
		DM_Wordpress_Template::load('newsletter_admin_list', array(
			'page' => $this,
			'screen' => get_current_screen(),
			'count' => array(
				'all' => $count_all,
				'active' => $count_active,
				'inactive' => $count_inactive
			),
			'results' => $results['results'],
			'navigation' => $navigation,
			'filters' => $filters,
			'columns' => $columns
		));
	}

	public function scripts()
	{
		echo '<script type="text/javascript">
		(function($) {
			var actions = $("select[name^=action]");
			actions.on("change", function() {
				actions.val($(this).val());
			});
			$("#list-form").on("submit", function(event) {
				if ($("select[name=action]").val() == "delete") {
					var message = "'.esc_js("Vous êtes sur le point de supprimer DÉFINITIVEMENT les éléments sélectionnés. Cette action est irreversible.").'";
					if (!confirm(message)) {
						event.preventDefault();
					}
				}
			});
		})(jQuery);
		</script>';
	}
}