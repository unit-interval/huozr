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
		'partner',
		'partner/',
		'404',
	);

	$req_str = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

	$path = '';
	$offset = 0; 
	while ($pos = strpos($req_str, '/', $offset)) {
		$path .= substr($req_str, 0, $pos + 1);
		if (in_array($path, $exclude))
			return;
		$offset = $pos + 1;
	}
	if (in_array($req_str, $exclude))
		return;
	if (! $_SESSION['user_id']) {
		//TODO generalized callback solution
		$_SESSION['callback_uri'] = $_SERVER['REQUEST_URI'];
		// notice user
		redir_to('/login/');
	}
}
function filter_access_control_partner() {
	global $req_path;
	$exclude = array(
		'login',
		'auth',
	);
	if (in_array($req_path[0],$exclude))
		return;
	if (! $_SESSION['partner_id']) {
		//TODO generalized callback solution
		$_SESSION['callback_uri'] = $_SERVER['REQUEST_URI'];
		// notice user
		redir_to('/partner/login/');
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
