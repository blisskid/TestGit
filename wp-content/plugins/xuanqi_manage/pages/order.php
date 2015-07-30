<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "请 <a href=\"" . $wpurl . "/login\">登录</a>.";

} else {
//预约界面，需要选择产品、出发城市
	global $wpdb;
//查询出所有的出发地
	$user_login = $current_user->user_login;
	$orderArray = $wpdb->get_results("SELECT `product_name`, `inject_date`, `save_time` FROM `xq_orders` WHERE `user_login`='$user_login' and `order_status` = 1 ORDER BY `save_time`");

	?>
	<form action="<?php echo get_bloginfo('wpurl') . "/预约机票酒店";?>">
	<div style="width:48%;float:left;">
		<div class="xqFormHat">个人信息</div>
		<div class="xqFormPage">		
			<table>
				<tr><td><b>用户：</b><?php echo $current_user->user_login;?></tr></td>
				<tr><td><b>姓名：</b><?php echo get_usermeta($current_user->ID, 'last_name') . get_usermeta($current_user->ID, 'first_name');?></tr></td>
				<tr><td><b>性别：</b><?php echo get_usermeta($current_user->ID, 'sex');?></tr></td>
				<tr><td><b>年龄：</b><?php echo get_usermeta($current_user->ID, 'age');?></tr></td>
				<tr><td><b>邮箱：</b><?php echo $current_user->user_email;?></tr></td>
				<tr><td><b>手机：</b><?php echo get_usermeta($current_user->ID, 
				'phone');?></tr></td>
				<tr><td><b>职业：</b><?php echo get_usermeta($current_user->ID, 'job');?></tr></td>
				<tr><td><b>过敏：</b><?php echo get_usermeta($current_user->ID, 'allergy');?></tr></td>
			</table>
		</div>
	</div>


	<div style="margin-left:52%;width:48%;">
		<div class="xqFormHat">历史预约信息</div>
		<div class="xqFormPage">		
			<table>
				<?php
	if (count($orderArray) == 0) {
			echo "<tr><td>您是第一次预约，暂无预约信息</tr></td>";
		} else {
			$orderCount = 0;
			foreach ($orderArray as $order) {
				$orderCount++;
				$product_name = $order->product_name;
				$inject_date = $order->inject_date;
				$save_time = $order->save_time;
				echo "<tr><td><b>第" . $orderCount . "次预约：</b></tr></td>";
				echo "<tr><td><b>订单生成时间：</b>$save_time</tr></td>";
				echo "<tr><td><b>产品名称：</b>$product_name</tr></td>";
				echo "<tr><td><b>注射日期：</b>$inject_date</tr></td>";
			}

		}
		?>
				<tr><td><button>信息无误，开始预约</button></tr></td>
			</table>
		</div>			
	</div>
	</form>

<?php
}
?>