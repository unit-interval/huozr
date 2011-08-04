<?php

/**
 * users' registeration, login related functions 
 */
function register_from_form($username, $passwd, $screen_name) {
	echo "$username <br />$passwd <br />$screen_name <br />";
	if(user_exists($username))
			err_redir("用户名($username)已注册，请直接登录");
	echo "建立user<br />";
	echo "建立userlogin<br />";
	echo "转到已经登陆<br />";
}

function user_exists($n) {
	global $db;
	$query = "select * from `users_login`
		where `username` = '{$db->real_escape_string($n)}'";
	if(!($result = $db->query($query)))
		err_redir("db error({$db->errno}). query:$query", '/error.php');
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row;
	}
	return false;
}

