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

//重定向模板
function templateRedirect() {
	$basename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	loadCustomTemplate(TEMPLATEPATH . '/xuanqi/' . "/$basename.php");
}

add_action('template_redirect', 'templateRedirect');
//重定向模板

//Add login/logout link to naviagation menu
function add_login_out_item_to_menu($items, $args) {

	//change theme location with your them location name
	if (is_admin() || $args->theme_location != 'primary') {
		return $items;
	}

	$redirect = (is_home()) ? false : get_permalink();
	if (is_user_logged_in()) {
		$link = '<a href="' . wp_logout_url($redirect) . '" title="' . __('Logout') . '">' . "注销" . '</a>';
	} else {
		$link = '<a href="' . wp_login_url($redirect) . '" title="' . __('Login') . '">' . "登录/注册" . '</a>';
	}

	return $items .= '<li id="log-in-out-link" class="menu-item menu-type-link">' . $link . '</li>';
}

add_filter('wp_nav_menu_items', 'add_login_out_item_to_menu', 50, 2);
//Add login/logout link to naviagation menu

//add menu
add_action('admin_menu', 'register_my_custom_menu_page');

//add style
function add_styles() {
	//var_dump(plugins_url('css/xuanqi.css', __FILE__));
	wp_register_style('plugin_stylesheet', plugins_url('css/xuanqi.css', __FILE__));
	wp_enqueue_style('plugin_stylesheet');
	wp_register_style('date_stylesheet', plugins_url('css/datepicker.css', __FILE__));
	wp_enqueue_style('date_stylesheet');

	wp_register_style('font_awesome', plugins_url('css/font-awesome.min.css', __FILE__));
	wp_enqueue_style('font_awesome');

}

add_action('init', 'add_styles');

//add js
function add_scripts() {
	wp_enqueue_script('angularjs', plugins_url('js/angular.min.js', __FILE__));
	wp_enqueue_script('datejs', plugins_url('js/zlDate.js', __FILE__));
	wp_enqueue_script('cQuery_110421', plugins_url('js/cQuery_110421.js', __FILE__));
	wp_enqueue_script('calendar', plugins_url('js/calendar.js', __FILE__));
	wp_register_script('plugin_script', plugins_url('js/xuanqi.js', __FILE__), array('jquery'), '1.0', true);
	wp_enqueue_script('plugin_script');
}

add_action('init', 'add_scripts');

//产品配置代码
function register_my_custom_menu_page() {

	add_menu_page('常规配置', '常规配置', 'manage_options', 'xuanqi_common_config', 'xuanqi_common_config_callback', '', 6);
	//product config
	add_menu_page('产品配置', '产品配置', 'manage_options', 'xuanqi_products_config', 'xuanqi_products_config_callback', '', 7);
	add_submenu_page('xuanqi_products_config', '修改产品', '修改产品', 'manage_options', 'xuanqi_add_product', 'xuanqi_add_product_callback');

	//hotel config
	add_menu_page('酒店特殊日期价格配置', '酒店特殊日期价格配置', 'manage_options', 'xuanqi_hotel_config', 'xuanqi_hotel_config_callback', '', 7);
	add_submenu_page('xuanqi_hotel_config', '新增特殊日期价格', '新增特殊日期价格', 'manage_options', 'xuanqi_add_hotel', 'xuanqi_add_hotel_callback');

	//airport config
	add_menu_page('出发机场配置', '出发机场配置', 'manage_options', 'xuanqi_airport_config', 'xuanqi_airport_config_callback', '', 8);
	add_submenu_page('xuanqi_airport_config', '新增出发机场', '新增出发机场', 'manage_options', 'xuanqi_add_airport', 'xuanqi_add_airport_callback');

	add_menu_page('订单查询', '订单查询', 'manage_options', 'xuanqi_order_config', 'xuanqi_order_config_callback', '', 9);

}

/****************************************************常规配置************************************************/
function xuanqi_common_config_callback() {
	/*判断是否是修改，如果是修改需要往控件中填值*/
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {
		if (isset($_POST["hotel_weekend_price"]) && $_POST["hotel_weekend_price"] != "") {
			update_option("hotel_weekend_price", $_POST["hotel_weekend_price"]);
		}
		if (isset($_POST["hotel_weekday_price"]) && $_POST["hotel_weekday_price"] != "") {
			update_option("hotel_weekday_price", $_POST["hotel_weekday_price"]);
		}
		if (isset($_POST["product_price"]) && $_POST["product_price"] != "") {
			update_option("product_price", $_POST["product_price"]);
		}
		if (isset($_POST["product_dealer_price"]) && $_POST["product_dealer_price"] != "") {
			update_option("product_dealer_price", $_POST["product_dealer_price"]);
		}
		if (isset($_POST["product_direct_price"]) && $_POST["product_direct_price"] != "") {
			update_option("product_direct_price", $_POST["product_direct_price"]);
		}
		$url = get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_common_config";
		?>
<div class="xqform">
	<form action="<?php echo $url;?>" method="post" name="updateForm">
		<table align="center">
		    <tr>
		        <td>
		            输入酒店周五周六的价格：
		            <br>
		            <input class="regular-text" type="text" value="<?php echo get_option('hotel_weekend_price');?>" name="hotel_weekend_price" pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            输入酒店周一至周四的价格：
		            <br>
		            <input class="regular-text" type="text" value="<?php echo get_option('hotel_weekday_price');?>" name="hotel_weekday_price" pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            输入产品价格：
		            <br>
		            <input class="regular-text" type="text" value="<?php echo get_option('product_price');?>" name="product_price" pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            输入经销商产品价格：
		            <br>
		            <input class="regular-text" type="text" value="<?php echo get_option('product_dealer_price');?>" name="product_dealer_price" pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            输入直销商产品价格：
		            <br>
		            <input class="regular-text" type="text" value="<?php echo get_option('product_direct_price');?>" name="product_direct_price" pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<button type="submit">更新</button>
		         </td>
		    </tr>
		</table>
	</form>
</div>
<?php
}
}
/****************************************************常规配置************************************************/

/****************************************************产品配置************************************************/

function xuanqi_update_product() {
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {

		//var_dump($_POST);

		if (isset($_POST["product_price"]) && isset($_POST["product_id"]) && isset($_POST["product_dealer_price"]) && isset($_POST["product_direct_price"]) && isset($_POST["product_description"])) {

			if ("" == trim($_POST["product_price"])) {
				echo "<font color='red'>产品价格不能为空</font>";
				return;
			}

			if ("" == trim($_POST["product_dealer_price"])) {
				echo "<font color='red'>经销商产品价格不能为空</font>";
				return;
			}

			if ("" == trim($_POST["product_description"])) {
				echo "<font color='red'>产品描述不能为空</font>";
				return;
			}

			global $wpdb;
			$product_id = trim($_POST["product_id"]);
			$product_name = trim($_POST["product_name"]);
			$product_price = trim($_POST["product_price"]);
			$product_dealer_price = trim($_POST["product_dealer_price"]);
			$product_direct_price = trim($_POST["product_direct_price"]);
			$product_description = trim($_POST["product_description"]);

			$sql = "UPDATE `xq_products` SET `product_price`=$product_price,`product_dealer_price`=$product_dealer_price,`product_direct_price`=$product_direct_price,`product_description`='$product_description' WHERE ID=$product_id";
			//var_dump($sql);
			$result = $wpdb->query($sql);
			//var_dump($result);
			if (0 < $result) {
				//echo "Success! Insert " . $result . " rows";
			} else {
				echo "<font color='red'>数据更新错误，信息为："+$result+"</font>";
			}

		}
	}
}

function xuanqi_products_config_callback() {

	?>
<div ng-app="showProductApp" ng-controller="showProductCtrl" class="xqgrid">

<?php

	if (isset($_GET["method"]) && "" != trim($_GET["method"])) {
		if ("add" == trim($_GET["method"])) {
			xuanqi_save_product();
		} else if ("update" == trim($_GET["method"])) {
			xuanqi_update_product();
		}
	}

	?>

	<button ng-click="updateProduct()">修改</button>
	<br/>
	<br/>
	<table>
		<th style="width:10px" >
			<input type="checkbox" onclick="selectAll(this)"></input>
		</th>
        <th>产品名称</th>
        <th>产品价格（元）</th>
        <th>经销商产品价格（元）</th>
        <th>直销商产品价格（元）</th>
        <tr ng-repeat="x in names">
        	<td><input id="{{x.product_id}}" type="checkbox" name="xq_checkbox"></input></td>
            <td ng-bind="x.product_name"></td>
            <td ng-bind="x.product_price"></td>
            <td ng-bind="x.product_dealer_price"></td>
            <td ng-bind="x.product_direct_price"></td>
        </tr>
    </table>
</div>
<script>
var app = angular.module('showProductApp', []);
app.controller('showProductCtrl', function($scope, $http) {
    $http.get('<?php echo get_bloginfo('wpurl') . "/show-product";?>').success(function(response) {
        $scope.names = response.records;
    });

    $scope.updateProduct = function() {
	    var ids = "";
	    var count = 0;
	    var checkBoxs = jQuery('input:checkbox[name=xq_checkbox]:checked');
	    var checkBoxsLength = checkBoxs.length;
	    if (checkBoxsLength == 0) {
	        alert("请选择要修改的记录");
	        return;
	    }
	    if (checkBoxsLength > 1) {
	        alert("无法同时修改多条记录");
	        return;
	    }
	    window.location.href='<?php echo get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_add_product&id=";?>' + checkBoxs[0].id;
    }
});
</script>
<?php

}

function xuanqi_add_product_callback() {

	/*判断是否是修改，如果是修改需要往控件中填值*/
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {

		//var_dump($_POST);

		if (isset($_GET["id"]) && "" != trim($_GET["id"])) {

			global $wpdb;

			$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_direct_price`, `product_description` FROM `xq_products` WHERE ID=" . trim($_GET["id"]));
			//var_dump($productArray);
		}
	}

	$url = get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_products_config&method=";
	$url .= isset($productArray) ? "update" : "add";
	echo "<div class=\"xqform\">";
	echo "<form action=\"$url\" method=\"post\" name=\"addProductForm\">";
	?>

<table align="center">
    <tr>
        <td>
            输入产品价格：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($productArray) ? $productArray[0]->product_price : '';?>" name="product_price" placeholder="请输入产品价格" pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
        </td>
    </tr>
    <tr>
        <td>
            输入经销商产品价格：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($productArray) ? $productArray[0]->product_dealer_price : '';?>" name="product_dealer_price" placeholder="请输入经销商产品价格" pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
        </td>
    </tr>
    <tr>
        <td>
            输入直销商产品价格：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($productArray) ? $productArray[0]->product_direct_price : '';?>" name="product_direct_price" placeholder="请输入直销商产品价格" pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
        </td>
    </tr>
    <tr>
        <td>
            输入产品介绍：
            <?php wp_editor(isset($productArray) ? $productArray[0]->product_description : "请输入产品描述", "product_description");?>
        </td>
    </tr>
    <tr>
        <td>
        	<button type="submit">保存产品</button>
        	<input type="hidden" value="<?php echo isset($productArray) ? $productArray[0]->ID : '';?>" name="product_id"></input>
         </td>
    </tr>
</table>
</form>
</div>
<?php

}
/****************************************************产品配置************************************************/

/****************************************************酒店配置************************************************/

function xuanqi_save_hotel() {
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {

		//var_dump($_POST);

		if (isset($_POST["date"]) && isset($_POST["price"])) {

			if ("" == trim($_POST["date"])) {
				echo "<font color='red'>日期不能为空</font>";
				return;
			}

			if ("" == trim($_POST["price"])) {
				echo "<font color='red'>酒店价格不能为空</font>";
				return;
			}

			global $wpdb;
			$date = trim($_POST["date"]);
			$price = trim($_POST["price"]);

			$count = $wpdb->get_var("SELECT COUNT(*) FROM `xq_hotels` WHERE `date` = '$date'");
			//var_dump($count);
			if (intval($count) == 0) {
				$sql = "INSERT INTO `xq_hotels`(`date`, `price`) VALUES ('$date',$price)";

				//var_dump($sql);
				$result = $wpdb->query($sql);
				//var_dump($result);
				if (0 < $result) {
					//echo "<font color='blue'>录入数据成功</font>";
				} else {
					echo "<font color='red'>数据插入错误，信息为："+$result+"</font>";
				}
			} else {
				echo "<font color='red'>录入重复数据</font>";
			}

		}
	}
}

function xuanqi_update_hotel() {
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {

		//var_dump($_POST);

		if (isset($_POST["ID"]) && isset($_POST["price"])) {

			if ("" == trim($_POST["price"])) {
				echo "<font color='red'>酒店价格不能为空</font>";
				return;
			}

			global $wpdb;
			$ID = trim($_POST["ID"]);
			$price = trim($_POST["price"]);

			$sql = "UPDATE `xq_hotels` SET `price`=$price WHERE ID=$ID";
			//var_dump($sql);
			$result = $wpdb->query($sql);
			//var_dump($result);
			if (0 < $result) {
				//echo "<font color='blue'>更新数据成功</font>";
			} else {
				echo "<font color='red'>数据更新错误，信息为："+$result+"</font>";
			}
		}
	}
}

function xuanqi_hotel_config_callback() {

	?>
<div ng-app="showApp" ng-controller="showCtrl" class="xqgrid">
	<div style="margin-left: 10px;" id="hintDiv">
<?php

	if (isset($_GET["method"]) && "" != trim($_GET["method"])) {
		if ("add" == trim($_GET["method"])) {
			xuanqi_save_hotel();
		} else if ("update" == trim($_GET["method"])) {
			xuanqi_update_hotel();
		}
	}

	?>
	</div>
	<button onclick="window.location.href='<?php echo get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_add_hotel";?>'">新增</button>
	<button ng-click="delete()">删除</button>
	<button ng-click="update()">修改</button>
	<input type="text" id="search_date" placeholder="输入日期查询"></input>
	<input type="text" id="search_price" placeholder="输入价格查询"></input>
	<button ng-click="search()">查询</button>
	<div style="float: right">
		<button ng-click="firstPage()" title="跳转到第一页"><<</button>
		<button ng-click="prevPage()" title="跳转到上一页"><</button>
		<button ng-click="nextPage()" title="跳转到下一页">></button>
		<button ng-click="lastPage()" title="跳转到最后一页">>></button>
		<label>共<span ng-bind="count"></span>条数据，共<span ng-bind="pages"></span>页<input title="当前页面" type="text" name="page_num" id="page_num" value="1" size="1"></input></label>
		<button ng-click="gotoPage()" title="跳转到任意页">跳转</button>
	</div>
	<table>
		<th style="width:10px" >
			<input type="checkbox" onclick="selectAll(this)"></input>
		</th>
        <th>日期</th>
        <th>价格（元）</th>
        <tr ng-repeat="x in names">
        	<td><input id="{{x.ID}}" type="checkbox" name="xq_checkbox"></input></td>
            <td ng-bind="x.date"></td>
            <td ng-bind="x.price"></td>
        </tr>
    </table>
</div>
<script>
var app = angular.module('showApp', []);
app.controller('showCtrl', function($scope, $http) {

	var refresh = function(page_num) {
	    var url = '<?php echo get_bloginfo('wpurl') . "/show-hotel";?>?';
	    url += 'page_num=';
	    url += page_num;

	    var hotel_date = jQuery('#search_date').val();
	    if (hotel_date != "") {
	        url += '&hotel_date=';
	        url += hotel_date;
	    }
	    var hotel_price = jQuery('#search_price').val();
	    if (hotel_price != "") {
	        url += '&hotel_price=';
	        url += hotel_price;
	    }

	    $http.get(url).success(function(response) {
	        $scope.names = response.records;
	        $scope.count = response.count;
	        $scope.pages = Math.ceil(response.count / 20);
	        jQuery('#page_num').val(page_num);
	    });
	}

	refresh(1);

    $("#search_date").regMod("calendar", "6.0", {
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

    jQuery('#hintDiv').hide(1000);


    //functions
    $scope.delete = function() {
	    var ids = "";
	    var count = 0;
	    var checkBoxs = jQuery('input:checkbox[name=xq_checkbox]:checked');
	    var checkBoxsLength = checkBoxs.length;
	    if (checkBoxsLength == 0) {
	        alert("请选择要删除的记录");
	        return;
	    }

	    if (confirm("确认要删除吗？")) {
	        checkBoxs.each(function() {
	            //alert(jQuery(this).attr('id'));
	            //jQuery(this).prop('checked', obj.checked);
	            count++;
	            if (count < checkBoxsLength) {
	                ids += jQuery(this).attr('id') + ",";
	            } else if (count == checkBoxsLength) {
	                ids += jQuery(this).attr('id');
	            }

	        });
	        //alert(ids);
	        var Obj = {
	            ids: ids
	        }
	        jQuery.post('<?php echo get_bloginfo('wpurl') . "/delete-hotel";?>', Obj,
	            function(data) {
	                alert(data);

			        refresh(1);

	            });
	    }
    }

    $scope.update = function() {
	    var ids = "";
	    var count = 0;
	    var checkBoxs = jQuery('input:checkbox[name=xq_checkbox]:checked');
	    var checkBoxsLength = checkBoxs.length;
	    if (checkBoxsLength == 0) {
	        alert("请选择要修改的记录");
	        return;
	    }
	    if (checkBoxsLength > 1) {
	        alert("无法同时修改多条记录");
	        return;
	    }
	    window.location.href='<?php echo get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_add_hotel&id=";?>' + checkBoxs[0].id;
    }


    $scope.search = function() {
    	refresh(1);
    }


    $scope.prevPage = function() {

    	if (parseInt(jQuery('#page_num').val()) > 1) {
			var page_num = parseInt(jQuery('#page_num').val()) - 1;
			refresh(page_num);
    	}
    }

    $scope.nextPage = function() {

    	if (parseInt(jQuery('#page_num').val()) < parseInt($scope.pages)) {
			var page_num = parseInt(jQuery('#page_num').val()) + 1;
			refresh(page_num);
    	}
    }

    $scope.firstPage = function() {

		refresh(1);
    }

    $scope.lastPage = function() {

		var page_num = $scope.pages;
		refresh(page_num);
    }

    $scope.gotoPage = function() {

		var page_num = jQuery('#page_num').val();
		refresh(page_num);
    }

});
</script>
<?php

}

function xuanqi_add_hotel_callback() {

	/*判断是否是修改，如果是修改需要往控件中填值*/
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {

		//var_dump($_POST);

		if (isset($_GET["id"]) && "" != trim($_GET["id"])) {

			global $wpdb;

			$array = $wpdb->get_results("SELECT `ID`, `date`, `price` FROM `xq_hotels` WHERE ID=" . trim($_GET["id"]));
			//var_dump($productArray);
		}
	}

	$url = get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_hotel_config&method=";
	$url .= isset($array) ? "update" : "add";
	echo "<div class=\"xqform\">";
	echo "<form action=\"$url\" method=\"post\" name=\"addForm\">";
	?>

<table align="center">
	<?php if (!isset($array)) {?>
    <tr>
        <td>
            输入日期：
            <br>
            <input class="regular-text" type="text" value="" id="date" name="date" required></input>
        </td>
    </tr>
    <?php }?>
    <tr>
        <td>
            输入价格：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($array) ? $array[0]->price : '';?>" name="price" placeholder="请输入价格"  pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
        </td>
    </tr>
    <tr>
        <td>
        	<button type="submit">保存酒店信息</button>
        	<input type="hidden" name="ID" value="<?php echo isset($array) ? $array[0]->ID : '';?>"></input>
         </td>
    </tr>
</table>
</form>
</div>
<script type="text/javascript">
    $("#date").regMod("calendar", "6.0", {
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

/****************************************************酒店配置************************************************/

/****************************************************航站配置************************************************/

function xuanqi_save_airport() {
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {

		//var_dump($_POST);

		if (isset($_POST["airport_icao"]) && isset($_POST["airport_iata"]) && isset($_POST["bad_date"])
			&& isset($_POST["airport_name"]) && isset($_POST["city_code"]) && isset($_POST["city_name"])
			&& isset($_POST["province_code"]) && isset($_POST["province_name"]) && isset($_POST["hongkong_price"])) {

			if ("" == trim($_POST["airport_icao"])) {
				echo "<font color='red'>机场ICAO码不能为空</font>";
				return;
			}

			if ("" == trim($_POST["airport_iata"])) {
				echo "<font color='red'>机场IATA码不能为空</font>";
				return;
			}

			if ("" == trim($_POST["airport_name"])) {
				echo "<font color='red'>机场名称不能为空</font>";
				return;
			}

			if ("" == trim($_POST["city_code"])) {
				echo "<font color='red'>城市拼音不能为空</font>";
				return;
			}

			if ("" == trim($_POST["city_name"])) {
				echo "<font color='red'>城市名称不能为空</font>";
				return;
			}

			if ("" == trim($_POST["province_code"])) {
				echo "<font color='red'>省市拼音不能为空</font>";
				return;
			}

			if ("" == trim($_POST["province_name"])) {
				echo "<font color='red'>省市名称不能为空</font>";
				return;
			}

			if ("" == trim($_POST["hongkong_price"])) {
				echo "<font color='red'>到达香港的价格不能为空</font>";
				return;
			}

			global $wpdb;
			$airport_icao = trim($_POST["airport_icao"]);
			$airport_iata = trim($_POST["airport_iata"]);
			$airport_code = $airport_icao . "|" . $airport_iata;
			$airport_name = trim($_POST["airport_name"]);
			$city_code = trim($_POST["city_code"]);
			$city_name = trim($_POST["city_name"]);
			$province_code = trim($_POST["province_code"]);
			$province_name = trim($_POST["province_name"]);
			$hongkong_price = trim($_POST["hongkong_price"]);
			$bad_date = trim($_POST["bad_date"]);

			$count = $wpdb->get_var("SELECT COUNT(*) FROM `xq_airports` WHERE `airport_code` = '$airport_code'");
			//var_dump($count);
			if (intval($count) == 0) {
				$sql = "INSERT INTO `xq_airports`(`airport_icao`, `airport_iata`, `airport_code`, `airport_name`, `city_code`, `city_name`, `province_code`, `province_name`, `hongkong_price`, `bad_date`)
				VALUES ('$airport_icao','$airport_iata','$airport_code','$airport_name','$city_code','$city_name','$province_code','$province_name', $hongkong_price, '$bad_date')";

				//var_dump($sql);
				$result = $wpdb->query($sql);
				//var_dump($result);
				if (0 < $result) {
					//echo "<font color='blue'>录入数据成功</font>";
				} else {
					echo "<font color='red'>数据插入错误，信息为："+$result+"</font>";
				}
			} else {
				echo "<font color='red'>录入重复数据</font>";
			}

		}
	}
}

function xuanqi_update_airport() {
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {

		//var_dump($_POST);

		if (isset($_POST["airport_code"]) && isset($_POST["airport_name"]) && isset($_POST["city_code"]) && isset($_POST["bad_date"])
			&& isset($_POST["city_name"]) && isset($_POST["province_code"]) && isset($_POST["province_name"]) && isset($_POST["hongkong_price"])) {

			if ("" == trim($_POST["airport_code"])) {
				echo "<font color='red'>机场代号不能为空</font>";
				return;
			}

			if ("" == trim($_POST["airport_name"])) {
				echo "<font color='red'>机场名称不能为空</font>";
				return;
			}

			if ("" == trim($_POST["city_code"])) {
				echo "<font color='red'>城市拼音不能为空</font>";
				return;
			}

			if ("" == trim($_POST["city_name"])) {
				echo "<font color='red'>城市名称不能为空</font>";
				return;
			}

			if ("" == trim($_POST["province_code"])) {
				echo "<font color='red'>省市拼音不能为空</font>";
				return;
			}

			if ("" == trim($_POST["province_name"])) {
				echo "<font color='red'>省市名称不能为空</font>";
				return;
			}

			if ("" == trim($_POST["hongkong_price"])) {
				echo "<font color='red'>到达香港的价格不能为空</font>";
				return;
			}

			global $wpdb;
			$airport_code = trim($_POST["airport_code"]);
			$airport_name = trim($_POST["airport_name"]);
			$city_code = trim($_POST["city_code"]);
			$city_name = trim($_POST["city_name"]);
			$province_code = trim($_POST["province_code"]);
			$province_name = trim($_POST["province_name"]);
			$hongkong_price = trim($_POST["hongkong_price"]);
			$bad_date = trim($_POST["bad_date"]);

			$sql = "UPDATE `xq_airports` SET `airport_name`='$airport_name',`city_code`='$city_code',`city_name`='$city_name',`province_code`='$province_code',`province_name`='$province_name',`hongkong_price`=$hongkong_price,`bad_date`='$bad_date' WHERE `airport_code` = '$airport_code'";
			//var_dump($sql);
			$result = $wpdb->query($sql);
			//var_dump($result);
			if (0 < $result) {
				//echo "<font color='blue'>更新数据成功</font>";
			} else {
				echo "<font color='red'>数据更新错误，信息为："+$result+"</font>";
			}
		}
	}
}

function xuanqi_airport_config_callback() {

	?>
<div ng-app="showApp" ng-controller="showCtrl" class="xqgrid">
	<div style="margin-left: 10px;" id="hintDiv">
<?php

	if (isset($_GET["method"]) && "" != trim($_GET["method"])) {
		if ("add" == trim($_GET["method"])) {
			xuanqi_save_airport();
		} else if ("update" == trim($_GET["method"])) {
			xuanqi_update_airport();
		}
	}

	?>
	</div>
	<button onclick="window.location.href='<?php echo get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_add_airport";?>'">新增</button>
	<button ng-click="delete()">删除</button>
	<button ng-click="update()">修改</button>
	<input type="text" id="search_airport_name" placeholder="输入机场名称查询"></input>
	<button ng-click="search()">查询</button>
	<div style="float: right">
		<button ng-click="firstPage()" title="跳转到第一页"><<</button>
		<button ng-click="prevPage()" title="跳转到上一页"><</button>
		<button ng-click="nextPage()" title="跳转到下一页">></button>
		<button ng-click="lastPage()" title="跳转到最后一页">>></button>
		<label>共<span ng-bind="count"></span>条数据，共<span ng-bind="pages"></span>页<input title="当前页面" type="text" name="page_num" id="page_num" value="1" size="1"></input></label>
		<button ng-click="gotoPage()" title="跳转到任意页">跳转</button>
	</div>
	<table>
		<th style="width:10px" >
			<input type="checkbox" onclick="selectAll(this)"></input>
		</th>
        <th>航站名称</th>
        <th>城市名称</th>
        <th>省市名称</th>
        <th>香港往返机票价格</th>
        <th>不可选的日期</th>
        <tr ng-repeat="x in names">
        	<td><input id="{{x.airport_code}}" type="checkbox" name="xq_checkbox"></input></td>
            <td ng-bind="x.airport_name"></td>
            <td ng-bind="x.city_name"></td>
            <td ng-bind="x.province_name"></td>
            <td ng-bind="x.hongkong_price"></td>
            <td ng-bind="x.bad_date"></td>
        </tr>
    </table>
</div>
<script>
var app = angular.module('showApp', []);
app.controller('showCtrl', function($scope, $http) {

	var refresh = function(page_num) {
	    var url = '<?php echo get_bloginfo('wpurl') . "/show-airport";?>?';
	    url += 'page_num=';
	    url += page_num;

	    var airport_name = jQuery('#search_airport_name').val();
	    if (airport_name != "") {
	        url += '&airport_name=';
	        url += airport_name;
	    }

	    $http.get(url).success(function(response) {
	        $scope.names = response.records;
	        $scope.count = response.count;
	        $scope.pages = Math.ceil(response.count / 20);
	        jQuery('#page_num').val(page_num);
	    });
	}

	refresh(1);

    //jQuery('#hintDiv').hide(1000);


    //functions
    $scope.delete = function() {
	    var ids = "";
	    var count = 0;
	    var checkBoxs = jQuery('input:checkbox[name=xq_checkbox]:checked');
	    var checkBoxsLength = checkBoxs.length;
	    if (checkBoxsLength == 0) {
	        alert("请选择要删除的记录");
	        return;
	    }

	    if (confirm("确认要删除吗？")) {
	        checkBoxs.each(function() {
	            //alert(jQuery(this).attr('id'));
	            //jQuery(this).prop('checked', obj.checked);
	            count++;
	            if (count < checkBoxsLength) {
	                ids += jQuery(this).attr('id') + ",";
	            } else if (count == checkBoxsLength) {
	                ids += jQuery(this).attr('id');
	            }

	        });
	        //alert(ids);
	        var Obj = {
	            ids: ids
	        }
	        jQuery.post('<?php echo get_bloginfo('wpurl') . "/delete-airport";?>', Obj,
	            function(data) {
	                alert(data);

			        refresh(1);

	            });
	    }
    }

    $scope.update = function() {
	    var ids = "";
	    var count = 0;
	    var checkBoxs = jQuery('input:checkbox[name=xq_checkbox]:checked');
	    var checkBoxsLength = checkBoxs.length;
	    if (checkBoxsLength == 0) {
	        alert("请选择要修改的记录");
	        return;
	    }
	    if (checkBoxsLength > 1) {
	        alert("无法同时修改多条记录");
	        return;
	    }
	    window.location.href='<?php echo get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_add_airport&id=";?>' + checkBoxs[0].id;
    }


    $scope.search = function() {
    	refresh(1);
    }


    $scope.prevPage = function() {

    	if (parseInt(jQuery('#page_num').val()) > 1) {
			var page_num = parseInt(jQuery('#page_num').val()) - 1;
			refresh(page_num);
    	}
    }

    $scope.nextPage = function() {

    	if (parseInt(jQuery('#page_num').val()) < parseInt($scope.pages)) {
			var page_num = parseInt(jQuery('#page_num').val()) + 1;
			refresh(page_num);
    	}
    }

    $scope.firstPage = function() {

		refresh(1);
    }

    $scope.lastPage = function() {

		var page_num = $scope.pages;
		refresh(page_num);
    }

    $scope.gotoPage = function() {

		var page_num = jQuery('#page_num').val();
		refresh(page_num);
    }

});
</script>
<?php

}

function xuanqi_add_airport_callback() {

	/*判断是否是修改，如果是修改需要往控件中填值*/
	$current_user = wp_get_current_user();
	$wpurl = get_bloginfo('wpurl');

	if (0 == $current_user->ID) {

		echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
		return;

	} else {

		//var_dump($_POST);

		if (isset($_GET["id"]) && "" != trim($_GET["id"])) {

			global $wpdb;
			$sql = "SELECT `airport_icao`, `airport_iata`, `airport_code`, `airport_name`, `city_code`, `city_name`, `province_code`, `province_name`, `hongkong_price`,`bad_date` FROM xq_airports WHERE airport_code='" . trim($_GET["id"]) . "'";
			//var_dump($sql);
			$array = $wpdb->get_results($sql);
		}
	}

	$url = get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_airport_config&method=";
	$url .= isset($array) ? "update" : "add";
	echo "<div class=\"xqform\">";
	echo "<form action=\"$url\" method=\"post\" name=\"addForm\">";
	?>

<table align="center">
	<?php if (!isset($array)) {?>
    <tr>
        <td>
            输入机场ICAO码：
            <br>
            <input class="regular-text" type="text" value="" id="airport_icao" name="airport_icao" required></input>
        </td>
    </tr>
    <tr>
        <td>
            输入机场IATA码：
            <br>
            <input class="regular-text" type="text" value="" id="airport_iata" name="airport_iata" required></input>
        </td>
    </tr>
    <?php }?>
    <tr>
        <td>
            输入机场名称：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($array) ? $array[0]->airport_name : '';?>" id="airport_name" name="airport_name" required></input>
        </td>
    </tr>
    <tr>
        <td>
            输入城市拼音：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($array) ? $array[0]->city_code : '';?>" id="city_code" name="city_code" required></input>
        </td>
    </tr>
    <tr>
        <td>
            输入城市名称：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($array) ? $array[0]->city_name : '';?>" id="city_name" name="city_name" required></input>
        </td>
    </tr>
    <tr>
        <td>
            输入省市拼音：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($array) ? $array[0]->province_code : '';?>" id="province_code" name="province_code" required></input>
        </td>
    </tr>
    <tr>
        <td>
            输入省市名称：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($array) ? $array[0]->province_name : '';?>" id="province_name" name="province_name" required></input>
        </td>
    </tr>
    <tr>
        <td>
            输入到香港的往返机票价格：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($array) ? $array[0]->hongkong_price : '';?>" name="hongkong_price"  pattern="^[1-9]\d*$" title="请输入不带小数点的正数" required>（元）</input>
        </td>
    </tr>
    <tr>
    <tr>
        <td>
            选择不可选的日期，点击按钮添加：
            <br>
            <input class="regular-text" type="text" id="choose_bad_date"></input>
        	<br>
        	<input type="button" value="添加不可选日期" onclick="addBadDates()"></input>
        </td>
    </tr>
    <tr>
        <td>
        	<div id="badDatesDiv"></div>
        </td>
    </tr>
    <tr>
        <td>
        	<button type="submit">保存出发机场信息</button>
        	<input type="hidden" name="airport_code" value="<?php echo isset($array) ? $array[0]->airport_code : '';?>"></input>
        	<input type="hidden" id="bad_date" name="bad_date" value="<?php echo isset($array) ? $array[0]->bad_date : '';?>"></input>
         </td>
    </tr>
</table>
</form>
<script type="text/javascript">
	if ("" != jQuery("#bad_date").val()) {
		var bad_dates = jQuery("#bad_date").val().split(',');
	    for (var i = bad_dates.length - 1; i >= 0; i--) {
		    var badDatesDiv = document.getElementById("badDatesDiv");
		    var deleteFunction = "deleteBadDateDiv('" + bad_dates[i] + "')";
		    var objectStr = "<div id=" + bad_dates[i] + "><label>" + bad_dates[i] + "<input type='button' value='删除' onclick=" + deleteFunction + "></input></label></div>";
		    badDatesDiv.innerHTML += objectStr;
	    }
	}

    $("#choose_bad_date").regMod("calendar", "6.0", {
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

/****************************************************航站配置************************************************/

/****************************************************订单查询************************************************/
function xuanqi_order_config_callback() {

	?>
<div ng-app="showApp" ng-controller="showCtrl" class="xqgrid">
	<input type="text" id="search_save_time" placeholder="输入订单日期查询"></input>
	<button ng-click="search()">查询</button>
	<div style="float: right">
		<button ng-click="firstPage()" title="跳转到第一页"><<</button>
		<button ng-click="prevPage()" title="跳转到上一页"><</button>
		<button ng-click="nextPage()" title="跳转到下一页">></button>
		<button ng-click="lastPage()" title="跳转到最后一页">>></button>
		<label>共<span ng-bind="count"></span>条数据，共<span ng-bind="pages"></span>页<input title="当前页面" type="text" name="page_num" id="page_num" value="1" size="1"></input></label>
		<button ng-click="gotoPage()" title="跳转到任意页">跳转</button>
	</div>
	<table>
        <th>用户名</th>
        <th>产品名称</th>
        <th>产品价格</th>
        <th>是否乘坐飞机</th>
        <th>出发机场</th>
        <th>到达机场</th>
        <th>出发日期</th>
        <th>返回日期</th>
        <th>往返机票价格</th>
        <th>是否入住酒店</th>
        <th>入住日期</th>
        <th>退房日期</th>
        <th>酒店价格</th>
        <th>总价格</th>
        <th>订单状态</th>
        <th>生成时间</th>
        <tr ng-repeat="x in names">
            <td ng-bind="x.user_login"></td>
            <td ng-bind="x.product_name"></td>
            <td ng-bind="x.product_price"></td>
            <td ng-bind="x.if_airplane"></td>
            <td ng-bind="x.start_airport_name"></td>
            <td ng-bind="x.arrive_airport_name"></td>
            <td ng-bind="x.start_date"></td>
            <td ng-bind="x.back_date"></td>
            <td ng-bind="x.airline_price"></td>
            <td ng-bind="x.if_hotel"></td>
            <td ng-bind="x.in_date"></td>
            <td ng-bind="x.out_date"></td>
            <td ng-bind="x.hotel_price"></td>
            <td ng-bind="x.total_price"></td>
            <td ng-bind="x.order_status"></td>
            <td ng-bind="x.save_time"></td>
        </tr>
    </table>
</div>
<script>
var app = angular.module('showApp', []);
app.controller('showCtrl', function($scope, $http) {

	var refresh = function(page_num) {
	    var url = '<?php echo get_bloginfo('wpurl') . "/show-order";?>?';
	    url += 'page_num=';
	    url += page_num;

	    var search_save_time = jQuery('#search_save_time').val();
	    if (search_save_time != "") {
	        url += '&save_time=';
	        url += search_save_time;
	    }

	    $http.get(url).success(function(response) {
	        $scope.names = response.records;
	        $scope.count = response.count;
	        $scope.pages = Math.ceil(response.count / 20);
	        jQuery('#page_num').val(page_num);
	    });
	}

	refresh(1);

    $("#search_save_time").regMod("calendar", "6.0", {
        options: {
            autoShow: !1,
            showWeek: !0,
            showAll: !0,
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

    $scope.search = function() {
    	refresh(1);
    }


    $scope.prevPage = function() {

    	if (parseInt(jQuery('#page_num').val()) > 1) {
			var page_num = parseInt(jQuery('#page_num').val()) - 1;
			refresh(page_num);
    	}
    }

    $scope.nextPage = function() {

    	if (parseInt(jQuery('#page_num').val()) < parseInt($scope.pages)) {
			var page_num = parseInt(jQuery('#page_num').val()) + 1;
			refresh(page_num);
    	}
    }

    $scope.firstPage = function() {

		refresh(1);
    }

    $scope.lastPage = function() {

		var page_num = $scope.pages;
		refresh(page_num);
    }

    $scope.gotoPage = function() {

		var page_num = jQuery('#page_num').val();
		refresh(page_num);
    }

});
</script>
<?php

}

/****************************************************订单查询************************************************/

?>