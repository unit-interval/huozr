<?php

/**
 * OAuth related functions
 */
//sina weibo API
define('SINAWB_API_BASE', 'http://api.t.sina.com.cn/');
define('SINAWB_REQ_URL' , SINAWB_API_BASE . 'oauth/request_token');
define('SINAWB_AUTH_URL' , SINAWB_API_BASE . 'oauth/authorize');
define('SINAWB_ACC_URL' , SINAWB_API_BASE . 'oauth/access_token');
define('SINAWB_CB_URL' , 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);

//tencent weibo API
define('QQWB_API_BASE', 'http://open.t.qq.com/api/');
define('QQWB_REQ_URL' , 'https://open.t.qq.com/cgi-bin/request_token');
define('QQWB_AUTH_URL' , 'https://open.t.qq.com/cgi-bin/authorize');
define('QQWB_ACC_URL' , 'https://open.t.qq.com/cgi-bin/access_token');
define('QQWB_CB_URL' , 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);

//douban API
define('DOUBAN_API_BASE', 'http://api.douban.com/');
define('DOUBAN_REQ_URL' , 'http://www.douban.com/service/auth/request_token');
define('DOUBAN_AUTH_URL' , 'http://www.douban.com/service/auth/authorize');
define('DOUBAN_ACC_URL' , 'http://www.douban.com/service/auth/access_token');
define('DOUBAN_CB_URL' , 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);

include(DIR_INC . '/sdk/connetion_renren.php');
/* 不用下列常量，转用人人 SDK
define('RENREN_API','http://api.renren.com/restserver.do');
define('RENREN_AUTH_URL','https://graph.renren.com/oauth/authorize');
define('RENREN_ACC_URL','https://graph.renren.com/oauth/token');
define('RENREN_SSKEY_URL','https://graph.renren.com/renren_api/session_key');
define('RENREN_CB_URL','');
*/

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
			unset ($_SESSION['douban_state']);
			unset ($_SESSION['douban_secret']);			
			return $douban;
		}
	} catch(OAuthException $E) {
		unset ($_SESSION['douban_state']);
		echo '<a href="/login/">豆瓣在和本网站连接时候出现错误，可能是临时问题，请点此返回，再重试。<a>';
		//echo '<a href="login.php?s=douban">An error occurred, please retry.<a>';
		//print_r($E);
	
	}
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
			unset ($_SESSION['renren_state']);
			return $renren;
		}


	} catch(OAuthException $E) {
		unset ($_SESSION['renren_state']);
		echo '<a href="/login/">人人网和本网站连接时候出现错误，可能是临时问题，请点此返回，再重试。<a>';
		//print_r($E);
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
			unset ($_SESSION['sinawb_state']);
			unset ($_SESSION['sinawb_secret']);
			return $sinawb;
		}

	} catch(OAuthException $E) {
		unset ($_SESSION['sinawb_state']);
		echo '<a href="/login/">新浪微博在和本网站连接时候出现错误，可能是临时问题，请点此返回，再重试。<a>';
		//print_r($E);
	
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
			unset ($_SESSION['qqwb_state']);
			unset ($_SESSION['qqwb_secret']);			
			return $qqwb;
		}
	} catch(OAuthException $E) {
		unset ($_SESSION['qqwb_state']	);
		echo '<a href="/login/">腾讯微博和本网站连接时候出现错误，可能是临时问题，请点此返回，再重试。<a>';
		//print_r($E);
	
	}
}

