<?php

if (! isset($start_including))
	return;

/** add/alter table */

echo 'Add/Alter table `BLAH`  ';

$query = "create table `BLAH` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`created` timestamp not null default current_timestamp,
	unique `BLAH` (`BLAH`, `BLAHl`) )";

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

/** insert seed data */

echo "Insert seed data  ";
$query = "insert into `BLAH` ( `BLAH` ) values
	(default), 
	(default)";

$db->query($query);
echo "... done<br /><em>$query</em><br />";

/** update data */

echo "Set values for existing entries  ";
$query = "update `BLAH` 
	set `BLAH` = 'BLAH'";

$db->query($query);
echo "... done<br /><em>$query</em><br />";

