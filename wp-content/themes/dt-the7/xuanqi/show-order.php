<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	global $wpdb;

	$searchSql = "SELECT `ID`,`user_login`,`product_name`,`product_price`,`order_date`,`customer_array`,`order_status`,`save_time`,`reserved_text` FROM `xq_orders`";
	$countSql = "SELECT COUNT(*) FROM `xq_orders`";
	$conditionStr = "";
	if (count($_GET) > 1) {
		//有传入参数，需要加入where条件
		$conditionStr .= " WHERE";
		//表示是否有大于两个条件
		$conditionFlag = false;
		if (isset($_GET["save_time"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `save_time` like'" . $_GET["save_time"] . "%'";
			} else {
				$conditionStr .= " `save_time` like '" . $_GET["save_time"] . "%'";

			}
			$conditionFlag = true;
		}
	}

	$searchSql .= $conditionStr;
	$countSql .= $conditionStr;

	$count = $wpdb->get_var($countSql);

	$searchSql .= " ORDER BY save_time DESC";

	if (isset($_GET["page_num"])) {
		$index = ($_GET["page_num"] - 1) * 20;
		$searchSql .= " LIMIT " . $index . ",20";
	}

	//var_dump($searchSql);
	$array = $wpdb->get_results($searchSql);
	$outp = "";
	foreach ($array as $item) {
		if ($outp != "") {$outp .= ",";}

		$outp .= '{"ID":"' . $item->ID . '",';
		$outp .= '"user_login":"' . $item->user_login . '",';
		$outp .= '"product_name":"' . $item->product_name . '",';
		$outp .= '"product_price":"' . $item->product_price . '",';
		$outp .= '"order_date":"' . $item->order_date . '",';
		$outp .= '"customer_array":"' . $item->customer_array . '",';
		if ("0" == $item->order_status) {
			$outp .= '"order_status":"未支付",';
		} else if ("1" == $item->order_status) {
			$outp .= '"order_status":"已支付",';
		} else if ("2" == $item->order_status) {
			$outp .= '"order_status":"已取消",';
		}
		$outp .= '"save_time":"' . $item->save_time . '",';
		$outp .= '"reserved_text":"' . $item->reserved_text . '"}';
	}

	$outp = '{"records":[' . $outp . '], "count":"' . $count . '"}';
	echo ($outp);
}

?>