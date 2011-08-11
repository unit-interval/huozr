<?php

include_once DIR_INC . '/func-auth.php';

if(partner_login_verify()){
	header('Location: /partner/home');	
	die();
}

$res['head_title'] = '打印店';
$res['body_id'] = 'index';

js_script_tags('p-huozr');