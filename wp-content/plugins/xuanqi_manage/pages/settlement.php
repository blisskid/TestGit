<?php
$user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $user->ID) {

	echo "用户未登录！";

} else {

	global $wpdb;

	if (isset($_POST["product_id"]) && isset($_POST["airport_code"]) && isset($_POST["inject_date"])
		&& isset($_POST["start_date"]) && isset($_POST["back_date"]) && isset($_POST["in_date"])
		&& isset($_POST["out_date"]) && isset($_POST["if_hotel"]) && isset($_POST["if_airplane"])
		&& isset($_POST["order_index"])) {

		//var_dump($_POST);

		$product_id = trim($_POST["product_id"]);
		$airport_codeArray = split(",", trim($_POST["airport_code"]));
		$airport_code = $airport_codeArray[0];
		$inject_date = trim($_POST["inject_date"]);
		$start_date = trim($_POST["start_date"]);
		$back_date = trim($_POST["back_date"]);
		$in_date = trim($_POST["in_date"]);
		$out_date = trim($_POST["out_date"]);
		$if_hotel = trim($_POST["if_hotel"]);
		$if_airplane = trim($_POST["if_airplane"]);
		$order_index = trim($_POST["order_index"]);

		$product_price = 0;
		$airline_price = 0;
		$hotel_price = 0;

		$product = $wpdb->get_row("SELECT `product_name`, `product_price`, `product_dealer_price`, `product_direct_price` FROM `xq_products` WHERE `ID`=$product_id");

		//如果是第一次预约，需要计算产品价格
		if ("1" == $order_index) {
			$product_price = $product->product_price;
			$user_type = get_usermeta($user->ID, 'user_type');
			if ("3" == $user_type) {
				//经销商价格
				$product_price = $product->product_dealer_price;

			} else if ("4" == $user_type) {
				//直销商价格
				$product_price = $product->product_direct_price;
			}
		}

		//如果选择了航班，则计算航班价格
		if ("1" == $if_airplane) {
			$airport = $wpdb->get_row("SELECT `hongkong_price`,`airport_name` FROM `xq_airports` WHERE `airport_code`='$airport_code'");
			$airline_price = $airport->hongkong_price * 2;
		}

		//如果选择了酒店，计算酒店价格
		if ("1" == $if_hotel) {
			$dt_in = strtotime($in_date);
			$dt_out = strtotime($out_date);
			//key为入住时间，value为价格
			$hotelDatePriceArray = array();

			while ($dt_in <= $dt_out) {
				$week = date("D", $dt_in);
				if ("Fri" == $week || "Sat" == $week) {
					$hotelDatePriceArray[$dt_in] = get_option('hotel_weekend_price');
				} else {
					$hotelDatePriceArray[$dt_in] = get_option('hotel_weekday_price');
				}
				$dt_in += 3600 * 24; //增加一天
			}

			$hotelArray = $wpdb->get_results("SELECT `date`, `price` FROM `xq_hotels` WHERE `date`>='$in_date' AND `date`<'$out_date'");

			foreach ($hotelArray as $hotel) {
				$hotelDatePriceArray[strtotime($hotel->date)] = $hotel->price;
			}

			//var_dump($hotelDatePriceArray);

			$hotel_price = 0;
			foreach ($hotelDatePriceArray as $hotelPrice) {
				$hotel_price += $hotelPrice;
			}
		}

		$total_price = $hotel_price + $product_price + $airline_price;

		$saveArray = array(
			'user_login' => $user->user_login,
			'product_name' => $product->product_name,
			'inject_date' => $inject_date,
			'product_price' => $product_price,
			'if_airplane' => $if_airplane,
			'start_airport_name' => $airport->airport_name,
			'start_date' => $start_date,
			'back_date' => $back_date,
			'airline_price' => $airline_price,
			'if_hotel' => $if_hotel,
			'in_date' => $in_date,
			'out_date' => $out_date,
			'hotel_price' => $hotel_price,
			'total_price' => $total_price,
			'order_status' => 0);

		//var_dump($saveArray);

		$result = $wpdb->insert(
			'xq_orders',
			$saveArray,
			array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s')
		);

		if (0 < $result) {

			//结算需要显示出用户需要支付的产品价格和机票价格
			?>

<div>
	<div>
		您的本次预约为第<?php echo $order_index;?>次预约。
		<h4>产品信息：</h4>
		产品名称：<?php echo $product->product_name;?>
		<br>
		注射时间：<?php echo $inject_date;?>
	</div>
<?php if ("1" == $if_airplane) {
				?>
	<div>
		<h4>航线信息：</h4>
		出发时间：<?php echo $start_date;?>
		<br>
		出发航站楼：<?php echo $airport->airport_name;?>
		<br>
		返回时间：<?php echo $back_date;?>
	</div>
	<?php }
			?>
<?php if ("1" == $if_hotel) {
				?>
	<div>
		<h4>住宿信息：</h4>
		入住时间：<?php echo $in_date;?>
		<br>
		离店时间：<?php echo $out_date;?>
	</div>
	<?php }
			?>
	<div>
		<h4>费用合计：</h4>
		总金额：<?php echo $total_price;?>元
	</div>
	<button>支付费用</button>
</div>

<?php

		} else {
			echo "<font color='red'>数据插入错误，信息为："+$result+"</font><br><br>";
		}
	} else {
		echo "<font color='red'>输入参数有误！</font>";
	}
}

?>