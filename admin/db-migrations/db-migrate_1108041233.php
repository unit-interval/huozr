<?php

if (! isset($start_including))
	return;

echo '<h1>Add table: "users"</h1>';

$table='users';
$tables = array(
	'users' => array(
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
