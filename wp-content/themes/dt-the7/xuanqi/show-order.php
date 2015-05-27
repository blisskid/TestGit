<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	global $wpdb;
	$searchSql = "SELECT `ID`,`user_login`,`product_name`,`product_price`,`if_airplane`,`start_airport_name`,`arrive_airport_name`,`start_date`,`back_date`,`airline_price`,`if_hotel`,`in_date`,`out_date`,`hotel_price`,`total_price`,`order_status`,`save_time`,`reserved_text` FROM `xq_orders`";
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
		$outp .= '"if_airplane":"' . $item->if_airplane . '",';
		$outp .= '"start_airport_name":"' . $item->start_airport_name . '",';
		$outp .= '"arrive_airport_name":"' . $item->arrive_airport_name . '",';
		$outp .= '"start_date":"' . $item->start_date . '",';
		$outp .= '"back_date":"' . $item->back_date . '",';
		$outp .= '"airline_price":"' . $item->airline_price . '",';
		$outp .= '"if_hotel":"' . $item->if_hotel . '",';
		$outp .= '"in_date":"' . $item->in_date . '",';
		$outp .= '"out_date":"' . $item->out_date . '",';
		$outp .= '"hotel_price":"' . $item->hotel_price . '",';
		$outp .= '"total_price":"' . $item->total_price . '",';
		$outp .= '"order_status":"' . $item->order_status . '",';
		$outp .= '"save_time":"' . $item->save_time . '",';
		$outp .= '"reserved_text":"' . $item->reserved_text . '"}';
	}

	$outp = '{"records":[' . $outp . '], "count":"' . $count . '"}';
	echo ($outp);
}

?>