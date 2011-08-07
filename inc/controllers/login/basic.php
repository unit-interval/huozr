<?php

include_once DIR_INC . '/func-user.php';

if($user = user_exists($_POST['username'])){
	if(md5(SALT_PW . $_POST['passwd']) == $u['passwd']){ 
		user_login($user['user_id'], $_POST['public-login']);
		//TODO redirect back
		header('Location: /home');			
	}
	header('Location: /login');			
}else{
	// notice user
		header('Location: /login');			
}

