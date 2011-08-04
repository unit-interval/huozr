<?php

include '../config.php';

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

if (isset($_GET['cmd'])) {
	if ($_GET['cmd'] == 'db_migrate') {
		// do the job
	} elseif ($_GET['cmd'] == 'db_reset') {
		if(! $development_env)
			echo "attention! you're trying to reset the database on a none-development site.";
		else {
		}
	}
}

echo "<p><hr />
	<a href='?cmd=db_migrate'>update database structure.</a><br />
	<a href='?cmd=db_reset'>reset database, drop all tables.</a><br />
	<br /></p>";

