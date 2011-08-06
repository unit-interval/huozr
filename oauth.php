<?php
include 'config.php';
include DIR_INC . '/users_functions.php';

session_name(SESSUSER);
session_start();

if($_GET['s']=='renren') {
	if(!isset($_GET['code']) && $_SESSION['renren_state']==1) $_SESSION['renren_state'] = 0;
	renren_oauth($_GET['code']);
	if($u = user_openid_auth_exists('renren', $_SESSION['renren_uid'])){
		echo '你好，来自人人网的 '  . $_SESSION['renren_name'] . '（也就是您）已经绑定过本网站的帐户，在本网站的 id 是' . $u['user_id'] . '，欢迎回来！';
		// 转入登录后页面
		user_login($u['user_id'], FALSE);
		header('Location: oauth.php?s=home');		
	}else{
		echo '你好'. $_SESSION['renren_name'] . '，欢迎来到活字网，你已经用人人账号初次登录成功。';
		// 转入登录后页面
		user_login(user_openid_auth(user_create($_SESSION['renren_name']), 'renren', $_SESSION['renren_uid'], $_SESSION['renren_token'], $_SESSION['renren_secret']), FALSE);
		header('Location: oauth.php?s=home');		
	}
	
}elseif($_GET['s']=='sina_weibo'){
	if(!isset($_GET['oauth_token']) && $_SESSION['sinawb_state']==1) $_SESSION['sinawb_state'] = 0;
	sina_weibo_oauth($_GET['oauth_token']);
	if($u = user_openid_auth_exists('sina_weibo', $_SESSION['sinawb_uid'])){
		echo '你好，新浪微博上的 '  . $_SESSION['sinawb_name'] . ' 用户（也就是您）已经绑定过本网站的帐户，在本网站的 id 是' . $u['user_id'] . '，欢迎回来！';
		// 转入登录后页面
		user_login($u['user_id'], FALSE);
		header('Location: oauth.php?s=home');		
	}else{
		echo '你好'. $_SESSION['sinawb_name'] . '，欢迎来到活字网，你已经用新浪微博初次登录成功。';
		// 转入登录后页面
		user_login(user_openid_auth(user_create($_SESSION['sinawb_name']), 'sina_weibo', $_SESSION['sinawb_uid'], $_SESSION['sinawb_token'], $_SESSION['sinawb_secret']), FALSE);
		header('Location: oauth.php?s=home');		
	}
	
}elseif($_GET['s']=='tencent_weibo'){
	if(!isset($_GET['oauth_token']) && $_SESSION['qqwb_state']==1) $_SESSION['qqwb_state'] = 0;
	tencent_weibo_oauth($_GET['oauth_token']);
	if($u = user_openid_auth_exists('tencent_weibo', $_SESSION['qqwb_uid'])){
		echo '你好，腾讯微博上的 '  . $_SESSION['qqwb_name'] . ' 用户（也就是您）已经绑定过本网站的帐户，在本网站的 id 是' . $u['user_id'] . '，欢迎回来！';
		// 转入登录后页面
		user_login($u['user_id'], FALSE);
		header('Location: oauth.php?s=home');		
	}else{
		echo '你好'. $_SESSION['qqwb_name'] . '，欢迎来到活字网，你已经用腾讯微博初次登录成功。';
		// 转入登录后页面
		user_login(user_openid_auth(user_create($_SESSION['qqwb_name']), 'tencent_weibo', $_SESSION['qqwb_uid'], $_SESSION['qqwb_token'], $_SESSION['qqwb_secret']), FALSE);
		header('Location: oauth.php?s=home');
	}
}elseif($_GET['s']=='douban'){
	
	if(!isset($_GET['oauth_token']) && $_SESSION['douban_state']==1) $_SESSION['douban_state'] = 0;
	douban_oauth($_GET['oauth_token']);
	if($u = user_openid_auth_exists('douban', $_SESSION['douban_uid'])){
		echo '你好，豆瓣上的 '  . $_SESSION['douban_name'] . ' 用户（也就是您）已经绑定过本网站的帐户，在本网站的 id 是' . $u['user_id'] . '，欢迎回来！';
		//转入登录后页面
		user_login($u['user_id'], FALSE);
		header('Location: oauth.php?s=home');
	}else{
		echo '你好'. $_SESSION['douban_name'] . '，欢迎来到活字网，你已经用豆瓣账号初次登录成功。';
		//转入登录后页面
		user_login(user_openid_auth(user_create($_SESSION['douban_name']), 'douban', $_SESSION['douban_uid'], $_SESSION['douban_token'], $_SESSION['douban_secret']), FALSE);
		header('Location: oauth.php?s=home');	
	}
	
}elseif($_POST['s']=='basic'){
	if($u = user_exists($_POST['username'])){
		if(md5(SALT_PW . $_POST['passwd']) == $u['passwd']){ 
			user_login($u['user_id'], FALSE);
			header('Location: oauth.php?s=home');			
			//echo '登录成功，欢迎你，用户 id 为 ' . $u['user_id'] . ' 的用户！';

		}
	}else{
		echo "登录不成功，请重试";
	}
}elseif($_GET['s']=='home'){
	if ($_SESSION['logged_in'] == true){
		echo '欢迎你，你的 user_id 是'. $_COOKIE['uid'];
	}else{
		echo '抱歉，你还没有登录';
	}

}else{
	user_logout();
	/* debug
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
	$_SESSION['qqwb_state'] = 0;
	$_SESSION['qqwb_token'] = 0;
	$_SESSION['qqwb_secret'] = 0;
	$_SESSION['qqwb_uid'] = 0;	
	$_SESSION['qqwb_name'] = 0;	
	$_SESSION['douban_state'] = 0;	
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
<h1>登录－活字网</h1>
<form id="form1" name="form1" method="post" action="oauth.php">
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
<ul>
	<li><a href="oauth.php?s=sina_weibo">用新浪微博账号登录</a></li>
	<li><a href="oauth.php?s=renren">用人人网账号登录</a></li>
	<li><a href="oauth.php?s=tencent_weibo">用腾讯微博账号登录</a></li>		
	<li><a href="oauth.php?s=douban">用豆瓣账号登录</a></li>			
	<li><a href="oauth.php">用活字网账号登录</a>（<a href="signup.php">注册活字网账号</a>）</li>
</ul>
</body>
</html>