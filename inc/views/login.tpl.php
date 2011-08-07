<div id='login-oauth'> 
	<h4>用合作网站帐号登录</h4> 
	<ul> 
		<li><a href="oauth/sina_weibo" class='button-orange'>新浪微博</a></li>
		<li><a href="oauth/renren" class='button-orange'>人人网</a></li>
		<li><a href="oauth/tencent_weibo" class='button-orange'>腾讯微博</a></li>		
		<li><a href="oauth/douban" class='button-orange'>豆瓣</a></li>			
	</ul> 
</div> 
<div>
	<h4>用活字网账号登录</h4> 
	<form action='basic' method='post'>
		<div class='input-group'> 
			<input class='input-text' type='text' id='username' name='username' placeholder='用户名' autofocus='autofocus'/> 
			<label class='label-hint' for='username'>帐号或密码错误，请重试。</label> 
		</div> 
		<div class='input-group'> 
			<input class='input-text' type='password' id='passwd' name='passwd' placeholder='密码'/> 
			<label class='label-hint' for='passwd'>密码太短。</label> 
		</div> 
		<div class='input-group'> 
			<input id='public-login' name='public-login' type='checkbox'> 
			<label for="public-login">在公用电脑上登录</label> 
			<a href='forgot' id='forgot'>忘记密码？</a> 
		</div> 
		<div> 
			<button type='submit' class='button-blue'>登录</button> 
		</div> 
	</form> 
</div>
<div>
	<h4>注册活字账号</h4>
	<form id="form1" name="form1" method="post" action="signup">
		<label>
		<input type="text" name="username" id="username" />
		username</label>
		<br />
		<label>
		<input type="text" name="passwd" id="passwd" />
		passwd</label>
		<br />
		<label>
		<input type="text" name="screen_name" id="screen_name" />
		screen_name</label>
		<br />
		<label>
		<input type="submit" name="button" id="button" value="Submit" />
		</label>
	</form>
</div>
