<?php

include './config.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error)
err_redir("mysql connect error({$db->connect_errno}).",'/error.php');
if (!$db->set_charset("utf8"))
err_redir("db error({$db->errno}).", '/error.php');

if(isset($_POST['email']) && strlen($_POST['email']) > 5) {
	$email = strtolower($_POST['email']);
	$region = ($_POST['region'] . "x" == "x") ? "-" : $_POST['region'];
	$query = "insert ignore into `beta-requests` (`email`, `region`) values (
		'{$db->real_escape_string($email)}',
		'{$db->real_escape_string($region)}')";
	if($db->query($query) == true) {
		header('Location: /');
		die;
	}
}

?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html xmlns='http://www.w3.org/1999/xhtml' dir='ltr' lang='zh' xml:lang='zh'> 
	<head> 
		<meta name='keywords' content='print' /> 
		<meta http-equiv='content-type' content='text/html; charset=UTF-8' /> 
		<meta http-equiv='content-language' content='zh-CN' /> 
		<title>活字网 | 邀请函</title> 
		<link rel='stylesheet' type='text/css' href='/media/css/welcome.css' />  
	</head>
	<body id='invitation'>
		<div id='wrapper'>
			<div id='gradient'> </div>
			<div id='container'>
				<div id='header'>
					<a href='welcome.php'>
						<img src='/media/img/logo.png' alt='活字网' id='logo'/>
						<span>活字网 huozr.com<br />即将开放</span>
					</a>
					<ul id='nav'>
						<li class='active'>
							<a href='invitation.php' class='nav'>获取你的邀请函</a>
						</li>
						<li>
							<a href='contact.php' class='nav'>联络我们</a>
						</li>
					</ul>
				</div>
				<div id='content'>
					<form action='invitation.php' method='post'>
						<div>
							<h3>请留下邮箱以便我们及时通知你</h3>
							<input type='text' id='email' name='email' autofocus='autofocus'/>
						</div>
						<div>
							<h3>如果可以请告知我们你来自哪个学校</h3>
							<input type='text' id='region' name='region' />
						</div>
						<div>
							<button type='submit' class='submit-button'>我要邀请函</button>
						</div>
						<div>
							<label for='email'>网站正式开通后我们将在第一时间通知您，提交表单后将自动跳转至首页。</label>
						</div>
					</form>
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
