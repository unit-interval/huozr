<?php

if (! isset($start_including))
	return;

echo 'Add table `user_oauth_links`  ';

$query = "create table `user_oauth_links` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`user_id` MEDIUMINT NOT NULL ,
	`service` VARCHAR( 32 ) NOT NULL ,
	`remote_id` VARCHAR( 32 ) NOT NULL ,
	`token` VARCHAR( 256 ) NOT NULL ,
	`secret` VARCHAR( 256 ) NOT NULL ,
	`updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	index (`user_id`), 
	unique `service_remote_id` (`service`, `remote_id`) )";

if ($db->rquery($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
elseif ($db->errno == 1050) {
	echo '... omitting, table exists.<br />';
	return;
} elseif ($db->errno == 1060) {
	echo '... omitting, column exists.<br />';
	return;
} else
	$db->raise_error();
