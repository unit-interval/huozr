<?php

include_once DIR_INC . '/func-auth.php';

partner_logout();
header('Location: /partner/login/');			

