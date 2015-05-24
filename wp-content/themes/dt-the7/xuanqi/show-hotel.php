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
	if (count($_GET) > 0) {
		//有传入参数，需要加入where条件
		$searchSql .= "WHERE";
		//表示是否有大于两个条件
		$conditionFlag = false;
		if (isset($_GET["ID"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `ID`=" . $_GET["ID"];
			} else {
				$searchSql .= " `ID`=" . $_GET["ID"];
			}
			$conditionFlag = true;
		}
		if (isset($_GET["hotel_price"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `price`=" . $_GET["hotel_price"];
			} else {
				$searchSql .= " `price`=" . $_GET["hotel_price"];
			}
			$conditionFlag = true;
		}
		if (isset($_GET["hotel_date"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `date`='" . $_GET["hotel_date"] . "'";
			} else {
				$searchSql .= " `date`='" . $_GET["hotel_date"] . "'";

			}
			$conditionFlag = true;
		}
		if (isset($_GET["reserved_text"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `reserved_text`='" . $_GET["reserved_text"] . "'";
			} else {
				$searchSql .= " `reserved_text`='" . $_GET["reserved_text"] . "'";
			}
			$conditionFlag = true;
		}
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

	$outp = '{"records":[' . $outp . ']}';
	echo ($outp);
}

?>