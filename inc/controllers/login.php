<?php
include_once DIR_INC . '/func-user.php';

if(user_login_verify()){
	header('Location: /home');	
	die();
}
