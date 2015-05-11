<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	global $wpdb;
	$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products`");
	$outp = "";
	foreach ($productArray as $product) {
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"product_id":"' . $product->ID . '",';
		$outp .= '"product_name":"' . $product->product_name . '",';
		$outp .= '"product_price":"' . $product->product_price . '",';
		$outp .= '"product_dealer_price":"' . $product->product_dealer_price . '",';

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