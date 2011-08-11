<?php

/**
 * error handling
 * make sure error logging work on live site.
 */

/**
 * for developers only, dump all param to browser
 */
function err_debug($dump = false) {
	if(! DEV_ENV)
		return;
	for ($i = 0; $i < func_num_args(); $i++) {
		echo "<hr /><p><h3><em>DEBUG: </em>printing/dumping variables</h3></p><pre>";
		if ($dump === true)
			var_dump(func_get_args());
		else
			print_r(func_get_args());
		echo "</pre>";
		die;
	}
}
/** 
 * for common users, log error, but script continues to run
 * for developers, exit script, outputing error msg
 */
function err_warn($msg = '') {
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
/**
 * for common users, log error and show error page, interrupting any unfinished job.
 * for developers, output all defined variables
 */
function err_fatal($msg = '') {
	if (! DEV_ENV) {
		error_log(date('c') . " FATAL: {$_SERVER['REQUEST_URI']}: $msg");
		err_redir();
	}
	echo "<hr /><p><h3><em>FATAL: </em>$msg</h3></p><pre>";
	print_r(get_defined_vars());
	print_r($_SESSION);
	print_r($GLOBALS);
	echo "</pre>";
	die;
}
/**
 * redirect user to error page
 * TODO which error types is this page designed for?
 * TODO show notice on target page
 */
function err_redir() {
	header("Location: /error");
	die;
}

/**
 * basic http header redirecting
 */
function redir_to($loc = '/') {
	header("Location: $loc");
	exit;
}

/**
 * cache the request string and output the controller file path
 * works in 5 modes:
 * 0 - (default) return previous/current controller file path
 * 1 - mode 0 plus pushing current request into the cache
 * 2 - output the request string, not the controller file path
 * 3 - translate $str to it's controller file path
 * 4 - mode 3 plus replacing the cache with current request
 */
function path_ctrl($str = '', $m = 0) {
	static $cache = '';
	if (! $str)	// in mode 0/2
		return ($m == 2 ? $cache : DIR_CTRL . "/$cache.php");

	switch ($m) {
	case 0:
		if ($cache)
			$str = "$cache/$str";
		break;
	case 1:
		$cache = $cache ? "$cache/$str" : $str;
		$str = $cache;
		break;
	case 2:
		if ($cache)
			$str = "$cache/$str";
		return $str;
		break;
	case 3:
		return DIR_CTRL . "/$str.php";
		break;
	case 4:
		$cache = $str;
		return DIR_CTRL . "/$str.php";
		break;
	}
	return DIR_CTRL . "/$str.php";
}
/**
 * translate $str to it's view file path
 */
function path_view($str) {
	return DIR_VIEW . "/$str.tpl.php";
}


/**
 * translate $str to it's view file path
 */
function cookie_set($name, $value, $expire){
	return setcookie($name, $value, $expire, '/login/'); 
}
