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
