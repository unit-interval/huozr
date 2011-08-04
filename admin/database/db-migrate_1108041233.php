<?php

include '../../config.php';
include '../../inc/database.php';

echo '<h1>Add table: "user"</h1>';

$table='user';
$tables = array(
	'user' => array(
		'col' => 'id mediumint unsigned not null auto_increment primary key,
			created timestamp not null default current_timestamp',
	),
);

$query = "create table `$table` ( {$tables[$table]['col']} )";
echo "query: $query <br />";

if($db->query($query) === TRUE)
echo 'table successfully created.<br />';
else
echo "error creating table: $db->error <br />";

?>