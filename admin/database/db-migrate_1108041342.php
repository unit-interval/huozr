<?php

include '../../config.php';
include '../../inc/database.php';

echo '<h1>Add column "screen_name" into tables: "users"</h1>';

$query = "ALTER TABLE  `users` ADD  `screen_name` VARCHAR( 32 ) NOT NULL AFTER  `id`";

echo "query: $query <br />";
if($db->query($query) === TRUE)
	echo 'column successfully added.<br />';
else
	die("error modifying table: $db->error <br />");
