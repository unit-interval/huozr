<?php

include_once DIR_INC . '/func-auth.php';

if(partner_login($_POST['partner-email'],$_POST['passwd'],$_POST['remember-login'])){ 		
	//redirect back
	if(isset($_SESSION['callback_uri'])) {
		$uri = $_SESSION['callback_uri'];
		unset($_SESSION['callback_uri']);
		header("Location: $uri");
	}
	header('Location: /partner/');			
}else
	//err_fatal();
	//TODO notice partner
	header('Location: /partner/login/');