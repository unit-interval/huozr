<?php

/** force utf8 */
setlocale(LC_ALL, 'en_US.utf8');

/** PATH */
define('DIR_ROOT', dirname(__FILE__));
define('DIR_INC', DIR_ROOT . '/inc');

/** cookie session */
define('SESSUSER', 'huozruser');
define('SESSPROV', 'huozrprov');

/** make inc files not accessible directly */
$start_including = true;

/** local settings */
include DIR_INC . '/config.local.php';
if ($local_config_ver != '08051037')
	die('config.local.php has been updated.');

/** include necessary files */
include DIR_INC . '/functions.php';
include DIR_INC . '/database.php';	// i think most request contains db access.

