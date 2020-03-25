<?php
$GLOBALS['SVG_PATH'] = get_template_directory().'/images/svg/';

function svg($what) {
	$file = $GLOBALS['SVG_PATH'].sanitize_title($what).'.svg';
	if(file_exists($file)) {
		$out = file_get_contents($file);

		$out = preg_replace('/(<[^>]+) stroke=".*?"/i', '$1', $out);
		$out = preg_replace('/(<[^>]+) fill=".*?"/i', '$1', $out);

		$out = '<span class="svg-image svg-'.$what.'">'.$out.'</span>';

		return $out;
	}
}