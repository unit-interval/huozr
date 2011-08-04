<?php

if (! isset($start_including))
	return;

/** add/alter table */

echo 'Add/Alter table `BLAH`  ';

$query = "create table `BLAH` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`created` timestamp not null default current_timestamp,
	unique `BLAH` (`BLAH`, `BLAHl`) )";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
elseif ($db->errno == 1050) {
	echo '... omitting, table exists.<br />';
	return;
} elseif ($db->errno == 1060) {
	echo '... omitting, column exists.<br />';
	return;
} else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}

/** insert seed data */

echo "Insert seed data  ";
$query = "insert into `BLAH` ( `BLAH` ) values
	(default), 
	(default)";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}

/** update data */

echo "Set values for existing entries  ";
$query = "update `BLAH` 
	set `BLAH` = 'BLAH'";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}

