<?php
do_filter('access_control_partner');

css_link_tags('partner');
js_script_tags('partner');

$yield_for['nav'] = 'partner_logged_in';
$yield_for['footer'] = 'partner';

$res['body_id'] = 'home';

