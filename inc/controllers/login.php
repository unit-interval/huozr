<?php

include_once DIR_INC . '/func-user.php';

if(user_login_verify()){
	header('Location: /home');	
	die();
}

$res['head_title'] = '登录';
$res['body_id'] = 'login';

