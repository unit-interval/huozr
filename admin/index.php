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
		foreach(glob('./db-migrations/db-migrate*.php') as $fn)
			include $fn;
	} elseif ($_GET['cmd'] == 'db_reset') {
		if(! $development_env)
			echo "attention! you're trying to reset the database on a none-development site.";
		else {
			$query = "drop database if exists " . DB_NAME;
			if($db->query($query) === true)
				echo "database dropped. <br />";
			else
				die("error dropping database: $db->error <br />");
			$query = "create database " . DB_NAME . 
				" character set utf8 collate utf8_general_ci";
			if($db->query($query) === true)
				echo "database created. <br />";
			else
				die("error creating database: $db->error <br />");
		}
	}
}

echo "<p><hr />
	<a href='?cmd=db_migrate'>update database structure.</a><br />
	<a href='?cmd=db_reset'>reset database, drop all tables.</a><br />
	<br /></p>";

