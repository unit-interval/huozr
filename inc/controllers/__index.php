<?php

if ($_SESSION['u_id']){
	$yield_for['nav'] = 'logged_in';
}

js_script_tags('user');
