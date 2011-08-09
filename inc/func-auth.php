<?php

/**
 * users' registeration, login related functions 
 */


//create a new user (without any auths): use screen name.
function user_create($n){
	global $db;
	$query = "insert into `users` (`screen_name`) values ('{$db->real_escape_string($n)}')";
	$db->query($query);
	return $db->insert_id;
}


//set a basic auth link (username and password pair) for a existing user, use: uid, new username, new password, result user_id
function user_basic_auth($uid, $username, $passwd){
	global $db;
	if(user_basic_auth_exists($uid))
		die("用户($uid)已经设置过用户名和密码，如需更改，请使用用来修改用户名或者密码的方法");
	$query = "insert into `user_basic_auth` (`user_id`, `login_name`, `passwd`) values (
	'{$db->real_escape_string($uid)}',
	'{$db->real_escape_string($username)}',
	'". md5(SALT_PW . $passwd) ."')";
	$db->query($query);
	return $uid;
}

//set a openid (OAuth) auth link for a existing user, use: uid, service, remote_id, token, secret	, result user_id
function user_openid_auth($uid, $service, $remote_id, $token, $secret){
	global $db;
	if(user_openid_auth_exists($service, $remote_id))
		die("$service 上的 $remote_id 用户（或许是您）已经绑定过本网站的帐户。");
	$query = "insert into `user_oauth_links` (`user_id`, `service`, `remote_id`, `token`, `secret`) values (
	'{$db->real_escape_string($uid)}',
	'{$db->real_escape_string($service)}',
	'{$db->real_escape_string($remote_id)}',
	'{$db->real_escape_string($token)}',
	'{$db->real_escape_string($secret)}'
	)";
	$db->query($query);
	return $uid;
}

//create a new user (with basic password auth):use username, password, screen name.
function user_create_basic($username, $passwd, $screen_name) {
	if(user_exists($username))
		//TODO
		die("用户名($username)已注册，请直接登录");
	user_login(user_basic_auth(user_create($screen_name),$username,$passwd), false);
	header('Location: home');
}

//verify username exists: use username
function user_exists($n) {
	global $db;
	$query = "select * from `user_basic_auth`
		where `login_name` = '{$db->real_escape_string($n)}'";
	$result = $db->query($query);
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
	$result = $db->query($query);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row;
	}
	return false;
}

//verify openid auth link exists: use service and remote_id
function user_openid_auth_exists($service, $remote_id){
	global $db;
	$query = "select * from `user_oauth_links`
		where `service` = '{$db->real_escape_string($service)}' AND `remote_id` = '{$db->real_escape_string($remote_id)}'";
	$result = $db->query($query);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row;
	}
	return false;
}

//login successful (ATTENTION: no authorize in this function)  use: user_id, bool temp_login (if TRUE no cookie )
function user_login($user_id, $temp_login){
	global $db;
	$query = "select * from `users`
		where `id` = $user_id";
	if($result = $db->query($query)) {
		if($result->num_rows === 0) {
			$_SESSION['u_id'] = ''; 	
			return;
		}
		$user = $result->fetch_assoc();
		$result->free();
	}
	$_SESSION['u_id'] = $user_id;
	$_SESSION['u_screen_name'] = $user['screen_name'];	
	if(!$temp_login) {
		$expire = time()+3600*24*30;
		$stamp = date('YmdHis');
		cookie_set('u_id', $user_id, $expire);
		cookie_set('stamp', $stamp, $expire);
		cookie_set('hash', md5(date('Y-M-').$user_id.$stamp), $expire);
	} else
		cookie_set('u_id', '', time()-3600);
}

//log out , no input, no output
function user_logout(){
	cookie_set('hash', '', time()-3600);
	cookie_set('u_id', '', time()-3600);
	cookie_set('stamp', '', time()-3600);
	unset ($_SESSION['u_id']);
	unset ($_SESSION['u_screen_name']);
}

//user login verify, result true or false
function user_login_verify(){
	if($_SESSION['u_id']){
		return $_SESSION['u_id'];		
	}else{
		cookie_auth();
		return $_SESSION['u_id'];
	}
}

//cookie autorize
function cookie_auth() {
	global $db;
	if(!cookie_verify_hash()) {
		$_SESSION['u_id'] = '';
		return;
	}
	$uid = $_COOKIE['u_id'];
 
	$query = "select * from `users`
		where `id` = $uid";
	if($result = $db->query($query)) {
		if($result->num_rows === 0) {
			$_SESSION['u_id'] = '';
			cookie_set('hash', '', time()-3600);
			cookie_set('u_id', '', time()-3600);
			cookie_set('stamp', '', time()-3600);		
			return;
		}
		$user = $result->fetch_assoc();
		$result->free();
	}
	/*	
	if($_COOKIE['stamp'] <= $user['`stamp`+0']) {
		$_SESSION['logged_in'] = false;
		cookie_set('hash', '', time()-3600);
		return;
	}	
	$query = "select `pocket`, `amount` from `credit`
		where `id` = $uid";
	if($result = $db->query($query)) {
		$credit = array();
		while($row = $result->fetch_assoc())
		$credit[$row['pocket']] = $row['amount'];
		$result->free();
	}
	*/		
	$_SESSION['u_id'] = $uid;
	$_SESSION['u_screen_name'] = $user['screen_name'];
	cookie_refresh();
}

//cookie refresh
function cookie_refresh() {
	$expire = time()+3600*24*30;
	cookie_set('u_id', $_COOKIE['u_id'], $expire);
	cookie_set('hash', $_COOKIE['hash'], $expire);
	cookie_set('stamp', $_COOKIE['stamp'], $expire);
}
// verify cookie hash
function cookie_verify_hash() {
	if(!isset($_COOKIE['hash']) || !isset($_COOKIE['u_id']) || !isset($_COOKIE['stamp']))
	return false;
	$date = date_create();
	$salt1 = $date->format('Y-M-');
	$date->modify('-1 month');
	$salt2 = $date->format('Y-M-');
	if (($_COOKIE['hash'] == md5($salt1 . $_COOKIE['u_id'] . $_COOKIE['stamp'])) ||
	($_COOKIE['hash'] == md5($salt2 . $_COOKIE['u_id'] . $_COOKIE['stamp'])))
	return true;
	else {
		cookie_set('hash', '', time()-3600);
		cookie_set('u_id', '', time()-3600);
		cookie_set('stamp', '', time()-3600);		
		return false;
	}
}


