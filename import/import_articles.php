<?php

set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');

define('BASE_DIRECTORY', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

require_once implode(DS, array(dirname(BASE_DIRECTORY), 'application', 'libraries', 'wordpress', 'wp-load.php'));
require_once implode(DS, array(dirname(BASE_DIRECTORY), 'application', 'libraries', 'wordpress', 'wp-admin', 'includes', 'image.php'));

$counter = 0;

$wp_post_default = array(
	'post_content' => '',
	'post_name' => '',
	'post_title' => '',
	'post_status' => 'publish',
	'post_type' => 'post',
	'post_author' => 1,
	'ping_status' => 'closed',
	'post_parent' => 0,
	'menu_order' => 0,
	'to_ping' => '',
	'pinged' => '',
	'post_password' => '',
	'post_excerpt' => '',
	'post_date' => date('Y-m-d H:i:s', time()),
	'post_date_gmt' => date('Y-m-d H:i:s', time()),
	'comment_status' => 'closed',
	'post_category' => array(),
	'tags_input' => '',
	'tax_input' => '',
	'page_template' => ''
);

$wp_categories = array(
	'Dossiers' => 2,
	'Actualités' => 3,
	'Composants OEM' => 7,
	'Equipements de production & Techniques de fabrication' => 4,
	'Gestion' => 8,
	'Matériaux' => 6,
	'Question Réglementaires' => 9,
	'Sous-traitance & Services' => 5
);

$workflows = array();
/**
Online-Artikel = Article en ligne
Artikel Pilot = Article pilote
Article Pilot = Article pilote
Article = Article
*/
$workflow_steps = array();
/**
Freigegeben = Libéré (published)
Freigegeben zur Veröffentlichung = Pour publication (pending)
Gesperrt = Fermé (closed)
*/
$types = array();
/**
News = Actualités
Fachbeitrag = Document technique
Produktmeldung = Annonce produit
Nachricht = Message
*/
$channels = array();
/**
Actualités
Composants OEM
Equipements de production & Techniques de fabrication
Gestion
Matériaux
Question Réglementaires
Sous-traitance & Services
devicemed.fr
*/
$classes = array();

$flags = array();

$articles = new SimpleXMLElement(file_get_contents('sources'.DS.'2014-04-09_articles.xml'));
foreach ($articles->xpath('/ARTICLES/ARTICLE') as $article) {
	
	$wp_post = $wp_post_default;	
	$attachments = array();
	
	if ((string) $article->XML) {

		$pk = (int) $article->PKARTICLES;
		//if ($pk != 385873) continue;
		//if ($pk != 439953) continue;
		if ($pk != 436110) continue;

		$article_xml = new SimpleXMLElement((string) $article->XML);

		print_r($article_xml);
		exit;
		
		$title = (string) $article_xml->xpath('/article/header/title')[0];
		$kicker = (string) $article_xml->xpath('/article/header/kicker')[0];
		$workflow = (string) $article_xml->xpath('/article/header/variant')[0]['workflow'];
		$workflows[$workflow] = isset($workflows[$workflow]) ? $workflows[$workflow] + 1 : 0;
		$workflow_step = (string) $article_xml->xpath('/article/header/variant')[0]['workflowstep'];
		$workflow_steps[$workflow_step] = isset($workflow_steps[$workflow_step]) ? $workflow_steps[$workflow_step] + 1 : 0;
		$type = (string) $article_xml->xpath('/article/header/articletype')[0];
		$types[$type] = isset($types[$type]) ? $types[$type] + 1 : 0;
		$onlinepublications = $article_xml->xpath('/article/header/onlinepublication');
		foreach ($onlinepublications as $onlinepublication) {
			$channel = (string) $onlinepublication->themechannel['name'];
			$channels[$channel] = isset($channels[$channel]) ? $channels[$channel] + 1 : 0;
		}

		$editor = $article_xml->xpath('/article/header/editor')[0];
		$creation = $article_xml->xpath('/article/header/creation')[0];
		$update = $article_xml->xpath('/article/header/lastmodification')[0];

		$body = '';
		foreach ($article_xml->xpath('/article/textfile') as $textfile) {
			if ($textfile['type'] == 'picturetext') {
				$part = '';
				if ($picturefiles = $article_xml->xpath('/article/picturefile[@relatedtextid='.$textfile['id'].']')) {
					$picturefile = $picturefiles[0];
					//$picturefile['type'] // mainimage, illustration
					foreach ($textfile->xpath('paragraph') as $paragraph) {
						switch($paragraph['style']) {
							case 'b0':
								$part.= (string) $paragraph->txt;
								break;
							case 'b9':
								$part.= sprintf(' (%s)', (string) $paragraph->txt);
								break;
							default:
								$part.= (string) $paragraph->txt;
								break;
						}
					}

					$attachments[] = array(
						'filename' => 'images/'.$picturefile['pkimages'].'.jpg',
						'legend' => $part,
						'featured' => $picturefile['type'] == 'mainimage'
					);
					//$part = sprintf('<p><img src="%s" alt="%s" width="320" /><span>%s</span></p>'.PHP_EOL, 'images/'.$picturefile['pkimages'].'.jpg', $part, $part);
					//$body.= $part;
				}
			} else if ($textfile['type'] == 'maintext') {
				foreach ($textfile->xpath('paragraph') as $paragraph) {
					$part = '';
					foreach ($paragraph->children() as $node) {
						switch($node->getName()) {
							case 'characterformat':
								if ($format = (string) $node->txt) {
									if ((string) $node['bold'] == 'true') {
										$format = sprintf('<b>%s</b>', $format);
									}
									if ((string) $node['italic'] == 'true') {
										$format = sprintf('<i>%s</i>', $format);
									}
									if ((string) $node['underline'] == 'true') {
										$format = sprintf('<u>%s</u>', $format);
									}
									$part.= $format;
								}
								break;
							case 'link':
								$part.= sprintf('<a href="%s" target="_blank">%s</a>', $node['url'], $node['linktext']);
								break;
							case 'txt':
								$part.= (string) $node;
								break;
							default:
								break;
						}
					}

					$part = trim($part);

					if ($part) {
						switch($paragraph['style']) {
							case 'od0': // Header
								//$part = sprintf("<small>%s</small>\n", $part);
								$part = '';
								break;
							case 'h0': // Title
							case 'oh0': // Online Title
								//$part = sprintf("<h1>%s</h1>\n", $part);
								$part = '';
								break;
							case 'v0': // Avant texte
							case 'ov0': // Avant texte
								$part = sprintf("<b>%s</b>\n<!--more-->\n", $part);
								break;
							case 'u0': // Subtitle
								$part = sprintf("<h2>%s</h2>\n", $part);
								break;
							case 'z0': // Inter Title
								$part = sprintf("<h3>%s</h3>\n", $part);
								break;
							case 'z1': // Inter Title 2
								$part = sprintf("<h4>%s</h4>\n", $part);
								break;
							case 'g0': // Paragraph
								$part = sprintf("<p>%s</p>\n", $part);
								break;
							case 'b0': // Legend
								$part = sprintf("<p>%s</p>\n", $part);
								break;
							case 'q0': // Enumeration Paragraph
								$part = sprintf("<li>%s</li>\n", $part);
								break;
							case 'a0': // Author
								$part = sprintf("<p>%s</p>\n", $part);
								break;
							case 'f0': // Note
								$part = sprintf("<em>%s</em>\n", $part);
								break;
							case 'p0': // Contact
								$part = sprintf("<!-- CONTACT: %s -->\n", $part);
								break;
							case 'g2': // Interview Question
							case 'kg2':
								$part = sprintf("<p>%s</p>\n", $part);
								break;
							case 'g3': // Interview Answer
							case 'kg3':
								$part = sprintf("<p>%s</p>\n", $part);
								break;
							case 'kh0': // Box Title
								$part = sprintf("<p><b>%s</b></p>\n", $part);
								break;
							case 'kg0': // Box Text
								$part = sprintf("<p>%s</p>\n", $part);
								break;
							case 'kq0': // Box Enumeration
								$part = sprintf("<li>%s</li>\n", $part);
								break;
							case 'kp0': // Box Contact
								$part = sprintf("<!-- CONTACT: %s -->\n", $part);
								break;
							case 'b9': // Source Image
								$part = '';
								break;
							default:
								$part = sprintf("<p>%s</p>\n", $part);
								break;
						}
						$body.= $part;
					} else {
						//$body.= PHP_EOL;
					}
				}
			}
		}

		if ($body) {

			/*
			if (in_array($channel, array(
				'Actualités',
				'Composants OEM',
				'Equipements de production & Techniques de fabrication',
				'Gestion',
				'Matériaux',
				'Question Réglementaires',
				'Sous-traitance & Services'
			))) {
			*/

				$wp_post['post_content'] = trim($body);
				$wp_post['post_title'] = trim($title);
				//$wp_post['post_excerpt'] = (string) $article->ABSTRACT;
				$wp_post['post_date'] = date('Y-m-d H:i:s', strtotime((string) $article->STARTDATUM));
				$wp_post['post_date_gmt'] = date('Y-m-d H:i:s', strtotime((string) $article->STARTDATUM));
				if ($channel) {
					$wp_post['post_category'] = array($wp_categories[$channel]);
				}
				
				if ($workflow_step != 'Freigegeben zur Veröffentlichung')
					continue;

				switch($workflow_step) {
					case 'Freigegeben':
						$wp_post['post_status'] = 'pending';
						break;
					case 'Freigegeben zur Veröffentlichung':
						$wp_post['post_status'] = 'publish';
						break;
					default:
						$wp_post['post_status'] = 'private';
						break;
				}

				//if ($wp_post_id = 1) {
				if ($wp_post_id = wp_insert_post($wp_post, $wp_error)) {
					add_post_meta($wp_post_id, '_vogel_context', trim($kicker));
					add_post_meta($wp_post_id, '_vogel_article_id', $pk);
					if ($attachments) {
						$wp_upload_dir = wp_upload_dir(date('Y/m', strtotime((string) $article->STARTDATUM)));
						foreach ($attachments as $attachment) {
							$source = $attachment['filename'];
							$destination = $wp_upload_dir['path'].'/'.basename($source);
							$filetype = wp_check_filetype(basename($source), null);
							if (file_exists($destination) OR copy($source, $destination)) {
								$wp_attachment = array(
									'guid' => $wp_upload_dir['url'].'/'.basename($source),
									'post_mime_type' => $filetype['type'],
									'post_title' => trim($attachment['legend']),
									'post_content' => '',
									'post_status' => 'inherit'
								);								
							}
							$wp_attachment_id = wp_insert_attachment($wp_attachment, $destination, $wp_post_id);
							$wp_attachment_data = wp_generate_attachment_metadata($wp_attachment_id, $destination);
							wp_update_attachment_metadata($wp_attachment_id, $wp_attachment_data);
							if ($attachment['featured']) {
								add_post_meta($wp_post_id, '_thumbnail_id', $wp_attachment_id);
							}
						}
					}
				//}
			}
		}
	}
}
/*
print_r($workflows);
print_r($workflow_steps);
print_r($types);
print_r($channels);
//print_r($styles);
*/