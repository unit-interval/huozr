<?php
include 'config.php';
include DIR_INC . '/users_functions.php';
// renren sdk
include DIR_INC . '/connetion_renren.php';


//sina weibo API
define('SINAWB_AKEY' , '1515110245' );
define('SINAWB_SKEY' , 'bb1c7d7a0e39162c46fc5a3ca905a64a' );
define('SINAWB_API_BASE', 'http://api.t.sina.com.cn/');
define('SINAWB_REQ_URL' , SINAWB_API_BASE . 'oauth/request_token');
define('SINAWB_AUTH_URL' , SINAWB_API_BASE . 'oauth/authorize');
define('SINAWB_ACC_URL' , SINAWB_API_BASE . 'oauth/access_token');
define('SINAWB_CB_URL' , 'http://gene.shiyiquan.cn/login.php?s=sina_weibo');

/* 不用下列常量，转用人人 SDK
define('RENREN_AKEY','3626a6bb44aa4c94833c6f5f7113608b');
define('RENREN_SKEY','f9c60c420b704c408b0c85813ea60a28');
define('RENREN_API','http://api.renren.com/restserver.do');
define('RENREN_AUTH_URL','https://graph.renren.com/oauth/authorize');
define('RENREN_ACC_URL','https://graph.renren.com/oauth/token');
define('RENREN_SSKEY_URL','https://graph.renren.com/renren_api/session_key');
define('RENREN_CB_URL','http://gene.shiyiquan.cn/login.php?s=renren');
*/

session_name(SESSUSER);
session_start();

if($_GET['s']=='renren') {
	if(!isset($_GET['code']) && $_SESSION['renren_state']==1) $_SESSION['renren_state'] = 0;
	$oauth = new RenRenOauth();
	$client = new RenRenClient();	
	try {
		if(!isset($_GET['code']) && !$_SESSION['renren_state']) {
			$_SESSION['renren_state'] = 1;
			header('Location: ' . $oauth->getAuthorizeUrl());
			exit;
		} elseif($_SESSION['renren_state']==1) {
			$token = $oauth->getAccessToken($_GET['code']);
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
		if($u = user_openid_auth_exists('renren', $_SESSION['renren_uid'])){
			echo '你好，来自人人网的 '  . $_SESSION['renren_name'] . '（也就是您）已经绑定过本网站的帐户，在本网站的 id 是' . $u['user_id'] . '，欢迎回来！';
			// 转入登陆后页面
		}else{
			user_openid_auth(user_create($_SESSION['renren_name']), 'renren', $_SESSION['renren_uid'], $_SESSION['renren_token'], $_SESSION['renren_secret']);
			echo '你好'. $_SESSION['renren_name'] . '，欢迎来到活字网，你已经用人人账号初次登陆成功。';
			// 转入登陆后页面
		}

	} catch(OAuthException $E) {
		echo '<p>An error occurred, please come back later.<p>';
		print_r($E);
	}
}elseif($_GET['s']=='sina_weibo'){
	if(!isset($_GET['oauth_token']) && $_SESSION['sinawb_state']==1) $_SESSION['sinawb_state'] = 0;
	try {
		$oauth = new OAuth(SINAWB_AKEY, SINAWB_SKEY);
		$oauth->enableDebug();
		if(!isset($_GET['oauth_token']) && !$_SESSION['sinawb_state']) {
			$request_token = $oauth->getRequestToken(SINAWB_REQ_URL);
			$_SESSION['sinawb_secret'] = $request_token['oauth_token_secret'];
			$_SESSION['sinawb_state'] = 1;
			header('Location: ' . SINAWB_AUTH_URL . '?oauth_token=' . $request_token['oauth_token'] . '&oauth_callback=' . rawurlencode(SINAWB_CB_URL) . '&display=page');
			exit;
		} elseif($_SESSION['sinawb_state']==1) {
			$oauth->setToken($_GET['oauth_token'],$_SESSION['sinawb_secret']);
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
		if($u = user_openid_auth_exists('sina_weibo', $_SESSION['sinawb_uid'])){
			echo '你好，新浪微博上的 '  . $_SESSION['sinawb_name'] . ' 用户（也就是您）已经绑定过本网站的帐户，在本网站的 id 是' . $u['user_id'] . '，欢迎回来！';
			// 转入登陆后页面
		}else{
			user_openid_auth(user_create($_SESSION['sinawb_name']), 'sina_weibo', $_SESSION['sinawb_uid'], $_SESSION['sinawb_token'], $_SESSION['sinawb_secret']);
			echo '你好'. $_SESSION['sinawb_name'] . '，欢迎来到活字网，你已经用新浪微博初次登陆成功。';
			// 转入登陆后页面
		}

	} catch(OAuthException $E) {
		echo '<a href="login.php?s=sina_weibo">An error occurred, please retry.<a>';
		print_r($E);
	
	}
}elseif($_POST['s']=='basic'){
	echo $_POST['username'],$_POST['passwd'];
}else{
	$_SESSION['sinawb_state'] = 0;
	$_SESSION['sinawb_token'] = 0;
	$_SESSION['sinawb_secret'] = 0;
	$_SESSION['sinawb_uid'] = 0;	
	$_SESSION['sinawb_name'] = 0;	
	$_SESSION['renren_state'] = 0;
	$_SESSION['renren_token'] = 0;
	$_SESSION['renren_secret'] = 0;
	$_SESSION['renren_uid'] = 0;	
	$_SESSION['renren_name'] = 0;
	/*
	$query ="select * from `users` where `id` = 13";
	$result = $db->query($query);
	if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	echo $row['screen_name'];
	}
	*/
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Register</title>
</head>

<body>
<h1>登陆－活字网</h1>
<form id="form1" name="form1" method="post" action="login.php">
	<input type="hidden" name="s" id="s" value="basic" />
  <label>
    <input type="text" name="username" id="username" />
    username</label>
  <br />
  <label>
    <input type="text" name="passwd" id="passwd" />
  passwd</label>
  <br />
  <label>
    <input type="submit" name="button" id="button" value="Submit" />
  </label>
</form>
</body>
</html>