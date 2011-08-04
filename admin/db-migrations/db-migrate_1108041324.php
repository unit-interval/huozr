<?php

if (! isset($start_including))
	return;

echo 'Add table `user_basic_auth`  ';

$query = "create table `user_basic_auth` (
	`id` mediumint unsigned not null auto_increment primary key,
	`user_id` MEDIUMINT NOT NULL unique,
	`login_name` VARCHAR( 32 ) NOT NULL unique,
	`passwd` CHAR( 32 ) NOT NULL,
	`updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP )";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
elseif ($db->errno == 1050) {
	echo '... omitting, table exists.<br />';
	return;
} else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}

echo "Add login info for reserved users  ";
$query = "insert into `user_basic_auth` ( `user_id`, `login_name`, `passwd` ) values
	( 1, 'user1@huozr.com', '". md5(SALT_PW . 'user1') ."'), 
	( 2, 'user2@huozr.com', '". md5(SALT_PW . 'user2') ."'), 
	( 3, 'user3@huozr.com', '". md5(SALT_PW . 'user3') ."'), 
	( 4, 'user4@huozr.com', '". md5(SALT_PW . 'user4') ."'), 
	( 5, 'user5@huozr.com', '". md5(SALT_PW . 'user5') ."'), 
	( 6, 'user6@huozr.com', '". md5(SALT_PW . 'user6') ."'), 
	( 7, 'user7@huozr.com', '". md5(SALT_PW . 'user7') ."'), 
	( 8, 'user8@huozr.com', '". md5(SALT_PW . 'user8') ."'), 
	( 9, 'user9@huozr.com', '". md5(SALT_PW . 'user9') ."'), 
	( 10, 'user0@huozr.com', '". md5(SALT_PW . 'user0') ."')";

if ($db->query($query) === TRUE)
	echo "... done<br /><em>$query</em><br />";
else {
	echo "... <strong>error</strong>: ($db->errno)$db->error <br />";
	die($query);
}


