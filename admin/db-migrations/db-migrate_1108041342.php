<?php

if (! isset($start_including))
	return;

echo 'Add column `screen_name` into table `users`  ';

$query = "ALTER TABLE  `users` 
	ADD  `screen_name` VARCHAR( 32 ) NOT NULL 
	AFTER  `id`";

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

echo "Set values for existing entries  ";
$query = "update `users` 
	set `screen_name` = 'Pseudo User'";

$db->query($query);
echo "... done<br /><em>$query</em><br />";
