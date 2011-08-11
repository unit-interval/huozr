<?php

/**
 * extend the builtin mysqli class
 * add error handling
 * redirect user to error page if database error occurs
 * since db error as considered fatal
 */
class mysqli_ext extends mysqli {
	/**
	 * connect and set utf8 as default charset
	 */
	public function __construct() {
		parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($this->connect_error)
			err_fatal("mysql connect error: ({$this->connect_errno})$this->connect_error.");
		if (!$this->set_charset("utf8"))
			err_fatal("mysql error: ({$this->errno})$this->error.");
	}
	/** preserve the original query method */
	public function rquery($query) {
		return parent::query($query);
	}
	/** exit on error for common queries */
	public function query($query) {
		if(!($result = parent::query($query)))
			err_fatal("mysql error: ({$this->errno})$this->error. the query string was: \"$query\"");
		return $result;
	}
	/** raise error */
	public function raise_error($query = '') {
		err_fatal("mysql error: ({$this->errno})$this->error. the query string was: \"$query\"");
	}
}


/** prepare the global variable $db for database queries */
$db = new mysqli_ext();

