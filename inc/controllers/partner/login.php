<?php

include_once DIR_INC . '/func-auth.php';

return;

if(partner_login_verify())
	redir_to('/partner/');

$res['head_title'] = '登录';
$res['body_id'] = 'login';

