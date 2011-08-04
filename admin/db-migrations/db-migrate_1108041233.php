<?php

if (! isset($start_including))
	return;

echo 'Add table "users"  ';

$query = "create table `users` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`created` timestamp not null default current_timestamp )";

if ($db->query($query) === TRUE)
	echo '... done<br /><em>$query</em><br />';
elseif ($db->errno == 1050) {
	echo '... omitting, table exists.<br />';
	return;
} else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}




