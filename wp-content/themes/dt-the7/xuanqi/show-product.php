<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	global $wpdb;

	$searchSql = "SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_direct_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products`";
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
		if (isset($_POST["product_name"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `product_name`='" . $_POST["product_name"] . "'";
			} else {
				$searchSql .= " `product_name`='" . $_POST["product_name"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["product_price"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `product_price`=" . $_POST["product_price"];
			} else {
				$searchSql .= " `product_price`=" . $_POST["product_price"];
			}
			$conditionFlag = true;
		}
		if (isset($_POST["product_dealer_price"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `product_dealer_price`=" . $_POST["product_dealer_price"];
			} else {
				$searchSql .= " `product_dealer_price`=" . $_POST["product_dealer_price"];
			}
			$conditionFlag = true;
		}
		if (isset($_POST["product_direct_price"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `product_direct_price`=" . $_POST["product_direct_price"];
			} else {
				$searchSql .= " `product_direct_price`=" . $_POST["product_direct_price"];
			}
			$conditionFlag = true;
		}
		if (isset($_POST["product_type"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `product_type`='" . $_POST["product_type"] . "'";
			} else {
				$searchSql .= " `product_type`='" . $_POST["product_type"] . "'";

			}
			$conditionFlag = true;
		}
		if (isset($_POST["product_paytype"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `product_paytype`='" . $_POST["product_paytype"] . "'";
			} else {
				$searchSql .= " `product_paytype`='" . $_POST["product_paytype"] . "'";
			}
			$conditionFlag = true;
		}
		if (isset($_POST["product_show"])) {
			if ($conditionFlag) {
				$searchSql .= " AND `product_show`='" . $_POST["product_show"] . "'";
			} else {
				$searchSql .= " `product_show`='" . $_POST["product_show"] . "'";
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

	$productArray = $wpdb->get_results($searchSql);
	$outp = "";
	foreach ($productArray as $product) {
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"product_id":"' . $product->ID . '",';
		$outp .= '"product_name":"' . $product->product_name . '",';
		$outp .= '"product_price":"' . $product->product_price . '",';
		$outp .= '"product_dealer_price":"' . $product->product_dealer_price . '",';
		$outp .= '"product_direct_price":"' . $product->product_direct_price . '",';

		if ("0" == $product->product_type) {
			$outp .= '"product_type":"疫苗类产品",';
		} else if ("1" == $product->product_type) {
			$outp .= '"product_type":"其他",';
		}

		if ("0" == $product->product_paytype) {
			$outp .= '"product_paytype":"支付流程一",';
		} else if ("1" == $product->product_paytype) {
			$outp .= '"product_paytype":"支付流程二",';
		}

		if ("0" == $product->product_show) {
			$outp .= '"product_show":"不在首页显示"}';
		} else if ("1" == $product->product_show) {
			$outp .= '"product_show":"在首页显示"}';
		}
	}

	$outp = '{"records":[' . $outp . ']}';
	echo ($outp);
}

?>