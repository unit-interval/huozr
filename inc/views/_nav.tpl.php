<?
switch($yielding_for) {
case 'logged_in':
?>
	<ul id='nav'> 
		<li> 
			<a href='index'>首页</a> 
		</li> 	
		<li> 
			<a href='home'>开始</a> 
		</li> 
		<li> 
			<a href='setting'>设置</a> 
		</li> 
		<li> 
			<a href='oauth?s=logout' class='nav'>退出</a> 
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
			<a href='index'>首页</a> 
		</li> 	
		<li> 
			<a href='/login' class='nav'>登录/注册</a> 
		</li> 
	</ul> 
<?
}
?>
