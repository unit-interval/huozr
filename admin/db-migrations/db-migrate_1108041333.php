<?php

if (! isset($start_including))
	return;

echo 'Add table `user_emails`  ';

$query = "create table `user_emails` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`user_id` MEDIUMINT NOT NULL ,
	`email` VARCHAR( 64 ) NOT NULL ,
	`activated` bool not null default 0,
	`primary` bool not null default 1,
	`created` timestamp not null default current_timestamp,
	unique `user_email` (`user_id`, `email`) )";

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

echo "Add pseudo email addresses for reserved users  ";
$query = "insert into `user_emails` ( `user_id`, `email` ) values
	( 1, 'user1@huozr.com' ), 
	( 2, 'user2@huozr.com' ), 
	( 3, 'user3@huozr.com' ), 
	( 4, 'user4@huozr.com' ), 
	( 5, 'user5@huozr.com' ), 
	( 6, 'user6@huozr.com' ), 
	( 7, 'user7@huozr.com' ), 
	( 8, 'user8@huozr.com' ), 
	( 9, 'user9@huozr.com' ), 
	( 10, 'user0@huozr.com' )";

$db->query($query);
echo "... done<br /><em>$query</em><br />";


