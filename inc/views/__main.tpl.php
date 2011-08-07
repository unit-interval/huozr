<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh" xml:lang="zh">
<head>
	<meta name="description" content="printing as a service" />
	<meta name="keywords" content="print" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="zh-CN" />
	<title>活字 - 校园打印</title>
	<?= css_link_tags() ?>

	<?= js_script_tags() ?>

</head>
<body id='index'>
	<div id='wrapper'>
		<div id="gradient"> </div>
		<div id='container'>
			<div id='header'>
				<a href='/'><img src='/media/img/logo.png' alt='Photoncopy' id='logo'/></a>
				<? yield('nav'); ?>
			</div>
			<div id='content'>
				<? yield(); ?>
			</div>
		</div>
	</div>
	<div id='footer'>
		<div id="footer-content">
			<p>©2011 活字网 版权所有</p>
		</div>
	</div>
</body>
</html>
