<?php

include_once DIR_INC . '/func-user.php';

user_logout();
header('Location: /login');			

