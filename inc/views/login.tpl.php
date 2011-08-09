<div id='login-here'>
	<div id='login-oauth'>
		<h4>已经拥有以下合作网站的帐号？无需注册，直接登录：</h4>
		<ul>
			<? foreach ($oauth_site as $key => $value) { ?>
			<li><a href='login/<?= $key ?>' class='button-orange'><?= $value ?></a></li> <? } ?>
		</ul>
	</div>
	<div id='login-form'>
		<form action='login' method='post'>
			<h4>或者，通过活字网帐号登录：</h4>
			<div class='input-group'>
				<input class='input-text' type='text' id='email' name='email' placeholder='用户名' />
				<label class='label-hint' for='email'>帐号或密码错误，请重试。</label>
			</div>
			<div class='input-group'>
				<input class='input-text' type='password' id='password' name='email' placeholder='密码' />
				<label class='label-hint' for='password'>密码太短。</label>
			</div>
			<div class='input-group'>
				<input checked='checked' id='remember-login' name='remember-login' type='checkbox'>
				<label for="remember-login">保持登录状态</label>
				<a href='forgot' id='forgot'>忘记密码？</a>
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
	<form action='signup' method='post'>
		<div class='input-group'>
			<input type='text' id='user-name' class='input-text' name='user-name' placeholder='用户名' />
			<label class='label-hint' for='user-name'>此用户名已注册过了</label>
		</div>
		<div class='input-group'>
			<input type='password' id='password' class='input-text' name='email' placeholder='设置密码' />
			<label class='label-hint' for='password'>密码长度至少需6位</label>
		</div>
		<div class='input-group'>
			<input type='password' id='password' class='input-text' name='email' placeholder='确认密码'/>
			<label class='label-hint' for='password'>两次输入的密码不一致</label>
		</div>
		<div>
			<button type='submit' class='button-blue'>立即注册</button>
		</div>
	</form>
</div>