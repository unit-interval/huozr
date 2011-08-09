<table>
	<tbody>
		<tr id='username'>
			<th>用户名</th>
			<td>
				<input type='text' class='input-text' value='libragold' />
				<button type='button' class='button-orange'>添加</button>
				<button type='submit' class='button-green'>锁定</button>
				<button type='button' class='button-blue'>修改密码</button>
				<button type='submit' class='button-green'>保存密码</button>
			</td>
		</tr>
		<tr id='set-password'>
			<th>设置密码</th>
			<td><input class='input-text' /></td>
		</tr>
		<tr id='confirm-password'>
			<th>确认密码</th>
			<td><input class='input-text' /></td>
		</tr>
		<tr id='nickname'>
			<th>昵称</th>
			<td>
				<input type='text' name='nickname' class='input-text' value='<?= $_SESSION['u_screen_name'] ?>' />
				<button type='button' class='button-blue'>修改</button>
				<button type='submit' class='button-green'>保存</button>
			</td>
		</tr>
		<tr id=''>
			<th>所在学校</th>
			<td>
				<div class='input-select'>
					<input type='text' name='school' class='input-text' value='北京大学' />
					<button type='button' class='button-blue'>修改</button>
					<button type='submit' class='button-green'>保存</button>
					<ul>
						<li>北京大学</li>
						<li>清华大学</li>
						<li>中国人民大学</li>
						<li>复旦大学</li>
						<li>上海交通大学</li>
					</ul>
				</div>
			</td>
		</tr>
		<tr>
			<th>真实姓名</th>
			<td>
				<input type='text' name='realname' class='input-text' value='姜子麟' />
				<button type='button' class='button-blue'>修改</button>
				<button type='submit' class='button-green'>保存</button>
			</td>
		</tr>
		<tr>
			<th>联系电话</th>
			<td>
				<input type='text' name='phone' class='input-text' value='13810461774' />
				<button type='button' class='button-blue'>修改</button>
				<button type='submit' class='button-green'>保存</button>
			</td>
		</tr>
		<tr>
			<th>常用邮箱</th>
			<td>
				<input type='text' name='phone' class='input-text' value='libragold@gmail.com' />
				<button type='button' class='button-blue'>修改</button>
				<button type='submit' class='button-green'>保存</button>
			</td>
		</tr>
		<tr>
			<th>教育邮箱</th>
			<td>
				<input type='text' name='phone' class='input-text' value='00701048@pku.edu.cn' />
				<button type='button' class='button-blue'>修改</button>
				<button type='submit' class='button-green'>保存</button>
			</td>
		</tr>
		<tr>
			<th>网络整合</th>
			<td>
				<div id='oauth'>
					<button class='button-gray'>豆瓣<span></span>未整合</button>
					<button class='button-gray'>人人<span></span>未整合</button>
					<button class='button-orange'>新浪微博<span></span>已整合</button>
				</div>
			</td>
		</tr>
	</tbody>
</table>