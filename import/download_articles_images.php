<?php

exit; // LOCK

set_time_limit(0);
header('Content-Type: text/plain; charset=utf-8');

define('BASE_DIRECTORY', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

function message($string) {
	echo $string;
	for($i=0;$i<10;$i++) ob_flush();
}

/*
chdir('images');
foreach (glob('*.jpg') as $file) {
	$source = $file;
	$destination = preg_replace('/[0-9]+_([0-9]+)_sourceimage\.([a-z]+)/i', '\\1.\\2', $file);
	rename($source, $destination);
}
exit;
*/

$xml = new SimpleXMLElement(file_get_contents('sources'.DS.'2014-04-09_articles.xml'));
foreach ($xml->xpath('/ARTICLES/ARTICLE') as $article) {
	if ((string) $article->XML) {
		foreach ($article->ARTICLESIMAGES as $articles_images) {
			foreach ($articles_images->ARTICLESIMAGE as $articles_image) {
				$source = (string) $articles_image->IMAGE;
				$filename = preg_replace('/http:\/\/images\.vogel\.de\/vogelonline\/bdb\/[0-9]+\/([0-9]+)\/sourceimage\.([a-z]+)/i', '\\1.\\2', $source);
				$destination = 'images'.DS.$filename;
				message(sprintf("Downloading %s to %s...\n", $source, $destination));
				file_put_contents($destination, file_get_contents($source));
			}
		}
	}
}