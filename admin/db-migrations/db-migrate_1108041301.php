<?php

if (! isset($start_including))
	return;

echo 'Add table "oauth_links"  ';

$table='oauth_links';
$tables = array(
	'oauth_links' => array(
		'col' =>	'`id` MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` MEDIUMINT NOT NULL ,
					`service` VARCHAR( 32 ) NOT NULL ,
					`service_id` VARCHAR( 32 ) NOT NULL ,
					`token` VARCHAR( 64 ) NOT NULL ,
					`secret` VARCHAR( 64 ) NOT NULL ,
					`updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
	),
);

$query = "create table `$table` ( {$tables[$table]['col']} )";
echo "query: $query <br />";

if($db->query($query) === TRUE)
echo 'table successfully created.<br />';
else
echo "error creating table: $db->error <br />";

