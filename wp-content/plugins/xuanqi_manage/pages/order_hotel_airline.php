<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";

} else {
//预约界面，需要选择产品、出发城市
	global $wpdb;
//查询出所有的出发地
	$airportArray = $wpdb->get_results("SELECT `airport_code`, `airport_icao`, `airport_iata`, `airport_name`, `city_code`, `city_name`, `province_code`, `province_name`, `reserved_text` FROM `xq_airports` WHERE `airport_code` != 'VHHH_HKG'");
	$productArray = $wpdb->get_results("SELECT `product_name`, `ID` FROM `xq_products`");

	?>

	<form id="orderForm" name="orderForm" action="<?php echo get_bloginfo('wpurl') . "/结算";?>" method="post">
		<div style="width:50%;float:left;" id="orderDiv">
			<table>
				<tr><td><label>请选择产品：</label>
			    <select name="product_id" id="product_id" required>
			<?php
foreach ($productArray as $product) {
		$text = $product->product_name;
		$value = $product->ID;
		echo "<option value='$value'>$text</option>";
	}
	?>
			    </select></tr></td>

				<tr><td><label>到达为香港国际机场，请选择出发地：</label>
			    <select name="airport_code" id="airport_code" required onchange="hideHotelAirlineDiv()">
			<?php
foreach ($airportArray as $airport) {
		$text = $airport->airport_name;
		$value = $airport->airport_code . "," . $airport->province_code;
		echo "<option value='$value'>$text</option>";
	}
	?>
			    </select></tr></td>

			    <tr><td><label>请选择第几次预约：</label>
			    <select name="order_index" id="order_index" required>
			        <option value="1">第一次预约</option>
			        <option value="2">第二次预约</option>
			        <option value="3">第三次预约</option>
			    </select></tr></td>


				<tr><td><label>请选择疫苗注射日期：</label>
				<input type="text" id="inject_date" name="inject_date" autocomplete="off"/><tr><td>
				<tr><td><input type="button" onclick="showHotelAirlineDiv('<?php echo get_bloginfo('wpurl');?>')" value="选择机票和酒店"></input><tr><td>
			</table>
		</div>
		<div id="hotelAirlineDiv" style="display: none;margin-left:50%;">

			<div id="airlineDiv">
				<label>您的出发地不在广东省内，请选择是否购买机票</label>
				<input type="radio" name="if_airplane" value="0" onclick="showAirplaneDateDiv(this.value)">否
				<input type="radio" name="if_airplane" value="1" checked onclick="showAirplaneDateDiv(this.value)">是
				<br>
				<div id="airplaneDateDiv">
					<label>请选择出发日期：</label>
					<input type="text" id="start_date" name="start_date" required autocomplete="off"/>
					<label>请选择返程日期：</label>
					<input type="text" id="back_date" name="back_date" required autocomplete="off"/>
				</div>

			</div>

			<div id="hotelDiv">
				<label>是否入住酒店？</label>
				<input type="radio" name="if_hotel" value="0" onclick="showHotelDateDiv(this.value)">否
				<input type="radio" name="if_hotel" value="1" checked onclick="showHotelDateDiv(this.value)">是
				<br>
				<div id="hotelDateDiv">
					<label>请选择酒店入住日期：</label>
					<input type="text" id="in_date" name="in_date" autocomplete="off"/>
					<label>请选择酒店退房日期：</label>
					<input type="text" id="out_date" name="out_date" autocomplete="off"/><br/><br/>
				</div>
			</div>


			<input type="button" onclick="toSettlement()" value="费用结算"></input>
			<input type="hidden" id="back_price" name="back_price"></input>
			<input type="hidden" id="start_price" name="start_price"></input>
		</div>
	</form>
	<script type="text/javascript">
    $("#inject_date").regMod("calendar", "6.0", {
        options: {
            autoShow: !1,
            showWeek: !0,
            maxDate: function() {
                var a = (new Date).addYears(1);
                return a.getFullYear() + "-" + (a.getMonth() + 1) + "-" + a.getDate();
            }()
        },
        listeners: {
            onBeforeShow: function() {},
            onChange: function() {}
        }
    })
	</script>
<?php
}
?>