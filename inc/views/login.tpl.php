<div id='login-oauth'>
	<h4>已经拥有以下合作网站的帐号？无需注册，直接登录：</h4>
	<ul>
		<li><a href='login/douban' id='douban-login' class='button-orange'>豆瓣</a></li>
		<li><a href='login/renren' id='renren-login' class='button-orange'>人人</a></li>
		<li><a href='login/weibo' id='weibo-login' class='button-orange'>新浪微博</a></li>
	</ul>
</div>
<div id='login-form'>
	<form action='/login/basic/' method='post'>
		<h4>或者，通过活字网帐号登录：</h4>
		<div class='input-group'>
			<input class='input-text' type='text' id='username' name='username' placeholder='用户名' />
			<label class='label-hint' for='username'>帐号或密码错误，请重试。</label>
		</div>
		<div class='input-group'>
			<input class='input-text' type='password' id='passwd' name='passwd' placeholder='密码' />
			<label class='label-hint' for='passwd'>密码太短。</label>
		</div>
		<div class='input-group'>
			<input checked='checked' id='remember-login' name='remember-login' type='checkbox'>
			<label for="remember-login">保持登录状态</label>
			<a href='/forgot/' id='forgot'>忘记密码？</a>
		</div>
		<div>
			<button type='submit' class='button-blue'>登录</button>
		</div>
	</form>
</div>
<div id='signup'>
	<h4>如果你没有以上任何帐户，在此注册：</h4>
	<a href='/signup/' class='button-blue'>立即注册</a>
</div>