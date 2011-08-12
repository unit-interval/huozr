<?php

if (! isset($start_including))
	return;

/** add/alter table */

echo 'Add table `ordermeta`  ';

$query = "create table `ordermeta` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`order_id` mediumint unsigned not null,
	`meta_key` varchar(64) not null,
	`meta_value` varchar(4096) null default null,
	unique `order_meta_key` (`order_id`, `meta_key`) )";

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

