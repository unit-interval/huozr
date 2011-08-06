<?
switch($yielding_for) {
case 'logged_in':
?>
	<ul id='nav'> 
		<li class='active'> 
			<a href='home'>开始</a> 
		</li> 
		<li> 
			<a href='setting'>设置</a> 
		</li> 
		<li> 
			<a href='index' class='nav'>退出</a> 
		</li> 
	</ul> 
<?
	break;
case 'partner':
?>
<?
	break;
default:
?>
	<ul id='nav'> 
		<li> 
			<a href='/login.php' class='nav'>登录</a> 
		</li> 
		<li> 
			<a href='signup' class='nav'>注册</a> 
		</li> 
	</ul> 
<?
}
?>
