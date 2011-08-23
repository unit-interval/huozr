<?php

js_script_tags('user');

if ($_SESSION['user_id']){
	$yield_for['nav'] = 'logged_in';
}

