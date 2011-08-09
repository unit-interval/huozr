<?php

/**
 * prepare array to hold all instance variables
 */
$res = array();
$yield_for = array();

/**
 * css/js files that are used on every page
 */
css_link_tags('style');
js_script_tags('jquery', 'huozr');
js_script_tags();

/**
 * set value for basic info
 */
$res['head_title'] = '校园文印';
$res['body_id'] = 'index';
$res['oauth_site'] = array('douban' => '豆瓣', 'renren' => '人人', 'sina_weibo' => '新浪微博', 'tencent_weibo' => '腾讯微博');