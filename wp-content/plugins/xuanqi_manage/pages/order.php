<?php
//预约界面，需要选择产品、出发城市
global $wpdb;
//查询出所有的产品
$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products`");
//查询出所有的出发地
$airportArray = $wpdb->get_results("SELECT `airport_code`, `airport_icao`, `airport_iata`, `airport_name`, `city_code`, `city_name`, `province_code`, `province_name`, `reserved_text` FROM `xq_airports`");

?>
<div>
	<form name="orderForm" action="<?php echo get_bloginfo('wpurl') . "/预约成功";?>" method="post">
				<div style="width:50%;float:left;">
		            <label>请选择产品：</label>
		            <select id="product_select" style="width:80%" name="product_id" onchange="showProcessDiv(this.value)">
		            	<option selected id="makeYourChoice">请选择</option>
<?php
foreach ($productArray as $product) {
	$optionValue = $product->ID . "," . $product->product_type;
	echo "<option value='$optionValue'>$product->product_name</option>";
}
?>
		            </select>
				</div>
				<div style="margin-left:50%;display: none" id="yimiaoDiv">
					<label>请选择出发地：</label>
		            <select style="width:80%" name="from_airport" id="from_airport" required>
		            	<option selected value="" id="makeYourChoice" >请选择</option>
<?php
foreach ($airportArray as $airport) {
	$text = $airport->airport_name;
	$value = $airport->airport_code;
	echo "<option value='$value'>$text</option>";
}
?>
		            </select>
		            <br>
		            <label>请选择到达城市机场：</label>
		            <select style="width:80%" name="to_airport" id="to_airport" required>
		                <option value="ZGGG_CAN" selected>广州白云机场</option>
		                <option value="VHHH_HKG">香港国际机场</option>
		                <option value="ZGSZ_SZX">深圳宝安国际机场</option>
		            </select>
		            <br>
		        	<label>是否选择特惠机票？（仅限于特定日期）</label>
					<input type="radio" name="airline_discount" value="NO" checked onclick="showOrderDate(this.value, '<?php echo get_bloginfo('wpurl') . "/show-discount-airline";?>')">否
					<input type="radio" name="airline_discount" value="YES" onclick="showOrderDate(this.value)">是
					<br>
					<label>请选择出发日期：</label>
					<input type="text" style="width:80%" id="calendar" name="order_date" readonly="readonly" onclick="ajaxTime();" placeholder="点击选择时间"/>
					<br>
					<button type="submit">费用结算</button>
				</div>

				<div style="margin-left:50%;display: none" id="notYimiaoDiv">
					后续会加上具体的流程，目前还没有确定
					<br>
					<button type="submit" disabled="true">费用结算</button>
				</div>
	</form>
</div>

