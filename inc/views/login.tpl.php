				<div id='content'> 
					<form action='login' method='post'> 
						<h4>用户名或邮箱登录</h4> 
						<div class='input-group'> 
							<input class='input-text' type='text' id='email' name='email' placeholder='用户名或邮箱' autofocus='autofocus'/> 
							<label class='label-hint' for='email'>帐号或密码错误，请重试。</label> 
						</div> 
						<div class='input-group'> 
							<input class='input-text' type='password' id='password' name='email' placeholder='密码'/> 
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
					<div id='login-oauth'> 
						<h4>用合作网站帐号登录</h4> 
						<ul> 
							<li><a href='login/douban' id='douban-login' class='button-orange'>豆瓣</a></li> 
							<li><a href='login/renren' id='renren-login' class='button-orange'>人人</a></li> 
							<li><a href='login/weibo' id='weibo-login' class='button-orange'>新浪微博</a></li> 
						</ul> 
					</div> 
				</div> 
			</div> 
		</div> 

