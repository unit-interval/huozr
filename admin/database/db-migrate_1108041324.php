<?php

include '../../config.php';
include '../../inc/database.php';

echo '<h1>Add table: "users_login"</h1>';

$table='users_login';
$tables = array(
	'users_login' => array(
		'col' =>	'`id` MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` MEDIUMINT NOT NULL ,
					`username` VARCHAR( 32 ) NOT NULL ,
					`passwd` CHAR( 32 ) NOT NULL,
					`updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					unique( `username` )',
	),
);

$query = "create table `$table` ( {$tables[$table]['col']} )";
echo "query: $query <br />";

if($db->query($query) === TRUE)
echo 'table successfully created.<br />';
else
echo "error creating table: $db->error <br />";

