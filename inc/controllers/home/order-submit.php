<?php

/** this file will be rewritten to output json for ajax calls */

include_once(DIR_INC . '/func-order.php');

//TODO log error
if(! ($param = order_form_sanitize()))
	redir_to('/home/');

//prepare other fields
$param['user_id'] = $_SESSION['user_id'];
$param['filename'] = '123.pdf';

order_create($param);

redir_to('/home/');

