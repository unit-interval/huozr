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


//set a basic auth link (username and password pair) for a existing user, use: uid, new username, new password
function user_basic_auth($uid, $username, $passwd){
	global $db;
	if(user_basic_auth_exists($uid))
		die("用户($uid)已经设置过用户名和密码，如需更改，请使用用来修改用户名或者密码的方法");
	$query = "insert into `user_basic_auth` (`user_id`, `login_name`, `passwd`) values (
	'{$db->real_escape_string($uid)}',
	'{$db->real_escape_string($username)}',
	'". md5(SALT_PW . $passwd) ."')";
	$db->query($query);
}

//set a openid (OAuth) auth link for a existing user, use: uid, service, remote_id, token, secret	
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
}

//create a new user (with basic password auth):use username, password, screen name.
function user_create_basic($username, $passwd, $screen_name) {
	if(user_exists($username))
		die("用户名($username)已注册，请直接登录");
	user_basic_auth(user_create($screen_name),$username,$passwd);
	echo "注册成功，转到已登陆页面<br />";
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

//renren_connection, result: setup related session.

function renren_oauth($code){
	$oauth = new RenRenOauth();
	$client = new RenRenClient();	
	try {
		if(!isset($code) && !$_SESSION['renren_state']) {
			$_SESSION['renren_state'] = 1;
			header('Location: ' . $oauth->getAuthorizeUrl());
			exit;
		} elseif($_SESSION['renren_state']==1) {
			$token = $oauth->getAccessToken($code);
			$key = $oauth->getSessionKey($token['access_token']);			
			$client->setSessionKey($key['renren_token']['session_key']);
			$_SESSION['renren_token'] = $token['access_token'];
			$_SESSION['renren_secret'] = $key['renren_token']['session_key'];			
			$users=$client->POST('users.getInfo','uid,name');
			foreach($users as $user) {
				$_SESSION['renren_uid']=$user['uid'];
				$_SESSION['renren_name']=$user['name'];
			}
			$_SESSION['renren_state'] = 2;
		}


	} catch(OAuthException $E) {
		echo '<p>An error occurred, please come back later.<p>';
		print_r($E);
	}

}

//sina weibo oauth,result: setup related session.

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
			$oauth->setToken($oauth_token,$_SESSION['sinawb_secret']);
			$access_token = $oauth->getAccessToken(SINAWB_ACC_URL);
			$_SESSION['sinawb_token'] = $access_token['oauth_token'];
			$_SESSION['sinawb_secret'] = $access_token['oauth_token_secret'];
			$_SESSION['sinawb_uid'] = $access_token['user_id'];
			$oauth->setToken($_SESSION['sinawb_token'],$_SESSION['sinawb_secret']);
			$oauth->fetch(SINAWB_API_BASE . 'account/verify_credentials.json');
			$json = json_decode($oauth->getLastResponse(), true);
			$_SESSION['sinawb_name'] = $json['name'];
			$_SESSION['sinawb_state'] = 2;
		}

	} catch(OAuthException $E) {
		echo '<a href="login.php?s=sina_weibo">An error occurred, please retry.<a>';
		print_r($E);
	
	}
}

//tencent weibo oauth,result: setup related session.

function tencent_weibo_oauth($oauth_token){
	try {
		$oauth = new OAuth(QQWB_AKEY, QQWB_SKEY);
		$oauth->enableDebug();
		$oauth->setAuthType(oauth_urlencode(OAUTH_AUTH_TYPE_URI));
		if(!isset($oauth_token) && !$_SESSION['qqwb_state']) {
			$request_token = $oauth->getRequestToken(oauth_urlencode(QQWB_REQ_URL),oauth_urlencode(QQWB_CB_URL));
			$_SESSION['qqwb_secret'] = $request_token['oauth_token_secret'];
			$_SESSION['qqwb_state'] = 1;
			header('Location: ' . QQWB_AUTH_URL . '?oauth_token=' . $request_token['oauth_token'] . '&oauth_callback=' . oauth_urlencode(QQWB_CB_URL) . '&display=page');
			exit;
		} elseif($_SESSION['qqwb_state']==1) {
			$oauth->setToken($oauth_token,$_SESSION['qqwb_secret']);
			$access_token = $oauth->getAccessToken(oauth_urlencode(QQWB_ACC_URL));
			$_SESSION['qqwb_token'] = $access_token['oauth_token'];
			$_SESSION['qqwb_secret'] = $access_token['oauth_token_secret'];
			//$_SESSION['qqwb_uid'] = $access_token['user_id'];
			$oauth->setToken($_SESSION['qqwb_token'],$_SESSION['qqwb_secret']);
			$oauth->fetch('http://open.t.qq.com/api/user/info');
			$json = json_decode($oauth->getLastResponse(), true);
			$_SESSION['qqwb_uid'] = $json['data']['name'];
			$_SESSION['qqwb_name'] = $json['data']['nick'];
			$_SESSION['qqwb_state'] = 2;
		}


	} catch(OAuthException $E) {
		echo '<a href="login.php?s=tencent_weibo">An error occurred, please retry.<a>';
		print_r($E);
	
	}
}