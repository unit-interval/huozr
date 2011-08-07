<?php
include 'config.php';
include DIR_INC . '/bootstrap.php';
include DIR_INC . '/users_functions.php';



if($_GET['s']=='renren') { 
	if(!isset($_GET['code']) && $_SESSION['renren_state']==1) $_SESSION['renren_state'] = 0;
	$renren = renren_oauth($_GET['code']);
	if($u = user_openid_auth_exists('renren', $renren['remote_id'])){
		// 转入登录后页面
		user_login($u['user_id'], FALSE);
		header('Location: home');		
	}else{
		// 转入初次登录后页面
		user_login(user_openid_auth(user_create($renren['remote_screen_name']), 'renren', $renren['remote_id'], $renren['token'], $renren['secret']), FALSE);
		header('Location: home');		
	}




}elseif($_GET['s']=='sina_weibo'){
	if(!isset($_GET['oauth_token']) && $_SESSION['sinawb_state']==1) $_SESSION['sinawb_state'] = 0;
	$sinawb = sina_weibo_oauth($_GET['oauth_token']);
	if($u = user_openid_auth_exists('sina_weibo', $sinawb['remote_id'])){
		// 转入登录后页面
		user_login($u['user_id'], FALSE);
		header('Location: home');		
	}else{
		// 转入初次登录后页面
		user_login(user_openid_auth(user_create($sinawb['remote_screen_name']), 'sina_weibo', $sinawb['remote_id'], $sinawb['token'], $sinawb['secret']), FALSE);
		header('Location: home');		
	}




}elseif($_GET['s']=='tencent_weibo'){
	if(!isset($_GET['oauth_token']) && $_SESSION['qqwb_state']==1) $_SESSION['qqwb_state'] = 0;
	$qqwb = tencent_weibo_oauth($_GET['oauth_token']);
	if($u = user_openid_auth_exists('tencent_weibo', $qqwb['remote_id'])){
		// 转入登录后页面
		user_login($u['user_id'], FALSE);
		header('Location: home');		
	}else{
		// 转入初次登录后页面
		user_login(user_openid_auth(user_create($qqwb['remote_screen_name']), 'tencent_weibo', $qqwb['remote_id'], $qqwb['token'], $qqwb['secret']), FALSE);
		header('Location: home');
	}
	
	
	
	
}elseif($_GET['s']=='douban'){
	if(!isset($_GET['oauth_token']) && $_SESSION['douban_state']==1) $_SESSION['douban_state'] = 0;
	$douban = douban_oauth($_GET['oauth_token']);
	if(!$douban['remote_id']){
		header('Location: /login');
		die();
	}
	if($u = user_openid_auth_exists('douban', $douban['remote_id'])){
		//转入登录后页面
		user_login($u['user_id'], FALSE);
		header('Location: home');
	}else{
		//转入初次登录后页面
		user_login(user_openid_auth(user_create($douban['remote_screen_name']), 'douban', $douban['remote_id'], $douban['token'], $douban['secret']), FALSE);
		header('Location: home');	
	}
	
	
	
	
}elseif($_POST['s']=='basic'){
	if($u = user_exists($_POST['username'])){
		if(md5(SALT_PW . $_POST['passwd']) == $u['passwd']){ 
			user_login($u['user_id'], $_POST['public-login']);
			header('Location: home');			
		}
	}else{
		echo "登录不成功，请重试";
	}
	
	
}elseif($_POST['s']=='signup'){
	if ($_POST['username']!='')
		user_create_basic($_POST['username'], $_POST['passwd'], $_POST['screen_name']);





}else{ //登出
	/* debug
	$_SESSION['sinawb_state'] = 0;
	$_SESSION['renren_state'] = 0;
	$_SESSION['qqwb_state'] = 0;
	$_SESSION['douban_state'] = 0;	
	}
	*/
	user_logout();
	header('Location: login');			
}

?>
