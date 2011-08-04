<?php

include '../config.php';
include '../inc/database.php';

session_name(SESSNAME);
session_start();

if(!isset($_GET['c'])) {
	foreach(glob('db-migrate*.php') as $fn)
		echo "<a href='$fn'>$fn</a><br />";
	echo '<hr /><br />';
} else {
//	resetTable($table);
}



?>