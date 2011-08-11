<?php

include_once DIR_INC . '/func-auth.php';
include_once DIR_INC . '/func-oauth.php';


accepts('douban', 'renren', 'sina_weibo', 'tencent_weibo');

$service = $req_path[0];


/** renren doesn't use oauth standards */

if(isset($_GET['code']))
	$_GET['oauth_token'] = $_GET['code'];

if(!isset($_GET['oauth_token']) && $_SESSION[$service.'_state']==1)
	$_SESSION[$service.'_state'] = 0;

/** use variable function name to "_oauth" different services */
$function_handle = $service . '_oauth';
// call respective oauth function, for instance douban_oauth()
if (! ($oauth = $function_handle($_GET['oauth_token']))) {
	// actually douban is the only one who returns the control to us upon failure
	err_warn("$service oauth fail.");
	// TODO notice user
	redir_to('/login/');
}

if($user = user_openid_auth_exists($service, $oauth['remote_id'])){
	//转入登录后页面
	user_login($user['user_id'], FALSE);
	// TODO write a function for code block below
	if(isset($_SESSION['callback_uri'])) {
		$uri = $_SESSION['callback_uri'];
		unset($_SESSION['callback_uri']);
		redir_to($uri);
	}
	redir_to('/home/');
}else{
	//转入初次登录后页面
	user_login(user_openid_auth(user_create($oauth['remote_screen_name']), $service, $oauth['remote_id'], $oauth['token'], $oauth['secret']), FALSE);
	//TODO update the target location
	redir_to('/home/');
}

