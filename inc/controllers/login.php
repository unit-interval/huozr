<?php

include_once DIR_INC . '/func-auth.php';

/** redirect logged in users to /home/ */
if($_SESSION['user_id'])
	redir_to('/home/');

js_script_tags('user');

$res['head_title'] = '登录';
$res['body_id'] = 'login';
$res['oauth_site'] = array('douban' => '豆瓣', 'renren' => '人人', 'sina_weibo' => '新浪微博', 'tencent_weibo' => '腾讯微博');

