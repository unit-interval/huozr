<?php

include_once DIR_INC . '/func-auth.php';

user_logout();
header('Location: /login/');			

