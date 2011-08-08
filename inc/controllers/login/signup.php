<?php

include_once DIR_INC . '/func-user.php';

if ($_POST['username']!='') {
	user_create_basic($_POST['username'], $_POST['passwd'], $_POST['screen_name']);
	//TODO 刚刚注册完的页面
	header('Location: /home');
}
