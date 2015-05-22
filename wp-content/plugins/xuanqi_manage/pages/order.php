<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {
//预约界面，需要选择产品、出发城市
	global $wpdb;
//查询出所有的出发地
	$airportArray = $wpdb->get_results("SELECT `airport_code`, `airport_icao`, `airport_iata`, `airport_name`, `city_code`, `city_name`, `province_code`, `province_name`, `reserved_text` FROM `xq_airports` WHERE `airport_code` not in ('ZGGG_CAN', 'ZGSZ_SZX', 'VHHH_HKG')");

	?>
<div>
	<form name="orderForm" action="<?php echo get_bloginfo('wpurl') . "/结算";?>" method="post">
		<div style="width:50%;float:left;">
			<h3>个人信息：</h3>
			<p>
			用户名：<?php echo $current_user->user_login;?>
			<br>
			邮箱：<?php echo $current_user->user_email?>
			<br>
			手机：<?php echo get_usermeta($user->ID, 'phone');?>			
			</p>			
		</div>
		<div style="margin-left:50%;display: none" id="yimiaoDiv">
			<label>请选择出发地：</label>
		    <select style="width:80%" name="from_airport" id="from_airport" required>
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
		    <!--
			<label>是否选择特惠机票？（仅限于特定日期）</label>
			<input type="radio" name="airline_discount" value="NO" checked onclick="showOrderDate(this.value)">否
			<input type="radio" name="airline_discount" value="YES" onclick="showOrderDate(this.value)">是
			<br>

			<div style="display: none" id="discountDate">
				-->
			<div>
				<label>请选择出发日期：</label>
				<input type="text" style="width:80%" id="start_date" name="start_date" readonly="readonly" onclick="getStartDate('<?php echo get_bloginfo('wpurl');?>');"/>
				<input type="hidden" id="start_price" name="start_price"></input>
				<br>
				<label>请选择返程日期：</label>
				<input type="text" style="width:80%" id="back_date" name="back_date" readonly="readonly" onclick="getBackDate('<?php echo get_bloginfo('wpurl');?>');"/>
				<input type="hidden" id="back_price" name="back_price"></input>
				<br>
			</div>
			<button type="submit">费用结算</button>
		</div>

		<div style="margin-left:50%;display: none" id="notYimiaoDiv">
			后续会加上具体的流程，目前还没有确定
			<br>
			<button type="submit" disabled="true">费用结算</button>
		</div>
	</form>
</div>

<?php
}
?>