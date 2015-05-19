<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	global $wpdb;
	$searchSql = "SELECT `ID`, `two_airport_code`, `start_airport_code`, `arrive_airport_code`, `date`, `price`, `reserved_text` FROM `xq_airlines`";
	if (count($_POST) > 0) {
		//有传入参数，需要加入where条件
		$searchSql .= "WHERE";
		//表示是否有大于两个条件
		$conditionFlag = false;
		if (isset($_POST["ID"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `ID`=" . $_POST["ID"];
			} else {
				$searchSql .= " `ID`=" . $_POST["ID"];
			}
			$conditionFlag = true;
		}
		if (isset($_POST["two_airport_code"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `two_airport_code`='" . $_POST["two_airport_code"] . "'";
			} else {
				$searchSql .= " `two_airport_code`='" . $_POST["two_airport_code"] . "'";
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
		if (isset($_POST["date"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `date`='" . $_POST["airline_date"] . "'";
			} else {
				$searchSql .= " `date`='" . $_POST["airline_date"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["price"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `price`=" . $_POST["airline_price"];
			} else {
				$searchSql .= " `price`=" . $_POST["airline_price"];
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

	$discountAirlineArray = $wpdb->get_results($searchSql);
	$outp = "";
	foreach ($discountAirlineArray as $discountAirline) {
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"Price":"' . $discountAirline->price . '",';
		$outp .= '"Date":"' . $discountAirline->date . '"}';
	}

	$outp = '[' . $outp . ']';
	echo ($outp);
}

?>