<?php

include_once DIR_INC . '/func-auth.php';

if(partner_login_verify()){
	header('Location: /partner/home');	
	die();
}

$res['head_title'] = '登录';
$res['body_id'] = 'login';

js_script_tags('huozrPartner');
js_script_tags('');