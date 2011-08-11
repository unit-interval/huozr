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
			$html .= "<link rel='stylesheet' type='text/css' href='$ln' />\n";
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
			$html .= "<script type='text/javascript' src='$ln'></script>\n";
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

/**
 * add accepted sub requests
 * or check if request is accecpted
 */
function accepts() {
	static $accepted = array();
	if (func_get_arg(0) == '-') {
		foreach($accepted as $pattern) {
			if(preg_match($pattern, func_get_arg(1)))
				return true;
		}
		return false;
	}
	$numargs = func_num_args();
	for($i = 0; $i < $numargs; $i++) {
		$pattern = func_get_arg($i);
		if (preg_match('/^[0-9A-Za-z]/', $pattern))
			$pattern = "/^$pattern\$/";
		$accepted[] = $pattern;
	}
}
/**
 * generate the entire content if called without param
 * or a yielding region if called with one region name
 */
function yield($region = '') {
	// use variable variables as a workaround to variable scope
	global $res;
	foreach ($res as $k => $v)
		$$k = $v;

	if ($region) {
		global $yield_for;
		$yielding_for = $yield_for[$region];
		include path_view('_' . $region);
	} else {
		include path_view(path_ctrl(null, 2));
	}
}

