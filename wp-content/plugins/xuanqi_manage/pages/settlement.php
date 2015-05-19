<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {

	$searchSql = "SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products` WHERE `ID`=$_POST['product_id']";
	$product = $wpdb->get_results($searchSql)[0];

	$product_id = $product->ID;
	$product_price = $product->product_price;
	$start_airport_code = $_POST["from_airport"];
	$arrive_airport_code = $_POST["to_airport"];
	$airline_price = $_POST["airline_price"];
	$start_date = $_POST["start_date"];
	$back_date = $_POST["back_date"];
	$total_price = $airline_price + $product_price;

	$insertSql = "INSERT INTO `xq_orders` (`product_id`,`product_price`,`start_airport_code`,`arrive_airport_code`,`airline_price`,`start_date`,`back_date`,`total_price`, `order_status`)
 VALUES($product_id,$product_price,'$start_airport_code','$arrive_airport_code',$airline_price,'$start_date','$back_date',$total_price,0);";

	$result = $wpdb->query($sql);
	//var_dump($result);
	if (0 < $result) {
		//结算需要显示出用户需要支付的产品价格和机票价格
?>

<?php
	} else {
		echo "<font color='red'>数据插入错误，信息为："+$result+"</font><br><br>";
	}
	
}

?>