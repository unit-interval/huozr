<?php

include_once(DIR_INC . '/func-db.php');

/**
 * create order with $param
 * non-required parameters are inserted as ordermeta
 */
function order_create(array $param) {
	global $db;
	$stmt = $db->prepare('insert `orders` 
		(`user_id`, `partner_id`, `status`, `filename`) 
		values (?, ?, 0, ?)');
	$stmt->bind_param('iis', 
		$param['user_id'], $param['partner_id'], $param['filename']);
	$stmt->execute();
	$order_id = $stmt->insert_id;
	$stmt->close();

	unset($param['user_id'], $param['partner_id'], $param['filename']);
	$stmt = $db->prepare("insert `ordermeta` 
		(`order_id`, `meta_key`, `meta_value`)
		values ($order_id, ?, ?)");
	$stmt->bind_param('ss', $key, $value);
	foreach($param as $key => $value)
		$stmt->execute();
	$stmt->close();
}

/**
 * sanitize submitted form
 * return value
 * 	success: an array of ordermeta parameters
 * 	failure: false
 */
function order_form_sanitize() {
	if (count($_POST) < 2)
		return false;
	$o = array();
	
	$v = intval($_POST['partner_id']);
	if(! find_by_id('partners', $v))
		return false;
	$o['partner_id'] = $v;

	$v = intval($_POST['size']);
	if (! order_meta2text('size', $v))
		return false;
	$o['size'] = $v;

	return $o;
}

/**
 * map integer meta value to text
 * parameters
 * 	$meta: meta name to search
 * 	$key: integer option value to be translated
 * return value
 * 	if $meta/$key is invalid and not null, return false
 * 	if $meta is null, return the entire $map array
 *  if $key is null, return the $map array for $meta
 *  otherwise, return the text string for $meta[$key]
 */
function order_meta2text($meta = null, $key = null) {
	static $map = array(
		'size' => array(
			1 => 'A4',
			2 => 'B5',
		),
	);

	if ($meta === null)
		return $map;
	if (! array_key_exists($meta, $map))
		return false;
	if ($key === null)
		return $map[$meta];
	if (! array_key_exists($key, $map[$meta]))
		return false;
	return $map[$meta][$key];
}

