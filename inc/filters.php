<?php

function do_filter($fil) {
	static $count = array();
	switch ($fil) {
	case 'access control':
		if (isset($count[$fil]))
			return;
		$count[$fil] = 1;
		$exclude = array(
			'/$',
			'/login(/|$)',
			'/signup(/|$)',			
			'/404$',
			'/oauth(/|$)'
		);

		$req = strtok($_SERVER['REQUEST_URI'], '?');
		foreach($exclude as $pattern) {
			$pattern = "#^$pattern#";
			if (preg_match($pattern, $req))
				return;
		}
		if (! $_SESSION['u_id']) {
			$_SESSION['callback_uri'] = $_SERVER['REQUEST_URI'];
			header('Location: /login');
			die;
		}
		break;
	}
}
