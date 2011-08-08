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
	header("Location: /error");
	die;
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
