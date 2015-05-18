<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	global $wpdb;
	$searchSql = "SELECT `ID`, `start_airport_code`, `arrive_airport_code`, `airline_price`, `reserved_text` FROM `xq_airlines`";
	if (count($_POST) > 0) {
		//有传入参数，需要加入where条件
		$searchSql .= "WHERE";
		//表示是否有大于两个条件
		$conditionFlag = false;
		if (isset($_POST["ID"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `ID`='" . $_POST["ID"] . "'";
			} else {
				$searchSql .= " `ID`='" . $_POST["ID"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["start_airport_code"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `start_airport_code`='" . $_POST["start_airport_code"] . "'";
			} else {
				$searchSql .= " `start_airport_code`='" . $_POST["start_airport_code"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["arrive_airport_code"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `arrive_airport_code`='" . $_POST["arrive_airport_code"] . "'";
			} else {
				$searchSql .= " `arrive_airport_code`='" . $_POST["arrive_airport_code"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["airline_price"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `airline_price`='" . $_POST["airline_price"] . "'";
			} else {
				$searchSql .= " `airline_price`='" . $_POST["airline_price"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["reserved_text"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `reserved_text`='" . $_POST["reserved_text"] . "'";
			} else {
				$searchSql .= " `reserved_text`='" . $_POST["reserved_text"] . "'";
			}
			$conditionFlag = true;
		}
	}
	//var_dump($searchSql);
	$discountAirlineArray = $wpdb->get_results($searchSql);
	$outp = "";
	foreach ($discountAirlineArray as $discountAirline) {
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"ID":"' . $discountAirline->ID . '",';
		$outp .= '"start_airport_code":"' . $discountAirline->start_airport_code . '",';
		$outp .= '"arrive_airport_code":"' . $discountAirline->arrive_airport_code . '",';
		$outp .= '"airline_price":"' . $discountAirline->airline_price . '",';
		$outp .= '"reserved_text":"' . $discountAirline->reserved_text . '"}';
	}

	$outp = '{"records":[' . $outp . ']}';
	echo ($outp);
}

?>