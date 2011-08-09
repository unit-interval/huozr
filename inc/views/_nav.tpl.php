<? switch($yielding_for) {
	case 'logged_in': ?>
		<ul id='nav'>
			<li <? if ($body_id == 'home') { ?> class='active' <? } ?> >
				<a href='/home'>开始</a>
			</li>
			<li <? if ($body_id == 'info') { ?> class='active' <? } ?> >
				<a href='/info'>通知</a>
			</li>
			<li <? if ($body_id == 'setting') { ?> class='active' <? } ?> >
				<a href='/setting'>设置</a>
			</li>
			<li>
				<a href='/logout'>退出</a>
			</li>
		</ul> 
		<? break;
	case 'partner': ?>
		<? break;
	default: ?>
		<ul id='nav'>
			<li <? if ($body_id == 'login') { ?> class='active' <? } ?> >
				<a href='/login/'>登录<span></span>注册</a>
			</li>
		</ul>
<? } ?>