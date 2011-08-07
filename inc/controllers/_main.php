<?php

include DIR_INC . '/func-pages.php';

/** set site-wise defaults */
include path_ctrl('_defaults', 3);

if ($req_path_cur === '')
	$req_path_cur = 'index';

/**
 * map first level requests
 * a physical file must exist
 */
$path = path_ctrl($req_path_cur);
if (! file_exists($path)) {
	unset $path;
	include path_ctrl('404', 4);
} else {
	unset $path;
	include path_ctrl($req_path_cur, 1);
	while (req_path()) {
		$path = path_ctrl($req_path_cur);
		if (file_exists($path)) {
			unset $path;
			include path_ctrl($req_path_cur, 1);
		} elseif (! accepts('-', $path)) {
			include path_ctrl('404', 4);
			break;
		}
	}
}

/** the main layout  */
include path_view('__main');

