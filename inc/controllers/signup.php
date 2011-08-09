<?php

include_once DIR_INC . '/func-user.php';

//TODO move logic to a 'raw' page
if ($_POST['username']!='') {
	user_create_basic($_POST['username'], $_POST['passwd'], $_POST['screen_name']);
	//TODO 刚刚注册完的页面
	header('Location: /home');
}

$res['head_title'] = '注册';
$res['body_id'] = 'login';

