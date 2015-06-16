<?php
	global $wpdb;
	$saveArray = array(
		'user_login' => "xuanqi",
		'product_name' => "广东出发",
		'inject_date' => "2015-06-30",
		'product_price' => "2700",
		'if_airplane' => "0",
		'start_airport_name' => NULL,
		'start_date' => "",
		'back_date' => "",
		'airline_price' => "0",
		'if_hotel' => "0",
		'in_date' => "",
		'out_date' => "",
		'hotel_price' => 0,
		'total_price' => 2700,
		'order_status' => 0);

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
			'%d',
			'%d',
			'%s',
			'%s',
			'%d',
			'%d',
			'%s')
	);
?>