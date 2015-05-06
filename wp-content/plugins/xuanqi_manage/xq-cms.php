<?php

/**
 * Plugin Name: 1xuanqi
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: xuanqi plugin.
 * Version: 1.0.0
 * Author: Lei Yu
 * Author URI: http://URI_Of_The_Plugin_Author
 * Text Domain: mytextdomain
 * Domain Path: Example: /locale/
 * Network: false
 * License: GPL2
 */

//add menu
add_action('admin_menu', 'register_my_custom_menu_page');

//add style
function add_styles() {
	//var_dump(plugins_url('css/xuanqi.css', __FILE__));
	wp_register_style('plugin_stylesheet', plugins_url('css/xuanqi.css', __FILE__));
	wp_enqueue_style('plugin_stylesheet');
}

add_action('init', 'add_styles');

//add js
function add_scripts() {
	wp_register_script('plugin_script', plugins_url('js/xuanqi.js', __FILE__), array('jquery'), '1.0', true);
	wp_enqueue_script('plugin_script');
}

add_action('init', 'add_scripts');

//product management
function register_my_custom_menu_page() {
	//product config
	add_menu_page('产品配置', '产品配置', 'manage_options', 'xuanqi_products_config', 'xuanqi_products_config_callback', '', 6);
	add_submenu_page('xuanqi_products_config', '新建产品', '新建产品', 'manage_options', 'xuanqi_add_product', 'xuanqi_add_product_callback');

	//airport config
	add_menu_page('机场配置', '机场配置', 'manage_options', 'xuanqi_aiports_config', 'xuanqi_aiports_config_callback', '', 7);
	add_submenu_page('xuanqi_aiports_config', '新建机场', '新建机场', 'manage_options', 'xuanqi_add_airport', 'xuanqi_add_airport_callback');
}

function xuanqi_products_config_callback() {

	echo "<table>";
	echo "<th>产品名称</th>";
	echo "<th>产品价格（元）</th>";
	echo "<th>经销商产品价格（元）</th>";
	echo "<th>产品描述</th>";
	echo "<th>产品优势</th>";
	echo "<th>产品类别</th>";
	echo "<th>支付流程</th>";
	global $wpdb;
	$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_description`, `product_advantage`, `product_type`, `product_paytype`, `reserved_text` FROM `xq_products`");
	foreach ($productArray as $product) {
		echo "<tr>";
		echo "<td>$product->product_name</td>";
		echo "<td>$product->product_price</td>";
		echo "<td>$product->product_dealer_price</td>";
		echo "<td>$product->product_description</td>";
		echo "<td>$product->product_advantage</td>";
		echo "<td>$product->product_type</td>";
		echo "<td>$product->product_paytype</td>";
		echo "</tr>";
	}
	//echo '<tr><button onclick="saveCamera()">新建产品</button></tr>';
	echo "</table>";

}

function xuanqi_add_product_callback() {
	$url = get_bloginfo('wpurl') . "/xuanqi-save-product";
	echo "<form action='$url' method='post'>";
	?>

		<table align="center">
		    <tr>
		        <td>
		            Input the camera's name:
		        </td>
		        <td>
		            <input style="width:300px" type="text" value="" id="room" name="room"></input>
		            <input type="hidden" id="cameraId" name="cameraId" value="">
		        </td>
		    </tr>
		    <tr>
		        <td>
		            Input the camera's ip:
		        </td>
		        <td>
		            <input style="width:300px" type="text" value="" id="ip" name="ip"></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            Input the camera's record time:
		        </td>
		        <td>
		            <input style="width:300px" type="text" value="" id="recordTime" name="recordTime"></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <input type="submit" value="Save">
		        </td>
		    </tr>
		</table>
	</form>
<?php

}

?>