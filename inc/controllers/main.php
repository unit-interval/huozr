<?php

include DIR_INC . '/func-pages.php';

/** set site-wise defaults */
include path_ctrl('defaults');

/** first level */
if ($req_path_cur === '')
	$req_path_cur = 'index';
if (file_exists(path_ctrl($req_path_cur)))
	include path_ctrl($req_path_cur);
else
	include path_ctrl('404');

/** the main layout  */
include path_view('main');

