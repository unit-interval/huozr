<?php

include_once DIR_INC . '/func-user.php';

if($user = user_exists($_POST['username'])){
	if(md5(SALT_PW . $_POST['passwd']) == $user['passwd']){ 
		user_login($user['user_id'], $_POST['public-login']);		
		//TODO redirect back
		if(isset($_SESSION['callback_uri'])) {
			$uri = $_SESSION['callback_uri'];
			unset($_SESSION['callback_uri']);
			header("Location: $uri");
		}
		header('Location: /home');			
	}else
		header('Location: /login');			
}else{
	// notice user
		header('Location: /login');			
}

