<?php
$user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $user->ID) {

	echo "用户未登录！";

} else {

	global $wpdb;

	if (isset($_POST["product_name"]) && isset($_POST["order_date"]) && isset($_POST["product_price"]) && isset($_POST["customer_array"])) {

		$saveArray = array(
			'user_login' => $user->user_login,
			'product_name' => $_POST["product_name"],
			'order_date' => $_POST["order_date"],
			'product_price' => $_POST["product_price"],
			// 'customer_array' => stripslashes($_POST["customer_array"]),
			'customer_array' => $_POST["customer_array"],
			'order_status' => 0);

		// var_dump($saveArray);

		
		$result = $wpdb->insert(
			'xq_orders',
			$saveArray,
			array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
				'%d')
		);
		
		if (0 < $result) {
			echo $wpdb->insert_id;
		} else {
			echo "<font color='red'>数据插入错误，信息为：" . $result . "</font><br><br>";
		}
	} else {
		echo "<font color='red'>输入参数有误！</font>";
	}
}

?>