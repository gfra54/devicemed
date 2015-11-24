<?php
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
define('BASE_DIRECTORY', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

function message($string) {
	echo $string;
	for($i=0;$i<10;$i++) ob_flush();
}
$xml = new SimpleXMLElement(file_get_contents('2014-04-09_articles.xml'));
foreach ($xml->xpath('/ARTICLES/ARTICLE') as $article) {
	if ((string) $article->XML) {
		/*
		$article_xml = new SimpleXMLElement(
			mb_convert_encoding(
				$article->XML,
				'UTF-8')
		);
		*/
		foreach ($article->ARTICLESIMAGES as $articles_images) {
			foreach ($articles_images->ARTICLESIMAGE as $articles_image) {
				message(sprintf('Downloading %s...\n', $articles_image->IMAGE));
				$destination = 'images'.DS.str_replace('/', '_', substr((string) $articles_image->IMAGE, 40));
				$source = file_get_contents((string) $articles_image->IMAGE);
				file_put_contents($destination, $source);
			}
		}
	}
}
exit;

$xml = new DOMDocument('1.0', 'iso-8859-1');
$xml->load('2014-04-09_articles.xml');

$xpath = new DOMXPath($xml);
foreach ($xpath->query('/ARTICLES/ARTICLE') as $article) {
	echo $article->nodeValue;
}


exit;


require_once implode(DS, array(BASE_DIRECTORY, 'application', 'libraries', 'wordpress', 'wp-load.php'));

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

$wp_post = $wp_post_default;

$xsl = new DOMDocument();
$xsl->load('html.xsl');

$xml = new DOMDocument();
$xml->load('article.xml');

$xpath = new DOMXpath($xml);
foreach ($xpath->query('header/title') as $element) {
	$wp_post['post_title'] = $element->nodeValue;
}

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);
$wp_post['post_content'] = $xslt->transformToXML($xml);

if ($wp_post_id = wp_insert_post($wp_post, $wp_error)) {
	echo 'OK';
} else {
	print_r($wp_error);
}