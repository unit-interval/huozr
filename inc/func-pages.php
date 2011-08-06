<?php

define('RELPATH_CSS', '/media/css');
define('RELPATH_JS', '/media/js');
define('DIR_CSS', DIR_ROOT . RELPATH_CSS);
define('DIR_JS', DIR_ROOT . RELPATH_JS);

function css_tags() {
	global $css_tags;
	$html = '';
	foreach($css_tags as $t) {
		$fn = DIR_CSS . "/$t.css";
		$ln = RELPATH_CSS . "/$t.css";
		if(DEV_ENV && ! file_exists($fn))
			err_warn("file not found: $fn");
		$html .= "<link rel='stylesheet' type='text/css' href='$ln' />";
	}
	return $html;
}
function js_tags() {
	global $js_tags;
	$html = '';
	foreach($js_tags as $t) {
		$fn = DIR_JS . "/$t.js";
		$ln = RELPATH_JS . "/$t.js";
		if(DEV_ENV && ! file_exists($fn))
			err_warn("file not found: $fn");
		$html .= "<script type='text/javascript' src='$ln'></script>";
	}
	return $html;
}
