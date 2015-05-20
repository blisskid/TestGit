<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {

		$productidandtype = explode(",", trim($_POST["product_id"]));
		$productid = trim($productidandtype[0]);
		global $wpdb;
		$searchSql = "SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products` WHERE `ID`=$productid";

		$productArray = $wpdb->get_results($searchSql);	
		$product = trim($productArray[0]);

		$from_airport = trim($_POST['from_airport']);
		$to_airport = trim($_POST['to_airport']);
		$fromAirportArray = $wpdb->get_results("SELECT `airport_name` FROM `xq_airports` WHERE `airport_code`='$from_airport'");
		$fromAirport = trim($fromAirportArray[0]);
		$toAirportArray = $wpdb->get_results("SELECT `airport_name` FROM `xq_airports` WHERE `airport_code`='$to_airport'");
		$toAirport = trim($toAirportArray[0]);

		   $product_id = trim($product->ID);
		$product_price = trim($product->product_price);
		$start_airport_code = trim($_POST["from_airport"]);
		$arrive_airport_code = trim($_POST["to_airport"]);
		$airline_price = $_POST["back_price"] + $_POST["start_price"];
		$start_date = trim($_POST["start_date"]);
		$back_date = trim($_POST["back_date"]);
		$total_price = $airline_price + $product_price;

		$insertSql = "INSERT INTO `xq_orders` (`product_id`,`product_price`,`start_airport_code`,`arrive_airport_code`,`airline_price`,`start_date`,`back_date`,`total_price`, `order_status`)
		VALUES($product_id,$product_price,'$start_airport_code','$arrive_airport_code',$airline_price,'$start_date','$back_date',$total_price,0)";
		var_dump($insertSql);	 
		$result = $wpdb->query($sql);
		//$result = 1;
		var_dump($result);
		if (0 < $result) {

		//结算需要显示出用户需要支付的产品价格和机票价格
		?>

<?php

		} else {
			echo "<font color='red'>数据插入错误，信息为："+$result+"</font><br><br>";
		}
}

?>