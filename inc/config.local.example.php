<?php

/** instance dependent values */
define('DB_HOST', 'localhost');
define('DB_USER', 'dbuser');
define('DB_PASS', 'dbpass');
define('DB_NAME', 'dbname');

define('ADMIN_PW', 'adminpasswd');

define('SALT_PW', 'Cataclysm');

/** runtime variables */
/** error output */
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
/** set to true to enable database reset */
$development_env = false;

//$debug_mode = true;
