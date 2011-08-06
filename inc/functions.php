<?php

/**
 * error handling
 * make sure error logging work on live site.
 */
function err_warn($msg) {
	if (! DEV_ENV) {
		error_log(date('c') . " Warning: {$_SERVER['REQUEST_URI']}: $msg");
		return;
	}
	echo "<hr /><p><h3><em>Warning: </em>$msg</h3></p><pre>";
//	print_r(get_defined_vars());
//	print_r($_SESSION);
//	print_r($GLOBALS);
	echo "</pre>";
	die;
}
function err_fatal($msg) {
	if (DEV_ENV) {
		echo "<hr /><p><h3><em>FATAL: </em>$msg</h3></p><pre>";
		print_r(get_defined_vars());
		print_r($_SESSION);
		print_r($GLOBALS);
		echo "</pre>";
		die;
	}
	error_log(date('c') . " FATAL: {$_SERVER['REQUEST_URI']}: $msg");
	err_redir();
}
function err_redir() {
	header("Location: /error.php");
	die;
}

/**
 * an approach to a limited MVC frame
 */

/**
 * DRY,
 * path_xx functions
 */
function path_ctrl($str = '') {
	static $response_path;
	if (! $str)
		return $response_path;
	$response_path = $str;
	return DIR_CTRL . "/$str.php";
}
function path_view($str) {
	return DIR_VIEW . "/$str.tpl.php";
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
		include path_view(path_ctrl());
	}
}
