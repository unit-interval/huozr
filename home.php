<?php

include_once './config.php';
include DIR_INC . '/func-pages.php';

$css_tags = array('style');
$js_tags = array('jquery','huozr');

include DIR_VIEW . '/head.tpl.php';
include DIR_VIEW . '/nav.tpl.php';
include DIR_VIEW . '/home.tpl.php';
include DIR_VIEW . '/footer.tpl.php';
