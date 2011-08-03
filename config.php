<?php

/** force utf8 */
setlocale(LC_ALL, 'en_US.utf8');

/** PATH */
define('DIR_ROOT', dirname(__FILE__));
define('DIR_INC', DIR_ROOT . '/inc');

/** cookie session */
define('SESSUSER', 'huozruser');
define('SESSPROV', 'huozrprov');

/** local settings */
include DIR_INC . '/config.local.php';

