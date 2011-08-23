<div id='login-here'>
	<div id='login-oauth'>
		<h4>已经拥有以下合作网站的帐号？无需注册，直接登录：</h4>
		<ul>
			<? foreach ($oauth_site as $key => $value) { ?>
			<li><a href='/login/oauth/<?= $key ?>' class='button-orange'><?= $value ?></a></li>
			<? } ?>
		</ul>
	</div>
	<div id='login-form'>
		<form action='/login/basic' method='post'>
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
				<input id='remember-login' name='remember-login' type='checkbox'>
				<label for="remember-login">保持登录状态</label>
				<a href='reset/' id='forgot'>忘记密码？</a>
			</div>
			<div>
				<button type='submit' class='button-blue'>登录</button>
			</div>
		</form>
	</div>
	<div id='signup'>
		<h4>如果你没有以上任何帐户，在此注册：</h4>
		<button type='button' class='button-blue'>立即注册</button>
	</div>
</div>
<div id='signup-here'>
	<h4>立即注册活字网：</h4>
	<form action='/login/signup' method='post'>
		<div class='input-group'>
			<input type='text' id='username' class='input-text' name='username' placeholder='用户名' />
			<label class='label-hint' for='username'>此用户名已注册过了</label>
		</div>
		<div class='input-group'>
			<input type='password' id='passwd' class='input-text' name='passwd' placeholder='设置密码' />
			<label class='label-hint' for='passwd'>密码长度至少需6位</label>
		</div>
		<div class='input-group'>
			<input type='password' id='passwd_repeat' class='input-text' name='passwd_repeat' placeholder='确认密码'/>
			<label class='label-hint' for='passwd_repeat'>两次输入的密码不一致</label>
		</div>
		<div class='input-group'>
			<input type='text' id='screen_name' class='input-text' name='screen_name' placeholder='昵称' />
			<label class='label-hint' for='screen_name'>必须设置昵称</label>
		</div>		
		<div>
			<button type='submit' class='button-blue'>立即注册</button>
		</div>
	</form>
</div>
