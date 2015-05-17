<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	global $wpdb;

	$searchSql = "SELECT `airport_code`, `airport_icao`, `airport_iata`, `airport_name`, `city_code`, `city_name`, `province_code`, `province_name`, `reserved_text` FROM `xq_airports`";
	if (count($_POST) > 0) {
		//有传入参数，需要加入where条件
		$searchSql .= "WHERE";
		//表示是否有大于两个条件
		$conditionFlag = false;
		if (isset($_POST["airport_code"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `airport_code`='" . $_POST["airport_code"] . "'";
			} else {
				$searchSql .= " `airport_code`='" . $_POST["airport_code"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["airport_icao"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `airport_icao`='" . $_POST["airport_icao"] . "'";
			} else {
				$searchSql .= " `airport_icao`='" . $_POST["airport_icao"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["airport_iata"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `airport_iata`='" . $_POST["airport_iata"] . "'";
			} else {
				$searchSql .= " `airport_iata`='" . $_POST["airport_iata"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["airport_name"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `airport_name`='" . $_POST["airport_name"] . "'";
			} else {
				$searchSql .= " `airport_name`='" . $_POST["airport_name"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["city_code"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `city_code`='" . $_POST["city_code"] . "'";
			} else {
				$searchSql .= " `city_code`='" . $_POST["city_code"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["city_name"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `city_name`='" . $_POST["city_name"] . "'";
			} else {
				$searchSql .= " `city_name`='" . $_POST["city_name"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["province_code"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `province_code`='" . $_POST["province_code"] . "'";
			} else {
				$searchSql .= " `province_code`='" . $_POST["province_code"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["province_name"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `province_name`='" . $_POST["province_name"] . "'";
			} else {
				$searchSql .= " `province_name`='" . $_POST["province_name"] . "'";
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

	$airportArray = $wpdb->get_results($searchSql);
	$outp = "";
	foreach ($airportArray as $airport) {
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"airport_code":"' . $airport->airport_code . '",';
		$outp .= '"airport_icao":"' . $airport->airport_icao . '",';
		$outp .= '"airport_iata":"' . $airport->airport_iata . '",';
		$outp .= '"airport_name":"' . $airport->airport_name . '",';
		$outp .= '"city_code":"' . $airport->city_code . '",';
		$outp .= '"reserved_text":"' . $airport->reserved_text . '"}';
	}

	$outp = '{"records":[' . $outp . ']}';
	echo ($outp);
}

?>