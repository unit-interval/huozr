<?php

if (! isset($start_including))
	return;

/** add/alter table */

echo 'Add table `orders`  ';

$query = "create table `orders` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`user_id` mediumint unsigned not null,
	`partner_id` mediumint unsigned not null,
	`status` TINYINT UNSIGNED NOT NULL ,
	`filename` varchar(64) not null,
	`filepath` varchar(128) null,
	`created` timestamp not null default current_timestamp,
	`closed` timestamp null,
	index (`user_id`),
	index (`partner_id`),
	index (`status`)
	)";

if ($db->rquery($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
elseif ($db->errno == 1050) {
	echo '... omitting, table exists.<br />';
	return;
} elseif ($db->errno == 1060) {
	echo '... omitting, column exists.<br />';
	return;
} else
	$db->raise_error($query);

/** insert seed data */

echo "Insert seed data  ";
$query = "insert into `orders` ( `user_id`, `partner_id`, `filename` ) values
	(1, 1, '1-1.pdf'), 
	(2, 1, '2-1.pdf')";

$db->query($query);
echo "... done<br /><em>$query</em><br />";

