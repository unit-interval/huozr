<?php

if (! isset($start_including))
	return;

echo 'Add table `users`  ';

$query = "create table `users` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`last_visited` timestamp not null default 0,
	`created` timestamp not null default current_timestamp )";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
elseif ($db->errno == 1050) {
	echo '... omitting, table exists.<br />';
	return;
} else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}

echo "Add 10 reserved users  ";
$query = "insert into `users` ( `id` ) values
	(default), 
	(default), 
	(default), 
	(default), 
	(default), 
	(default), 
	(default), 
	(default), 
	(default), 
	(default)";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}

