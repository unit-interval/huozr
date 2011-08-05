<?php

/**
 * error handling
 */
function err_fatal($msg) {
	if (DEV_ENV) {
		echo "<hr /><p><h3><em>FATAL: </em>$msg</h3></p><pre>";
		print_r(get_defined_vars());
		print_r($_SESSION);
		print_r($GLOBALS);
		echo "</pre>";
		die;
	}
// TODO: make error log work on live site.
	if ($handle = fopen(DIR_ROOT . '/tmp/huozr-error.log', 'a')) {
		fputcsv($handle, array(date('c'), 'FATAL', $_SERVER['REQUEST_URI'], $msg));
		fclose($handle);
	}
	err_redir();
}
function err_redir() {
	header("Location: /error.php");
	die;
}
