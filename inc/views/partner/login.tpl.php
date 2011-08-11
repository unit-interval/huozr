<div id='login-here'>
	<div id='login-form'>
		<form action='login' method='post'>
			<h4>活字打印店登录：</h4>
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
		<h4>想成为活字打印店？在此申请：</h4>
		<button type='button' class='button-blue'>立即申请</button>
	</div>
</div>
<div id='signup-here'>
	<h4>填写真实信息，立即试用：</h4>
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
			<input type='password' id='password2' class='input-text' name='email' placeholder='确认密码'/>
			<label class='label-hint' for='password2'>两次输入的密码不一致</label>
		</div>
		<div class='input-group'>
			<input type='password' id='realname' class='input-text' name='realname' placeholder='打印店名'/>
			<label class='label-hint' for='realname'>两次输入的密码不一致</label>
		</div>
		<div class='input-group'>
			<div class='input-select' id='school-select'>
				<input type='text' name='school' placeholder='所在学校' />
				<label class='label-hint' for='phone'>fdfs</label>
				<ul>
					<li>北京大学</li>
					<li>清华大学</li>
					<li>中国人民大学</li>
					<li>复旦大学</li>
					<li>上海交通大学</li>
				</ul>
			</div>
		</div>
		<div class='input-group'>
			<input type='text' id='phone' class='input-text' name='phone' placeholder='联系电话' />
			<label class='label-hint' for='phone'>fdfs</label>
		</div>
		<div>
			<button type='submit' class='button-blue'>立即试用</button>
		</div>
	</form>
</div>