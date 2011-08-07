<?php
include DIR_INC . '/users_functions.php';

if (user_login_verify()){
	$yield_for['nav'] = 'logged_in';
}
