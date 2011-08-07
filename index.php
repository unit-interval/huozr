<?php

include './config.php';
include DIR_INC . '/bootstrap.php';



/** map request to its controller */
switch ($req_path[0]) {
	// transitional or raw pages
	case 'do':
		break;
	// ajax
	case 'xhr':
		break;
	// ordinary pages
	default:
		include path_ctrl('_main', 3);
}
