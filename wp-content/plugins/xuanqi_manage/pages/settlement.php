<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {

	if (isset($_POST["product_id"]) && isset($_POST["from_airport"]) && isset($_POST["to_airport"]) && isset($_POST["start_price"]) && isset($_POST["back_price"]) && isset($_POST["start_date"]) && isset($_POST["back_date"])) {

		$productidandtype = explode(",", trim($_POST["product_id"]));
		$productid = $productidandtype[0];
		global $wpdb;
		$searchSql = "SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products` WHERE `ID`=$productid";

		$productArray = $wpdb->get_results($searchSql);	
		$product = $productArray[0];

		$from_airport = trim($_POST['from_airport']);
		$to_airport = trim($_POST['to_airport']);
		$fromAirportArray = $wpdb->get_results("SELECT `airport_name` FROM `xq_airports` WHERE `airport_code`='$from_airport'");
		$fromAirport = $fromAirportArray[0];
		$toAirportArray = $wpdb->get_results("SELECT `airport_name` FROM `xq_airports` WHERE `airport_code`='$to_airport'");
		$toAirport = $toAirportArray[0];

		$product_id = trim($product->ID);
		$product_price = trim($product->product_price);
		$start_airport_code = trim($_POST["from_airport"]);
		$arrive_airport_code = trim($_POST["to_airport"]);
		$airline_price = $_POST["back_price"] + $_POST["start_price"];
		$start_date = trim($_POST["start_date"]);
		$back_date = trim($_POST["back_date"]);
		$total_price = $airline_price + $product_price;

		$result = $wpdb->insert( 
			'xq_orders', 
			array( 
				'product_id' => $product_id, 
		        'product_price' => $product_price,
		        'start_airport_code' => $start_airport_code,
		        'arrive_airport_code' => $arrive_airport_code,
		        'airline_price' => $airline_price,
		        'start_date' => $start_date,
		        'back_date' => $back_date,
		        'total_price' => $total_price,
		        'order_status' => 0
		    ), 
		    array( 
		        '%s', 
		        '%d',
		        '%s',
		        '%s',
		        '%d',
		        '%s',
		        '%s',
		        '%d',
		        '%d'
		    ) 
		);		

		if (0 < $result) {

		//结算需要显示出用户需要支付的产品价格和机票价格
		?>

<div>
	<div>
		<h3>产品信息：</h3>
		<p>
		产品名称：<?php echo $product->product_name;?>
		<br>
		产品价格：<?php echo $product->product_price;?>元
		</p>
	</div>
	<div>
		<h3>去程信息：</h3>
		<p>
		出发时间：<?php echo $start_date;?>
		<br>
		出发航站楼：<?php echo $fromAirport->airport_name;?>
		<br>
		到达航站楼：<?php echo $toAirport->airport_name;?>
		<br>
		机票价格：<?php echo $_POST["start_price"];?>元
		</p>
	</div>
	<div>
		<h3>返程信息：</h3>
		<p>
		出发时间：<?php echo $back_date;?>
		<br>
		出发航站楼：<?php echo $toAirport->airport_name;?>
		<br>
		到达航站楼：<?php echo $fromAirport->airport_name;?>
		<br>
		机票价格：<?php echo $_POST["back_price"];?>元
		</p>
	</div>
	<div>
		<h3>费用合计：</h3>
		<p>
		总金额：<?php echo $total_price;?>元
		</p>
	</div>
	<button>支付费用</button>
</div>

<?php

		} else {
			echo "<font color='red'>数据插入错误，信息为："+$result+"</font><br><br>";
		}
	}
	else {
		echo "<font color='red'>输入参数有误！</font>";
	}
}

?>