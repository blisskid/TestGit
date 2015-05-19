<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {

	$productid = $_POST['product_id'];
	$searchSql = "SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products` WHERE `ID`=$productid";
	$product = $wpdb->get_results($searchSql)[0];

	$from_airport = $_POST['from_airport'];
	$to_airport = $_POST['to_airport'];
	$fromAirport = $wpdb->get_results("SELECT `airport_name` FROM `xq_airports` WHERE `airport_code`='$from_airport'")[0];
	$toAirport = $wpdb->get_results("SELECT `airport_name` FROM `xq_airports` WHERE `airport_code`='$to_airport'")[0];

	$product_id = $product->ID;
	$product_price = $product->product_price;
	$start_airport_code = $_POST["from_airport"];
	$arrive_airport_code = $_POST["to_airport"];
	$airline_price = $_POST["back_price"] + $_POST["start_price"];
	$start_date = $_POST["start_date"];
	$back_date = $_POST["back_date"];
	$total_price = $airline_price + $product_price;

	$insertSql = "INSERT INTO `xq_orders` (`product_id`,`product_price`,`start_airport_code`,`arrive_airport_code`,`airline_price`,`start_date`,`back_date`,`total_price`, `order_status`)
 VALUES($product_id,$product_price,'$start_airport_code','$arrive_airport_code',$airline_price,'$start_date','$back_date',$total_price,0)";

	$result = $wpdb->query($sql);
	//var_dump($result);
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
		出发航站楼：<?php echo $fromAirport->airport_name;?>
		到达航站楼：<?php echo $toAirport->airport_name;?>
		机票价格：<?php echo $_POST["start_price"];?>元
		</p>
	</div>
	<div>
		<h3>返程信息：</h3>
		<p>
		出发时间：<?php echo $back_date;?>
		出发航站楼：<?php echo $toAirport->airport_name;?>
		到达航站楼：<?php echo $fromAirport->airport_name;?>
		机票价格：<?php echo $_POST["back_price"];?>元
		</p>
	</div>
	<div>
		<h3>费用合计：</h3>
		<p>
		总金额：<?php echo $total_price;?>
		</p>
	</div>
</div>
<table>
<tr>
<td>产品名称：<?php echo $product->product_name;?></td>
<td>产品价格：<?php echo $product->product_price;?></td>
</tr>
<tr>
<td>出发机场：<?php echo $product->product_name;?></td>
<td>到达机场：<?php echo $product->product_price;?></td>
</tr>
<tr>
<td>出发机场为：<?php echo $product->product_name;?></td>
<td>到达机场为：<?php echo $product->product_price;?></td>
</tr>
</table>

<?php
} else {
		echo "<font color='red'>数据插入错误，信息为："+$result+"</font><br><br>";
	}

}

?>