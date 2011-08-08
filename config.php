<?php

/** force utf8 */
setlocale(LC_ALL, 'en_US.utf8');
/** timezone */
date_default_timezone_set('Asia/Hong_Kong');

/** PATH */
define('DIR_ROOT', dirname(__FILE__));
define('DIR_INC', DIR_ROOT . '/inc');
define('DIR_MEDIA', DIR_ROOT . '/media');
define('DIR_VIEW', DIR_INC . '/views');
define('DIR_CTRL', DIR_INC . '/controllers');

/** cookie session name */
define('SESSNAME', 'huozrsess');

/** make inc files not accessible directly */
$start_including = true;

/** local settings */
include DIR_INC . '/local.config.php';
if ($local_config_ver != '08081752')
	die('local.config.php was updated / not found.');
unset($local_config_ver);
include DIR_INC . '/local.keys.php';

