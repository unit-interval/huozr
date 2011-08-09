<?php

$res['head_title'] = '忘记密码';
$res['body_id'] = 'login';

include_once DIR_INC . '/func-auth.php';

if(user_login_verify()){
	header('Location: /home');	
	die();
}
