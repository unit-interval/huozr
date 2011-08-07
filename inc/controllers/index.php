<?php
include DIR_INC . '/users_functions.php';

session_name(SESSUSER);
session_start();

if (user_login_verify()){
	$yield_for['nav'] = 'logged_in';
}
