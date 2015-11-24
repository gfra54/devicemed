<?php
	header("Content-Type: text/css");
	require_once('sass/SassParser.php'); //including Sass libary (Syntactically Awesome Stylesheets)
	$sass = new SassParser(array('style'=>'compressed'));
	$css = $sass->toCss('default.scss');
	echo $css;
?>﻿