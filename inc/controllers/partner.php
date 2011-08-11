<?php
//do_filter('access_control_partner');

css_link_tags('partner');
js_script_tags('partner');

$yield_for['nav'] = 'logged_in';
$yield_for['footer'] = 'logged_in';

$res['body_id'] = 'home';

