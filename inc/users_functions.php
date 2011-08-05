<?php

/**
 * users' registeration, login related functions 
 */


//create a new user (without any auths): use screen name.
function user_create($n){
	global $db;
	$query = "insert into `users` (`screen_name`) values ('{$db->real_escape_string($n)}')";
	if($db->query($query) !== TRUE)
		die("db error({$db->errno}).");
	return $db->insert_id;
}

//verify username exists: use username
function user_exists($n) {
	global $db;
	$query = "select * from `user_basic_auth`
		where `login_name` = '{$db->real_escape_string($n)}'";
	if(!($result = $db->query($query)))
		die("db error({$db->errno}). query:$query");
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row;
	}
	return false;
}

//verify basic auth link exists: use user_id
function user_basic_auth_exists($uid){
	global $db;
	$query = "select * from `user_basic_auth`
		where `user_id` = '{$db->real_escape_string($uid)}'";
	if(!($result = $db->query($query)))
		die("db error({$db->errno}). query:$query");
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row;
	}
	return false;
}

//set a basic auth link (username and password pair) for a existing user, use: uid, new username, new password
function user_basic_auth($uid, $username, $passwd){
	global $db;
	if(user_basic_auth_exists($uid))
		die("用户($uid)已经设置过用户名和密码，如需更改，请使用用来修改用户名或者密码的方法");
	$query = "insert into `user_basic_auth` (`user_id`, `login_name`, `passwd`) values (
	'{$db->real_escape_string($uid)}',
	'{$db->real_escape_string($username)}',
	'". md5(SALT_PW . $passwd) ."')";
	if($db->query($query) !== TRUE)
		die("db error({$db->errno}).");
}
	

//create a new user (with basic password auth):use username, password, screen name.
function user_create_basic($username, $passwd, $screen_name) {
	if(user_exists($username))
		die("用户名($username)已注册，请直接登录");
	user_basic_auth(user_create($screen_name),$username,$passwd);
	echo "转到已经登陆<br />";
}

