<?php

include './config.php';
include DIR_INC . '/bootstrap.php';



/** map request to its controller */
switch ($req_path[0]) {
	// ajax
	case 'xhr':
		break;
	// ordinary pages
	default:
		include path_ctrl('_main', 3);
}
