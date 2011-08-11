<?php

include_once DIR_INC . '/func-auth.php';

/* if(partner_login_verify())
	redir_to('/partner/'); */

$yield_for['nav'] = 'partner_logged_in';
$yield_for['footer'] = 'partner';

$res['head_title'] = '设置';
$res['body_id'] = 'setting';