<ul id='menu'>
	<li id='flow-menu'>
		<h4>新建文印</h4>
		<ul id='flow' class='menu'>
			<li>选择打印店</li>
			<li>选择服务</li>
			<li>上传文件</li>
			<li>提交文印要求</li>
		</ul>
	</li>
	<li id='history-menu'>
		<h4>文印历史</h4>
		<ul id='history' class='menu'>
			<li>全部</li>
			<li>队列中 (1)</li>
			<li>打印中 (2)</li>
			<li>到店自助</li>
			<li>待领取 (4)</li>
			<li>已撤消</li>
		</ul>
	</li>
</ul>
<form id='flow-detail' class='detail'>
	<div id='sub-menu'>
		<div id='store'>
			<input type='hidden' name='pid' />
			<h4>选择打印店（北京大学）</h4>
			<ul class='menu'>
				<li data-pid='1'>农行提款机旁打印店（在线）</li>
				<li data-pid='2'>三十五楼打印店（离线）</li>
			</ul>
			<a href='addschool'>想添加打印店？</a>
		</div>
		<div id='service'>
			<h4>选择服务</h4>
			<ul class='menu'>
				<li>定制打印</li>
				<li>低碳打印</li>
			</ul>
		</div>
		<div id='upload'>
			<h4>上传文件</h4>
			<input type='file' name='file' />
			<ul id='upload-progress' class='menu'>
				<li class='active'>
					<label>上传完成</label>
					<span>100% = 245px</span>
				</li>
			</ul>
		</div>
	</div>
	<div id='requirement'>
		<h4>提交文印要求</h4>
		<dl>
			<dt>选择纸张</dt>
			<dd>
				<input type='hidden' name='paper' value='A4'/>
				<ul class='option'>
					<li class='button-option'>A4</li>
					<li class='button-option'>B5</li>
				</ul>
			</dd>
		</dl>
		<dl>
			<dt>选择油墨</dt>
			<dd>
				<input type='hidden' name='color' value='黑白'/>
				<ul class='option'>
					<li class='button-option'>黑白</li>
					<li class='button-option'>彩色</li>
				</ul>
			</dd>
		</dl>
		<dl>
			<dt>环保选项</dt>
			<dd>
				<input type='hidden' name='back' value='单面打印'/>
				<ul class='option'>
					<li class='button-option'>单面打印</li>
					<li class='button-option'>双面打印</li>
				</ul>
			</dd>
		</dl>
		<dl>
			<dt>版式缩放</dt>
			<dd>
				<input type='hidden' name='layout' value='1版'/>
				<ul class='option'>
					<li class='button-option'>1版</li>
					<li class='button-option'>2版</li>
					<li class='button-option'>4版</li>
					<li class='button-option'>6版</li>
					<li class='button-option'>8版</li>
					<li class='button-option'>9版</li>
					<li class='button-option'>12版</li>
				</ul>
			</dd>
		</dl>
		<dl>
			<dt>打印份数</dt>
			<dd>
				<input type='text' name='copy' class='input-text'>
				<label class='label-hint'>只能是数字</label>
			</dd>
		</dl>
		<dl>
			<dt>附加服务</dt>
			<dd>
				<input type='hidden' name='misc' value='简易装订'/>
				<ul class='multi-option'>
					<li class='button-multi-option'>简易装订</li>
					<li class='button-multi-option'>侧边装订</li>
					<li class='button-multi-option'>添加封面</li>
				</ul>
			</dd>
		</dl>
		<dl>
			<dt>客户留言</dt>
			<dd>
				<input type='text' name='note' class='input-text'>
			</dd>
		</dl>
		<button type='submit' id='order-submit' class='button-blue'>确认并提交</button>
	</div>
</form>
<div id='history-detail' class='detail'>
	<div id='order'>
		<h4>全部</h4>
		<ul class='menu'>
			<li data-oid='2'>#2 - fsdfsdfsfsdfsdfsfsfsdfsfsdfsdfsfsdf.pdf</li>
			<li data-oid='1'>#1 - fjdslffsdafasfafsdafasfsafasdfasdffsafasfa</li>
		</ul>
	</div>
	<div id='order-detail'>
		<h4>#1 - fsdfdsfsdfdsfsdfsdfsdffsfsfsfsdfsdfsfsfsdfsdfsdfdsf.pdf</h4>
		<table>
			<tbody>
				<tr>
					<th>时间</th><td>2011 Aug 1, 8:10PM</td>
				</tr>
				<tr>
					<th>打印店</th><td>北京大学农行提款机旁打印店</td>
				</tr>
				<tr>
					<th>文件</th><td>afsdfsdfsfsdfsdfdsfsdfsfsdfsdsdfsdfsdfdsfsdfsbc.pdf</td>
				</tr>
				<tr>
					<th>纸张</th><td>A4</td>
				</tr>
				<tr>
					<th>油墨</th><td>黑白</td>
				</tr>
				<tr>
					<th>环保</th><td>双面</td>
				</tr>
				<tr>
					<th>缩放</th><td>2版</td>
				</tr>
				<tr>
					<th>份数</th><td>5份</td>
				</tr>
				<tr>
					<th>服务</th><td>简易装订</td>
				</tr>
				<tr>
					<th>留言</th><td>fkdjfklsjfskljfklsjflsjflsfjsklfjslkfjlsdjflskfkdjfklsjfskljfklsjflsjflsfjsklfjslkfjlsdjflskfkdjfklsjfskljfklsjflsjflsfjsklfjslkfjlsdjflskfkdjfklsjfskljfklsjflsjflsfjsklfjslkfjlsdjflsk</td>
				</tr>
			</tbody>
		</table>
		<button class='button-gray'>撤消订单</button>
	</div>
</div>
<br>