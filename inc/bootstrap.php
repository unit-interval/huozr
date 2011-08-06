<?php

/**
 * prepare functions and varialbles that need to be loaded on every request.
 */

/** turn on output buffering */
ob_start();

/** include necessary files */
include DIR_INC . '/functions.php';
include DIR_INC . '/database.php';

/**
 * parse request uri
 * call req_path() to get current path
 * TODO: perhaps wrap these in a object
 */
$req_path_str = strtok($_SERVER['REQUEST_URI'], '?');
$req_path_cur = '';
$req_path = explode('/', trim($req_path_str, '/'));
$req_path_parent = array();
function req_path() {
	global $req_path_cur, $req_path, $req_path_parent;
	$req_path_cur = array_shift($req_path);
	$req_path_parent[] = $req_path_cur;
	return $req_path_cur;
}

/**
 * prepare array to hold all instance variables
 */
$res = array();
$yield_for = array();
