<?php

/**
 * users' registeration, login related functions 
 */

//sina weibo API
define('SINAWB_AKEY' , '1515110245' );
define('SINAWB_SKEY' , 'bb1c7d7a0e39162c46fc5a3ca905a64a' );
define('SINAWB_API_BASE', 'http://api.t.sina.com.cn/');
define('SINAWB_REQ_URL' , SINAWB_API_BASE . 'oauth/request_token');
define('SINAWB_AUTH_URL' , SINAWB_API_BASE . 'oauth/authorize');
define('SINAWB_ACC_URL' , SINAWB_API_BASE . 'oauth/access_token');
define('SINAWB_CB_URL' , 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);

//tencent weibo API
define('QQWB_AKEY' , 'ddcd36807f9547f6b4c810d426c6a79c' );
define('QQWB_SKEY' , 'bcf82b87fad59409155ffe5755dd1eaa' );
define('QQWB_API_BASE', 'http://open.t.qq.com/api/');
define('QQWB_REQ_URL' , 'https://open.t.qq.com/cgi-bin/request_token');
define('QQWB_AUTH_URL' , 'https://open.t.qq.com/cgi-bin/authorize');
define('QQWB_ACC_URL' , 'https://open.t.qq.com/cgi-bin/access_token');
define('QQWB_CB_URL' , 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);

//douban API
define('DOUBAN_AKEY' , '007bc48b65d62ad001734da231828070' );
define('DOUBAN_SKEY' , '973ceebd6cfcf878' );
define('DOUBAN_API_BASE', 'http://api.douban.com/');
define('DOUBAN_REQ_URL' , 'http://www.douban.com/service/auth/request_token');
define('DOUBAN_AUTH_URL' , 'http://www.douban.com/service/auth/authorize');
define('DOUBAN_ACC_URL' , 'http://www.douban.com/service/auth/access_token');
define('DOUBAN_CB_URL' , 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);

require_once(DIR_INC . '/connetion_renren.php');
/* 不用下列常量，转用人人 SDK
define('RENREN_AKEY','3626a6bb44aa4c94833c6f5f7113608b');
define('RENREN_SKEY','f9c60c420b704c408b0c85813ea60a28');
define('RENREN_API','http://api.renren.com/restserver.do');
define('RENREN_AUTH_URL','https://graph.renren.com/oauth/authorize');
define('RENREN_ACC_URL','https://graph.renren.com/oauth/token');
define('RENREN_SSKEY_URL','https://graph.renren.com/renren_api/session_key');
define('RENREN_CB_URL','http://gene.shiyiquan.cn/login.php?s=renren');
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
		die("用户名($username)已注册，请直接登录");
	user_login(user_basic_auth(user_create($screen_name),$username,$passwd), false);
	header('Location: oauth.php?s=home');
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

//renren_connection, result: array with token, secret, remote_id, remote_screen_name.

function renren_oauth($code){
	$oauth = new RenRenOauth();
	$client = new RenRenClient();	
	try {
		if(!isset($code) && !$_SESSION['renren_state']) {
			$_SESSION['renren_state'] = 1;
			header('Location: ' . $oauth->getAuthorizeUrl());
			exit;
		} elseif($_SESSION['renren_state']==1) {
			$renren = array();
			$token = $oauth->getAccessToken($code);
			$key = $oauth->getSessionKey($token['access_token']);			
			$client->setSessionKey($key['renren_token']['session_key']);
			$renren['token'] = $token['access_token'];
			$renren['secret'] = $key['renren_token']['session_key'];			
			$users=$client->POST('users.getInfo','uid,name');
			foreach($users as $user) {
				$renren['remote_id']=$user['uid'];
				$renren['remote_screen_name']=$user['name'];
			}
			return $renren;
		}


	} catch(OAuthException $E) {
		echo '<p>An error occurred, please come back later.<p>';
		print_r($E);
	}

}

//sina weibo oauth,result: array with token, secret, remote_id, remote_screen_name.

function sina_weibo_oauth($oauth_token){
	try {
		$oauth = new OAuth(SINAWB_AKEY, SINAWB_SKEY);
		$oauth->enableDebug();
		if(!isset($oauth_token) && !$_SESSION['sinawb_state']) {
			$request_token = $oauth->getRequestToken(SINAWB_REQ_URL);
			$_SESSION['sinawb_secret'] = $request_token['oauth_token_secret'];
			$_SESSION['sinawb_state'] = 1;
			header('Location: ' . SINAWB_AUTH_URL . '?oauth_token=' . $request_token['oauth_token'] . '&oauth_callback=' . rawurlencode(SINAWB_CB_URL) . '&display=page');
			exit;
		} elseif($_SESSION['sinawb_state']==1) {
			$sinawb = array();
			$oauth->setToken($oauth_token,$_SESSION['sinawb_secret']);
			$access_token = $oauth->getAccessToken(SINAWB_ACC_URL);
			$sinawb['token'] = $access_token['oauth_token'];
			$sinawb['secret'] = $access_token['oauth_token_secret'];
			$sinawb['remote_id'] = $access_token['user_id'];
			$oauth->setToken($sinawb['token'],$sinawb['secret']);
			$oauth->fetch(SINAWB_API_BASE . 'account/verify_credentials.json');
			$json = json_decode($oauth->getLastResponse(), true);
			$sinawb['remote_screen_name'] = $json['name'];
			return $sinawb;
		}

	} catch(OAuthException $E) {
		echo '<a href="login.php?s=sina_weibo">An error occurred, please retry.<a>';
		print_r($E);
	
	}
}

//tencent weibo oauth,result: array with token, secret, remote_id, remote_screen_name.

function tencent_weibo_oauth($oauth_token){
	try {
		$oauth = new OAuth(QQWB_AKEY, QQWB_SKEY);
		$oauth->enableDebug();
		//腾讯的独到之处
		$oauth->setNonce(md5(rand()));
		$oauth->setAuthType(OAUTH_AUTH_TYPE_URI);
		//
		if(!isset($oauth_token) && !$_SESSION['qqwb_state']) {
			$request_token = $oauth->getRequestToken(QQWB_REQ_URL,QQWB_CB_URL);
			$_SESSION['qqwb_secret'] = $request_token['oauth_token_secret'];
			$_SESSION['qqwb_state'] = 1;
			header('Location: ' . QQWB_AUTH_URL . '?oauth_token=' . $request_token['oauth_token'] . '&oauth_callback=' . QQWB_CB_URL . '&display=page');
			exit;
		} elseif($_SESSION['qqwb_state']==1) {
			$qqwb = array();
			$oauth->setToken($oauth_token,$_SESSION['qqwb_secret']);
			$access_token = $oauth->getAccessToken(QQWB_ACC_URL);
			$qqwb['token'] = $access_token['oauth_token'];
			$qqwb['secret'] = $access_token['oauth_token_secret'];
			//$_SESSION['qqwb_uid'] = $access_token['user_id'];
			$oauth->setToken($qqwb['token'],$qqwb['secret']);
			$oauth->fetch('http://open.t.qq.com/api/user/info');
			$json = json_decode($oauth->getLastResponse(), true);
			$qqwb['remote_id'] = $json['data']['name'];
			$qqwb['remote_screen_name'] = $json['data']['nick'];
			return $qqwb;
		}
	} catch(OAuthException $E) {
		echo '<a href="login.php?s=tencent_weibo">An error occurred, please retry.<a>';
		print_r($E);
	
	}
}

//douban oauth,result: array with token, secret, remote_id, remote_screen_name.

function douban_oauth($oauth_token){
	try {
		$oauth = new OAuth(DOUBAN_AKEY, DOUBAN_SKEY);
		$oauth->enableDebug();
		if(!isset($oauth_token) && !$_SESSION['douban_state']) {
			$oauth->setAuthType(OAUTH_AUTH_TYPE_URI);		
			$request_token = $oauth->getRequestToken(DOUBAN_REQ_URL);
			$_SESSION['douban_secret'] = $request_token['oauth_token_secret'];
			$_SESSION['douban_state'] = 1;
			header('Location: ' . DOUBAN_AUTH_URL . '?oauth_token=' . $request_token['oauth_token'] . '&oauth_callback=' . rawurlencode(DOUBAN_CB_URL) . '&display=page');
			exit;
		} elseif($_SESSION['douban_state']==1) {
			$douban = array();
			$oauth->setAuthType(OAUTH_AUTH_TYPE_URI);		
			$oauth->setToken($oauth_token,$_SESSION['douban_secret']);
			$access_token = $oauth->getAccessToken(DOUBAN_ACC_URL);
			$douban['token'] = $access_token['oauth_token'];
			$douban['secret'] = $access_token['oauth_token_secret'];
			$oauth->setToken($douban['token'],$douban['secret']);
			$oauth->fetch(DOUBAN_API_BASE . 'people/%40me',array("alt" => "json"));
			$json = json_decode($oauth->getLastResponse(), true);
			$douban['remote_screen_name'] = $json['title']['$t'];
			$douban['remote_id'] = $json['db:uid']['$t'];
			return $douban;
		}
	} catch(OAuthException $E) {
		//echo '<a href="login.php?s=douban">An error occurred, please retry.<a>';
		//print_r($E);
	
	}
}

//login successful (ATTENTION: no authorize in this function)  use: user_id, bool temp_login (if TRUE no cookie )
function user_login($user_id, $temp_login){
	global $db;
	$query = "select * from `users`
		where `id` = $user_id";
	if($result = $db->query($query)) {
		if($result->num_rows === 0) {
			$_SESSION['u_id'] = ''; //登录失败！ 	
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
		setcookie('uid', $user_id, $expire);
		setcookie('stamp', $stamp, $expire);
		setcookie('hash', md5(date('Y-M-').$user_id.$stamp), $expire);
	} else
		setcookie('uid', '', time()-3600);
}

//log out , no input, no output
function user_logout(){
	setcookie('hash', '', time()-3600);
	setcookie('uid', '', time()-3600);
	setcookie('stamp', '', time()-3600);
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
	$uid = $_COOKIE['uid'];
 
	$query = "select * from `users`
		where `id` = $uid";
	if($result = $db->query($query)) {
		if($result->num_rows === 0) {
			$_SESSION['u_id'] = '';
			setcookie('hash', '', time()-3600);
			setcookie('uid', '', time()-3600);
			setcookie('stamp', '', time()-3600);		
			return;
		}
		$user = $result->fetch_assoc();
		$result->free();
	}
	/*	
	if($_COOKIE['stamp'] <= $user['`stamp`+0']) {
		$_SESSION['logged_in'] = false;
		setcookie('hash', '', time()-3600);
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
	foreach($_COOKIE as $key => $value)
	setcookie($key, $value, $expire);
}
// verify cookie hash
function cookie_verify_hash() {
	if(!isset($_COOKIE['hash']) || !isset($_COOKIE['uid']) || !isset($_COOKIE['stamp']))
	return false;
	$date = date_create();
	$salt1 = $date->format('Y-M-');
	$date->modify('-1 month');
	$salt2 = $date->format('Y-M-');
	if (($_COOKIE['hash'] == md5($salt1 . $_COOKIE['uid'] . $_COOKIE['stamp'])) ||
	($_COOKIE['hash'] == md5($salt2 . $_COOKIE['uid'] . $_COOKIE['stamp'])))
	return true;
	else {
		setcookie('hash', '', time()-3600);
		setcookie('uid', '', time()-3600);
		setcookie('stamp', '', time()-3600);		
		return false;
	}
}


