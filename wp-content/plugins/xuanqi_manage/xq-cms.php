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
		$link = '<a href="' . wp_login_url($redirect) . '" title="' . __('Login') . '">' . "登录" . '</a>';
	}

	return $items .= '<li id="log-in-out-link" class="menu-item menu-type-link">' . $link . '</li>';
}

add_filter('wp_nav_menu_items', 'add_login_out_item_to_menu', 50, 2);
//Add login/logout link to naviagation menu

//用户资料界面加入手机号
function add_custom_user_profile_fields($user) {

	?>
<table class="form-table">
<tr>
    <th>
        <label for="phone">手机号码</label>
    </th>
    <td>
        <input type="text" name="phone" id="phone" pattern="[0-9]{11}" title="请输入11位手机号码" value="<?php echo get_usermeta($user->ID, 'phone');?>" class="regular-text" />
    </td>
</tr>
</table>
<?php }
function save_custom_user_profile_fields($user_id) {
	if (!current_user_can('edit_user', $user_id)) {
		return FALSE;
	}

	update_usermeta($user_id, 'phone', $_POST['phone']);
}
add_action('show_user_profile', 'add_custom_user_profile_fields'); //钩子作用在show_user_profile
add_action('edit_user_profile', 'add_custom_user_profile_fields'); //钩子作用在edit_user_profile
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');
//用户资料界面加入手机号

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
	//product config
	add_menu_page('产品配置', '产品配置', 'manage_options', 'xuanqi_products_config', 'xuanqi_products_config_callback', '', 6);
	add_submenu_page('xuanqi_products_config', '修改产品', '修改产品', 'manage_options', 'xuanqi_add_product', 'xuanqi_add_product_callback');

	//airport config
	add_menu_page('酒店价格配置', '酒店价格配置', 'manage_options', 'xuanqi_hotels_config', 'xuanqi_hotels_config_callback', '', 7);
	add_submenu_page('xuanqi_hotels_config', '新增酒店日期价格', '新增酒店日期价格', 'manage_options', 'xuanqi_add_hotel', 'xuanqi_add_hotel_callback');

}

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
				echo "<font color='red'>产品价格不能为空</font><br><br>";
				return;
			}

			if ("" == trim($_POST["product_dealer_price"])) {
				echo "<font color='red'>经销商产品价格不能为空</font><br><br>";
				return;
			}

			if ("" == trim($_POST["product_description"])) {
				echo "<font color='red'>产品描述不能为空</font><br><br>";
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
				echo "<font color='red'>数据更新错误，信息为："+$result+"</font><br><br>";
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
            <td>{{ x.product_name }}</td>
            <td>{{ x.product_price }}</td>
            <td>{{ x.product_dealer_price }}</td>
            <td>{{ x.product_direct_price }}</td>
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
				echo "<font color='red'>日期不能为空</font><br><br>";
				return;
			}

			if ("" == trim($_POST["price"])) {
				echo "<font color='red'>酒店价格不能为空</font><br><br>";
				return;
			}

			global $wpdb;
			$date = trim($_POST["date"]);
			$price = trim($_POST["price"]);

			$sql = "INSERT INTO `xq_hotels`(`date`, `price`) VALUES ('$date',$price)";

			//var_dump($sql);
			$result = $wpdb->query($sql);
			//var_dump($result);
			if (0 < $result) {
				//echo "Success! Insert " . $result . " rows";
			} else {
				echo "<font color='red'>数据插入错误，信息为："+$result+"</font><br><br>";
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

		if (isset($_POST["ID"]) && isset($_POST["date"]) && isset($_POST["price"])) {

			if ("" == trim($_POST["date"])) {
				echo "<font color='red'>日期不能为空</font><br><br>";
				return;
			}

			if ("" == trim($_POST["price"])) {
				echo "<font color='red'>酒店价格不能为空</font><br><br>";
				return;
			}

			global $wpdb;
			$ID = trim($_POST["ID"]);
			$date = trim($_POST["date"]);
			$price = trim($_POST["price"]);

			$sql = "UPDATE `xq_hotels` SET `date`='$date',`price`=$price WHERE ID=$ID";
			//var_dump($sql);
			$result = $wpdb->query($sql);
			//var_dump($result);
			if (0 < $result) {
				//echo "Success! Insert " . $result . " rows";
			} else {
				echo "<font color='red'>数据更新错误，信息为："+$result+"</font><br><br>";
			}

		}
	}
}

function xuanqi_hotels_config_callback() {

	?>
<div ng-app="showApp" ng-controller="showCtrl" class="xqgrid">

<?php

	if (isset($_GET["method"]) && "" != trim($_GET["method"])) {
		if ("add" == trim($_GET["method"])) {
			xuanqi_save_hotel();
		} else if ("update" == trim($_GET["method"])) {
			xuanqi_update_hotel();
		}
	}

	?>
	<button onclick="window.location.href='<?php echo get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_add_hotel";?>'">新增</button>
	<button ng-click="delete()">删除</button>
	<button ng-click="update()">修改</button>
	<input type="text" id="search_date" placeholder="输入日期查询"></input>
	<button ng-click="search()">查询</button>
	<div style="float: right">
		<button ng-click="firstPage()" title="跳转到第一页"><<</button>
		<button ng-click="prevPage()" title="跳转到上一页"><</button>
		<button ng-click="nextPage()" title="跳转到下一页">></button>
		<button ng-click="lastPage()" title="跳转到最后一页">>></button>
		<input title="当前页面" type="text" name="page_num" id="page_num" value="1" size="1"></input>
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

	var page_num = jQuery('#page_num').val();
    var url = '<?php echo get_bloginfo('wpurl') . "/show-hotel";?>?';
    url += 'page_num=';
    url += page_num;
    $http.get(url).success(function(response) {
        $scope.names = response.records;
    });

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
	            } else if (count = checkBoxsLength) {
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
				    $http.get('<?php echo get_bloginfo('wpurl') . "/show-hotel";?>').success(function(response) {
				        $scope.names = response.records;
				    });
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

		var hotel_date = jQuery('#search_date').val();
        var url = '<?php echo get_bloginfo('wpurl') . "/show-hotel";?>?';
        url += 'hotel_date=';
        url += hotel_date;
	    $http.get(url).success(function(response) {
	        $scope.names = response.records;
	    });
    }

    $scope.prevPage = function() {

		var page_num = jQuery('#page_num').val() - 1;
	    var url = '<?php echo get_bloginfo('wpurl') . "/show-hotel";?>?';
	    url += 'page_num=';
	    url += page_num;
	    $http.get(url).success(function(response) {
	        $scope.names = response.records;
	        jQuery('#page_num').val(page_num);
	    });
    }


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

	$url = get_bloginfo('wpurl') . "/wp-admin/admin.php?page=xuanqi_hotels_config&method=";
	$url .= isset($array) ? "update" : "add";
	echo "<div class=\"xqform\">";
	echo "<form action=\"$url\" method=\"post\" name=\"addForm\">";
	?>

<table align="center">
    <tr>
        <td>
            输入日期：
            <br>
            <input class="regular-text" type="text" value="<?php echo isset($array) ? $array[0]->date : '';?>" id="date" name="date" required></input>
        </td>
    </tr>
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

?>