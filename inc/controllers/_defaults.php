<?php

/**
 * prepare array to hold all instance variables
 */
$res = array();

$res['head_title'] = '校园文印';
$res['body_id'] = 'index';

$yield_for = array();

/**
 * css/js files that are used on every page
 */
css_link_tags('style');
js_script_tags('jquery');
js_script_tags('huozr');