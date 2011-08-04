<?php

if (! isset($start_including))
	return;

echo 'Add column `screen_name` into table `users`  ';

$query = "ALTER TABLE  `users` 
	ADD  `screen_name` VARCHAR( 32 ) NOT NULL 
	AFTER  `id`";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
elseif ($db->errno == 1060) {
	echo '... omitting, column exists.<br />';
	return;
} else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}

echo "Set values for existing entries  ";
$query = "update `users` 
	set `screen_name` = 'Pseudo User'";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}

