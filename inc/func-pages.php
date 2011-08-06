<?php

/**
 * generate css/js tags that can be used in html <head></head>
 * 
 * call w/o parameters to output the actual tags
 *
 * accepts variable pamameter list length.
 * pass css/js filenames in to save for later output
 *
 * use "-" as first parameter to remove entries
 * if "-" in the only parameter, all existing entries are purged.
 */
define('RELPATH_CSS', '/media/css');
define('RELPATH_JS', '/media/js');
define('DIR_CSS', DIR_ROOT . RELPATH_CSS);
define('DIR_JS', DIR_ROOT . RELPATH_JS);
function css_link_tags() {
	static $tags = array();
	$numargs = func_num_args();
	if ($numargs === 0) {
		//TODO: make it cache friendly
		$html = '';
		foreach($tags as $t) {
			$fn = DIR_CSS . "/$t.css";
			if(DEV_ENV && ! file_exists($fn))
				err_warn("file not found: $fn");
			$ln = RELPATH_CSS . "/$t.css";
			$html .= "<link rel='stylesheet' type='text/css' href='$ln' />";
		}
		return $html;
	} elseif (func_get_arg(0) === '-') {
		if ($numargs === 1) {
			$tags == array();
			return;
		}
		for ($i = 0; $i++ < $numargs; ) {
			if ($key = array_search(func_get_arg($i), $tags))
				unset($tags[$key]);
		}
	} else {
		for ($i = 0; $i < $numargs; $i++)
			$tags[] = func_get_arg($i);
	}
}
function js_script_tags() {
	static $tags = array();
	$numargs = func_num_args();
	if ($numargs === 0) {
		//TODO: make it cache friendly
		$html = '';
		foreach($tags as $t) {
			$fn = DIR_JS . "/$t.js";
			if(DEV_ENV && ! file_exists($fn))
				err_warn("file not found: $fn");
			$ln = RELPATH_JS . "/$t.js";
			$html .= "<script type='text/javascript' src='$ln'></script>";
		}
		return $html;
	} elseif (func_get_arg(0) === '-') {
		if ($numargs === 1) {
			$tags == array();
			return;
		}
		for ($i = 0; $i++ < $numargs; ) {
			if ($key = array_search(func_get_arg($i), $tags))
				unset($tags[$key]);
		}
	} else {
		for ($i = 0; $i < $numargs; $i++)
			$tags[] = func_get_arg($i);
	}
}

