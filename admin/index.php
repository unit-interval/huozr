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
	if ($_GET['cmd'] == 'db_show_tables') {
		$tables = array();
		$html = '<table><tr><td>table</td><td>field</td><td>type</td><td>null</td>
			<td>key</td><td>default</td><td>extra</td></tr>';

		$query = "show tables";
		$result = $db->query($query);
		while($row = $result->fetch_row())
			$tables[] = $row[0];
		$result->free();
		foreach($tables as $t) {
			$cols = array();
			$html .= "<tr><td>$t</td></tr>";

			$query = "describe `$t`";
			$result = $db->query($query);
			while($row = $result->fetch_row())
				$html .= "<tr><td></td><td>{$row[0]}</td><td>{$row[1]}</td><td>{$row[2]}</td>
				<td>{$row[3]}</td><td>{$row[4]}</td><td>{$row[5]}</td></tr>";
		}
		echo $html . "</table>";
	} elseif ($_GET['cmd'] == 'db_migrate') {
		foreach(glob('./db-migrations/db-migrate*.php') as $fn)
			include $fn;
	} elseif ($_GET['cmd'] == 'db_reset') {
		if(! DEV_ENV)
			echo "attention! you're trying to reset the database on a none-development site.";
		else {
			$query = "drop database if exists " . DB_NAME;
			$db->query($query);
			echo "database dropped. <br />";
			$query = "create database " . DB_NAME . 
				" character set utf8 collate utf8_general_ci";
			$db->query($query);
			echo "database created. <br />";
		}
	}
}

echo "<p><hr />
	<a href='?cmd=db_show_tables'>show current table structures.</a><br />
	<a href='?cmd=db_migrate'>update database structure.</a><br />
	<a href='?cmd=db_reset'>reset database, drop all tables.</a><br />
	<br /></p>";

