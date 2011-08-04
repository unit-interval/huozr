<?php

include '../config.php'

session_name('huozradmin');
session_start();

if ($_SESSION['admin'] != true) {
	if (isset($_POST['passwd'])) {
		if ($_POST['passwd'] == ADMIN_PW) {
			$_SESSION['admin'] = true;
			header('Location: ./');
			die;
		} else
			die("Hey, Look! We found a witch! May we burn her?");
	} else {
		echo "<form method='post'>
			<input type='password' name='passwd' />
			<input type='submit' value='login' />
			</form>";
		die;
	}
}









