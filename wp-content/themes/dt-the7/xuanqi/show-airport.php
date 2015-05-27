<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	global $wpdb;

	$searchSql = "SELECT `airport_code`, `airport_icao`, `airport_iata`, `airport_name`, `city_code`, `city_name`, `province_code`, `province_name`, `hongkong_price`, `reserved_text` FROM `xq_airports`";
	$countSql = "SELECT COUNT(*) FROM `xq_airports`";
	$conditionStr = "";
	if (count($_GET) > 1) {
		//有传入参数，需要加入where条件
		$conditionStr .= " WHERE";
		//表示是否有大于两个条件
		$conditionFlag = false;
		if (isset($_GET["airport_code"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `airport_code`='" . $_GET["airport_code"] . "'";
			} else {
				$conditionStr .= " `airport_code`='" . $_GET["airport_code"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_GET["airport_icao"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `airport_icao`='" . $_GET["airport_icao"] . "'";
			} else {
				$conditionStr .= " `airport_icao`='" . $_GET["airport_icao"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_GET["airport_iata"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `airport_iata`='" . $_GET["airport_iata"] . "'";
			} else {
				$conditionStr .= " `airport_iata`='" . $_GET["airport_iata"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_GET["airport_name"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `airport_name`='" . $_GET["airport_name"] . "'";
			} else {
				$conditionStr .= " `airport_name` like '%" . $_GET["airport_name"] . "%'";
			}
			$conditionFlag = true;
		}
		if (isset($_GET["city_code"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `city_code`='" . $_GET["city_code"] . "'";
			} else {
				$conditionStr .= " `city_code`='" . $_GET["city_code"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_GET["city_name"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `city_name`='" . $_GET["city_name"] . "'";
			} else {
				$conditionStr .= " `city_name`='" . $_GET["city_name"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_GET["province_code"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `province_code`='" . $_GET["province_code"] . "'";
			} else {
				$conditionStr .= " `province_code`='" . $_GET["province_code"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_GET["province_name"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `province_name`='" . $_GET["province_name"] . "'";
			} else {
				$conditionStr .= " `province_name`='" . $_GET["province_name"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_GET["hongkong_price"])) {
			if ($conditionFlag) {
				$conditionStr .= " AND `hongkong_price`='" . $_GET["hongkong_price"] . "'";
			} else {
				$conditionStr .= " `hongkong_price`=" . $_GET["hongkong_price"];
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

	if (isset($_GET["page_num"])) {
		$index = ($_GET["page_num"] - 1) * 20;
		$searchSql .= " LIMIT " . $index . ",20";
	}
	//var_dump($searchSql);
	$airportArray = $wpdb->get_results($searchSql);
	$count = $wpdb->get_var($countSql);
	$outp = "";
	foreach ($airportArray as $airport) {
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"airport_code":"' . $airport->airport_code . '",';
		$outp .= '"airport_icao":"' . $airport->airport_icao . '",';
		$outp .= '"airport_iata":"' . $airport->airport_iata . '",';
		$outp .= '"airport_name":"' . $airport->airport_name . '",';
		$outp .= '"city_name":"' . $airport->city_name . '",';
		$outp .= '"province_name":"' . $airport->province_name . '",';
		$outp .= '"hongkong_price":"' . $airport->hongkong_price . '",';
		$outp .= '"reserved_text":"' . $airport->reserved_text . '"}';
	}

	$outp = '{"records":[' . $outp . '], "count":"' . $count . '"}';
	echo ($outp);
}

?>