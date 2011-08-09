<?php

/**
 * access_control
 * redirect user to /login unless requesting a public page
 */
function filter_access_control() {
	$exclude = array(
		'',
		'login',
		'login/',
		'404',
	);

	$req_str = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

	$path = '';
	for ($offset = 0; $pos = strpos($req_str, '/', $offset), $offset = $pos + 1) {
		$path .= substr($req_str, 0, $pos);
		if (in_array($path, $exclude))
			return;
	}
	if (! $_SESSION['u_id']) {
		//TODO generalized callback solution
		$_SESSION['callback_uri'] = $_SERVER['REQUEST_URI'];
		// notice user
		redir_to('/login/');
	}
}

/**
 * string_preprocess
 * preprocess string for output
 */
function filter_string_preprocess() {
	global $res;
	$res['head_title'] .= ' | 活字网';
}

/**
 * wrapper around all filters
 */
function do_filter($fil, $param = null) {
	static $count = array();
	static $max = array(
		'access_control' => 1,
	);
	if (array_key_exists($fil, $max)) {
		if (! isset($count[$fil]))
			$count[$fil] = 0;
		$count[$fil]++;
		if ($count[$fil] > $max[$fil])
			return;
	}
	$func = "filter_$fil";
	if (! function_exists($func)) {
		err_warn("calling non-existent filter '$fil'.");
		return;
	}
	$func($param);
}