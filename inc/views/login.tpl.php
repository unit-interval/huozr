				<div id='content'> 
					<form action='oauth' method='post'>	<input type="hidden" name="s" id="s" value="basic" /> 
						<h4>用活字网账号登录</h4> 
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
					<div id='login-oauth'> 
						<h4>用合作网站帐号登录</h4> 
						<ul> 
							<li><a href="oauth?s=sina_weibo" class='button-orange'>新浪微博</a></li>
							<li><a href="oauth?s=renren" class='button-orange'>人人网</a></li>
							<li><a href="oauth?s=tencent_weibo" class='button-orange'>腾讯微博</a></li>		
							<li><a href="oauth?s=douban" class='button-orange'>豆瓣</a></li>			
						</ul> 
					</div> 
				</div> 
			</div> 
		</div> 

