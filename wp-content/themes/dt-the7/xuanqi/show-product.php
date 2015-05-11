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
		$outp .= '"product_type":"' . $product->product_type . '",';
		$outp .= '"product_paytype":"' . $product->product_paytype . '",';
		$outp .= '"product_show":"' . $product->product_show . '"}';
	}

	$outp = '{"records":[' . $outp . ']}';
	echo ($outp);
}

?>