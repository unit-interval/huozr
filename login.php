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
		// 转入登陆后页面
	}else{
		user_openid_auth(user_create($_SESSION['renren_name']), 'renren', $_SESSION['renren_uid'], $_SESSION['renren_token'], $_SESSION['renren_secret']);
		echo '你好'. $_SESSION['renren_name'] . '，欢迎来到活字网，你已经用人人账号初次登陆成功。';
		// 转入登陆后页面
	}
	
}elseif($_GET['s']=='sina_weibo'){
	if(!isset($_GET['oauth_token']) && $_SESSION['sinawb_state']==1) $_SESSION['sinawb_state'] = 0;
	sina_weibo_oauth($_GET['oauth_token']);
	if($u = user_openid_auth_exists('sina_weibo', $_SESSION['sinawb_uid'])){
		echo '你好，新浪微博上的 '  . $_SESSION['sinawb_name'] . ' 用户（也就是您）已经绑定过本网站的帐户，在本网站的 id 是' . $u['user_id'] . '，欢迎回来！';
		// 转入登陆后页面
	}else{
		user_openid_auth(user_create($_SESSION['sinawb_name']), 'sina_weibo', $_SESSION['sinawb_uid'], $_SESSION['sinawb_token'], $_SESSION['sinawb_secret']);
		echo '你好'. $_SESSION['sinawb_name'] . '，欢迎来到活字网，你已经用新浪微博初次登陆成功。';
		// 转入登陆后页面
	}
	
}elseif($_GET['s']=='tencent_weibo'){
	if(!isset($_GET['oauth_token']) && $_SESSION['qqwb_state']==1) $_SESSION['qqwb_state'] = 0;
	tencent_weibo_oauth($_GET['oauth_token']);
	if($u = user_openid_auth_exists('tencent_weibo', $_SESSION['qqwb_uid'])){
		echo '你好，腾讯微博上的 '  . $_SESSION['qqwb_name'] . ' 用户（也就是您）已经绑定过本网站的帐户，在本网站的 id 是' . $u['user_id'] . '，欢迎回来！';
		// 转入登陆后页面
	}else{
		//echo $_SESSION['qqwb_name'].'<br />'.$_SESSION['qqwb_uid'].'<br />'.$_SESSION['qqwb_token'].'<br />'.$_SESSION['qqwb_secret'];
		user_openid_auth(user_create($_SESSION['qqwb_name']), 'tencent_weibo', $_SESSION['qqwb_uid'], $_SESSION['qqwb_token'], $_SESSION['qqwb_secret']);
		echo '你好'. $_SESSION['qqwb_name'] . '，欢迎来到活字网，你已经用腾讯微博初次登陆成功。';
		// 转入登陆后页面
	}
}elseif($_POST['s']=='basic'){
	if($u = user_exists($_POST['username'])){
		if(md5(SALT_PW . $_POST['passwd']) == $u['passwd']){ 
			echo '登陆成功，欢迎你，用户 id 为 ' . $u['user_id'] . ' 的用户！';
		}
	}else{
		echo "登陆不成功，请重试";
	}
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
	$_SESSION['qqwb_state'] = 0;
	$_SESSION['qqwb_token'] = 0;
	$_SESSION['qqwb_secret'] = 0;
	$_SESSION['qqwb_uid'] = 0;	
	$_SESSION['qqwb_name'] = 0;	
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
<ul>
	<li><a href="login.php?s=sina_weibo">用新浪微博账号登陆</a></li>
	<li><a href="login.php?s=renren">用人人网账号登陆</a></li>
	<li><a href="login.php?s=tencent_weibo">用腾讯微博账号登陆</a></li>		
	<li><a href="login.php">用活字网账号登陆</a>（<a href="signup.php">注册活字网账号</a>）</li>
</ul>
</body>
</html>