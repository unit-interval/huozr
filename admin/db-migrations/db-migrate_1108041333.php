<?php

if (! isset($start_including))
	return;

echo '<h1>Add table: "emails"</h1>';

$table='emails';
$tables = array(
	'emails' => array(
		'col' =>	'`id` MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` MEDIUMINT NOT NULL ,
					`email` VARCHAR( 64 ) NOT NULL ,
					`updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					unique( `email` )',
	),
);

$query = "create table `$table` ( {$tables[$table]['col']} )";
echo "query: $query <br />";

if($db->query($query) === TRUE)
echo 'table successfully created.<br />';
else
echo "error creating table: $db->error <br />";

