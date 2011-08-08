<?php

include_once DIR_INC . '/func-user.php';
include_once DIR_INC . '/func-oauth.php';


accepts('douban', 'renren', 'sina_weibo', 'tencent_weibo');

/** renren doesn't use oauth standards */

if(isset($_GET['code']))
	$_GET['oauth_token'] = $_GET['code'];

if(!isset($_GET['oauth_token']) && $_SESSION['state']==1)
	$_SESSION['state'] = 0;

$service = $req_path[0];

/** use variable function name to "_oauth" different services */
$function_handle = $service . '_oauth';
$oauth = $function_handle($_GET['oauth_token']);

/** actually douban is the only one who returns to callback when the auth fails */
if (! $oauth['remote_id']) {
	header('Location: /login/');
	//TODO: notice user
	die();
}

if($user = user_openid_auth_exists($service, $oauth['remote_id'])){
	//转入登录后页面
	user_login($user['user_id'], FALSE);
	// TODO write a function for code block below
	if(isset($_SESSION['callback_uri'])) {
		$uri = $_SESSION['callback_uri'];
		unset($_SESSION['callback_uri']);
		header("Location: $uri");
	}
	header('Location: /home');	
}else{
	//转入初次登录后页面
	user_login(user_openid_auth(user_create($oauth['remote_screen_name']), $service, $oauth['remote_id'], $oauth['token'], $oauth['secret']), FALSE);
	//TODO update the target location
	header('Location: /home');	
}

