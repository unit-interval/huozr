<?php

if (! isset($start_including))
	return;

echo 'Add table `partners`  ';

$query = "create table `partners` ( 
	`id` mediumint unsigned not null auto_increment primary key,
	`email` VARCHAR( 64 ) NOT NULL ,
	`passwd` CHAR( 32 ) NOT NULL ,
	`passphrase` CHAR( 32 ) NOT NULL ,
	`name` VARCHAR( 32 ) NOT NULL ,
	`addr` VARCHAR( 256 ) NOT NULL ,
	`memo` VARCHAR( 256 ) NOT NULL ,	
	`last_visited` timestamp not null default 0,
	`created` timestamp not null default current_timestamp ,
	UNIQUE (`email`) 
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
	$db->raise_error();

echo "Add pseudo email addresses for reserved users  ";
$query = "insert into `partners` ( `email`, `passwd` ,`passphrase` ,`name`,`addr`,`memo`) values
	( 'p1@huozr.com','". md5(SALT_PW . 'p223223') ."','223','内侧打印店甲','北京大学计算中心四层','这是内侧使用的虚拟打印店，不能用来打印。' ), 
	( 'p3015@huozr.com','". md5(SALT_PW . 'p3015') ."','015','内侧打印店乙','北京大学计算中心五层','这是内侧使用的虚拟打印店，不能用来打印。' ), 
	( 'p2@huozr.com','". md5(SALT_PW . 'p123123') ."','123','内侧打印店丙','北京大学计算中心六层','这是内侧使用的虚拟打印店，不能用来打印。' )";

$db->query($query);
echo "... done<br /><em>$query</em><br />";


