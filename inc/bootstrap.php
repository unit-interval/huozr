<?php

/**
 * prepare functions and varialbles that need to be loaded on every request.
 */

/** include necessary files */
include DIR_INC . '/functions.php';
include DIR_INC . '/database.php';

/**
 * parse request uri
 * call req_path() to get current path
 * TODO: perhaps wrap these in a object
 */
$req_path_cur = '';
$req_path = explode('/', trim(strtok($_SERVER['REQUEST_URI'], '?'), '/'));
//$req_path_parent = array();
function req_path() {
	global $req_path_cur, $req_path;
//	global $req_path_parent;
	$req_path_cur = array_shift($req_path);
//	if ($req_path_cur)
//		$req_path_parent[] = $req_path_cur;
	return $req_path_cur;
}

session_name(SESSNAME);
session_start();


