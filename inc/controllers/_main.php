<?php

include DIR_INC . '/func-pages.php';
include DIR_INC . '/filters.php';

/** set site-wise defaults */
include path_ctrl('_defaults', 3);

if ($req_path[0] === '')
	$req_path[0] = 'index';

/**
 * map requests to their controllers
 * a physical file must exist for the first level
 */
while (req_path()) {
	$path = path_ctrl($req_path_cur);
	if (file_exists($path)) {
		unset($path);
		do_filter('access control');
		include path_ctrl($req_path_cur, 1);
	} elseif (! accepts('-', $path)) {
		include path_ctrl('404', 4);
		break;
	}
}

/** turn on output buffering */
ob_start();

/** the main layout  */
include path_view('__main');

