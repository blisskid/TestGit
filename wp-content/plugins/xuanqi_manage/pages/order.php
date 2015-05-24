<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
//预约界面，需要选择产品、出发城市
	global $wpdb;
//查询出所有的出发地
	$airportArray = $wpdb->get_results("SELECT `airport_code`, `airport_icao`, `airport_iata`, `airport_name`, `city_code`, `city_name`, `province_code`, `province_name`, `reserved_text` FROM `xq_airports` WHERE `airport_code` != 'VHHH_HKG'");

	?>

	<div style="width:33.3%;float:left;">
		<h4>个人信息：</h4>
		<p>
		用户名：<?php echo $current_user->user_login;?>
		<br>
		邮箱：<?php echo $current_user->user_email?>
		<br>
		手机：<?php echo get_usermeta($current_user->ID, 'phone');?>
		</p>
		<br>
		<br>
		<h4>历史预约信息：</h4>
		<p>
		显示用户的历史预约信息。
		</p>
		<br>
		<h4 onclick="showOrderDiv()" style="cursor:pointer;color: red;">信息无误，开始预约</h4>
	</div>


	<div style="margin-left:33.3%;width:66.7%;">
		<form id="orderForm" name="orderForm" action="<?php echo get_bloginfo('wpurl') . "/结算";?>" method="post">
			<div style="width:50%;float:left;display: none;" id="orderDiv">
				到达为香港国际机场
				<label>请选择出发地：</label>
			    <select name="from_airport" id="from_airport" required onchange="hideHotelAirlineDiv()">
			<?php
foreach ($airportArray as $airport) {
		$text = $airport->airport_name;
		$value = $airport->airport_code . "," . $airport->province_code;
		echo "<option value='$value'>$text</option>";
	}
	?>
			    </select>

			    <label>请选择第几次预约：</label>
			    <select name="order_index" id="order_index" required>
			        <option value="1">第一次预约</option>
			        <option value="2">第二次预约</option>
			        <option value="3">第三次预约</option>
			    </select>
				<label>请选择疫苗注射日期：</label>

				<input type="text" id="inject_date" name="inject_date"/>
				<br>
				<h4 onclick="showHotelAirlineDiv('<?php echo get_bloginfo('wpurl');?>')" style="cursor:pointer;color: red;">选择机票和酒店</h4>

			</div>
			<div id="hotelAirlineDiv" style="display: none;margin-left:50%;">

				<div id="airlineDiv">
					您的出发地不在广东省内，需要购买往返机票
					<label>请选择出发日期：</label>

					<input type="text" id="start_date" name="start_date" readonly="readonly" onclick="getStartDate();"/>
					<!--
					<input type="text" id="start_date" name="start_date" required/>
					-->

					<label>请选择返程日期：</label>

					<input type="text" id="back_date" name="back_date" readonly="readonly" onclick="getBackDate();"/>
					<!--
					<input type="text" id="back_date" name="back_date" required/>
					-->

				</div>

				<div id="hotelDiv">
					<label>是否入住酒店？</label>
					<input type="radio" name="if_hotel" value="NO" onclick="showHotelDateDiv(this.value)">否
					<input type="radio" name="if_hotel" value="YES" checked onclick="showHotelDateDiv(this.value)">是
					<br>
					<div id="hotelDateDiv">
						<label>请选择酒店入住日期：</label>
						<input type="text" id="in_date" name="in_date"/>
						<label>请选择酒店退房日期：</label>
						<input type="text" id="out_date" name="out_date"/>
					</div>
				</div>


				<input type="button" onclick="toSettlement()" value="费用结算"></input>
				<input type="hidden" name="to_airport" id="to_airport" value="VHHH_HKG"/>
				<input type="hidden" id="back_price" name="back_price"></input>
				<input type="hidden" id="start_price" name="start_price"></input>
				<input type="hidden" id="if_airplane" name="if_airplane"></input>
			</div>
		</form>
	</div>

<?php
}
?>