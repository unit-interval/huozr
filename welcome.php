<?php

include './config.php';

define('BASE_COUNT', 100);

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//if ($db->connect_error)
//err_redir("mysql connect error({$db->connect_errno}).",'/error.php');
//if (!$db->set_charset("utf8"))
//err_redir("db error({$db->errno}).", '/error.php');

$query = "select count(`id`) from `beta-requests`";
if($result = $db->query($query)) {
    $count = $result->fetch_row();
    $count = $count[0] + BASE_COUNT;
	$result->free();
}


?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html xmlns='http://www.w3.org/1999/xhtml' dir='ltr' lang='zh' xml:lang='zh'> 
	<head> 
		<meta name='keywords' content='print' /> 
		<meta http-equiv='content-type' content='text/html; charset=UTF-8' /> 
		<meta http-equiv='content-language' content='zh-CN' /> 
		<title>活字网 | 即将开放</title> 
		<link rel='stylesheet' type='text/css' href='/media/css/welcome.css' />  
	</head>
	<body id='welcome'>
		<div id='wrapper'>
			<div id='gradient'> </div>
			<div id='container'>
				<div id='header'>
					<a href='welcome.php'>
						<img src='/media/img/logo.png' alt='活字网' id='logo'/>
						<span>活字网 huozr.com<br />即将开放</span>
					</a>
					<ul id='nav'>
						<li>
							<a href='invitation.php' class='nav'>获取你的邀请函</a>
						</li>
						<li>
							<a href='contact.php' class='nav'>联系我们</a>
						</li>
					</ul>
				</div>
				<div id='content'>
					<h1>活字网</h1>
					<h2>让校园文印更便捷</h2>
					<h3>已有<?= $count ?>人索取邀请函</h3>
				</div>
			</div>
		</div> 
		<div id='footer'>
			<div id='footer-content'>
	        	<p>©2011 活字网 版权所有</p>
			</div>
		</div>
	</body>
</html>

