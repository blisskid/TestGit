<?php
$user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $user->ID) {

	echo "用户未登录！";

} else {

	global $wpdb;

	if (isset($_POST["product_name"]) && isset($_POST["inject_date"]) && isset($_POST["product_price"])
		&& isset($_POST["if_airplane"]) && isset($_POST["start_airport_name"]) && isset($_POST["start_date"])
		&& isset($_POST["back_date"]) && isset($_POST["airline_price"]) && isset($_POST["if_hotel"])
		&& isset($_POST["in_date"]) && isset($_POST["out_date"]) && isset($_POST["hotel_price"])
		&& isset($_POST["total_price"])) {

		$saveArray = array(
			'user_login' => $user->user_login,
			'product_name' => $_POST["product_name"],
			'inject_date' => $_POST["inject_date"],
			'product_price' => $_POST["product_price"],
			'if_airplane' => $_POST["if_airplane"],
			'start_airport_name' => $_POST["start_airport_name"],
			'start_date' => $_POST["start_date"],
			'back_date' => $_POST["back_date"],
			'airline_price' => $_POST["airline_price"],
			'if_hotel' => $_POST["if_hotel"],
			'in_date' => $_POST["in_date"],
			'out_date' => $_POST["out_date"],
			'hotel_price' => $_POST["hotel_price"],
			'total_price' => $_POST["total_price"],
			'order_status' => 0);

		//var_dump($saveArray);

		$result = $wpdb->insert(
			'xq_orders',
			$saveArray,
			array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s')
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