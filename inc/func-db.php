<?php

function find_by_id($table, $id) {
	global $db;
	$stmt = $db->prepare("select `id` from `$table` where `id` = ?");
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->store_result();
	$retval = ($stmt->num_rows === 0 ? false : true);
	$stmt->close();
	return $retval;
}
