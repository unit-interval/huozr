<? switch($yielding_for) {
	case 'logged_in': ?>
		<p id='footer-left'>
			<span id='notification-icon'>
				<span>0</span>
			</span>
			<?= $_SESSION['u_screen_name'] ?>有50页低碳打印配额
		</p>
		<div id='notification'>
			<div id='notification-summary'>
				<h3>通知</h3>
				<ul>
					<li>
						更新：北京大学农行提款机旁打印店接受了文印任务#2
						<span></span>
					</li>
					<li>
						订单：你向北京大学农行提款机旁打印店提交了文印任务#1
						<span></span>
					</li>
				</ul>
			</div>
			<div id='notification-content'>
				<h3>‹ 回到通知
					<ul>
						<li class='disabled'>‹ 上一封</li>
						<li> | </li>
						<li class='active'>下一封 ›</li>
					</ul>
				</h3>
				<ul>
					<li>jflsdkfjklsjfl</li>
					<li>jflsdkfjklsjfl</li>
					<li>jflsdkfjklsjfl</li>
				</ul>
			</div>
		</div>
		<? break;
	case 'partner': ?>
		<p id='footer-left'>
			<?= $_SESSION['p_screen_name'] ?>
		</p>
		<? break;
	default: ?>
<? } ?>