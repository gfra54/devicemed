<?php 
/*
Template Name: textad
*/
$GLOBALS['ADVANCED_ADS_PAGE']='all';
ob_start();
the_ad_group(3788); 
$content = ob_get_contents();
$content = addslashes($content);
$content = str_replace(PHP_EOL,'\n',$content);
ob_end_clean();


header('Content-Type: application/javascript');
echo 'document.write(\''.$content.'\');';
