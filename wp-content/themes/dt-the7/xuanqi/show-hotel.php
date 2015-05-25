<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	global $wpdb;

	$searchSql = "SELECT `ID`, `date`, `price` FROM `xq_hotels`";
	$countSql = "SELECT COUNT(*) FROM `xq_hotels`";
	$conditionStr = "";
	if (count($_GET) > 1) {
		//有传入参数，需要加入where条件
		$conditionStr .= "WHERE";
		//表示是否有大于两个条件
		$conditionFlag = false;
		if (isset($_GET["ID"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `ID`=" . $_GET["ID"];
			} else {
				$conditionStr .= " `ID`=" . $_GET["ID"];
			}
			$conditionFlag = true;
		}
		if (isset($_GET["hotel_price"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `price`=" . $_GET["hotel_price"];
			} else {
				$conditionStr .= " `price`=" . $_GET["hotel_price"];
			}
			$conditionFlag = true;
		}
		if (isset($_GET["hotel_date"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `date`='" . $_GET["hotel_date"] . "'";
			} else {
				$conditionStr .= " `date`='" . $_GET["hotel_date"] . "'";

			}
			$conditionFlag = true;
		}
		if (isset($_GET["reserved_text"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `reserved_text`='" . $_GET["reserved_text"] . "'";
			} else {
				$conditionStr .= " `reserved_text`='" . $_GET["reserved_text"] . "'";
			}
			$conditionFlag = true;
		}

	}

	$searchSql .= $conditionStr;
	$countSql .= $conditionStr;

	$count = $wpdb->get_var($countSql);

	$searchSql .= " ORDER BY date DESC";

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
		$outp .= '"date":"' . $item->date . '",';
		$outp .= '"price":"' . $item->price . '"}';
	}

	$outp = '{"records":[' . $outp . '], "count":"' . $count . '"}';
	echo ($outp);
}

?>