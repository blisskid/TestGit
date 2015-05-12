<?php

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
	wp_enqueue_script('angularjs', plugins_url('js/angular.min.js', __FILE__));
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
	?>
<div ng-app="showProductApp" ng-controller="showProductCtrl" class="xqgrid">
	<table>
        <th>产品名称</th>
        <th>产品价格（元）</th>
        <th>经销商产品价格（元）</th>
        <th>产品类别</th>
        <th>支付流程</th>
        <th>是否在首页显示</th>
        <th>产品描述</th>
        <tr ng-repeat="x in names">
            <td>{{ x.product_name }}</td>
            <td>{{ x.product_price }}</td>
            <td>{{ x.product_dealer_price }}</td>
            <td>{{ x.product_type }}</td>
            <td>{{ x.product_paytype }}</td>
            <td>{{ x.product_show }}</td>
            <td>{{ x.product_description }}</td>
        </tr>
    </table>
</div>
<script>
var app = angular.module('showProductApp', []);
app.controller('showProductCtrl', function($scope, $http) {
    $http.get('<?php echo get_bloginfo('wpurl') . "/show-product";?>').success(function(response) {
        $scope.names = response.records;
    });
});
</script>
<?php

}

function xuanqi_add_product_callback() {

	$url = get_bloginfo('wpurl') . "/save-product";
	echo "<div class=\"xqform\">";
	echo "<form ng-app=\"addProductApp\"  ng-controller=\"addProductCtrl\" name=\"addProductForm\" novalidate>";
	?>

<table align="center">
    <tr>
        <td>
        	<input type="hidden" id="product_id" name="product_id" value=""/>
        </td>
    </tr>
    <tr>
        <td>
            输入产品名称：
            <br>
            <input style="width:300px" type="text" value="" name="product_name" id="product_name" ng-model="product_name" required></input>
            <span style="color:red" ng-show="addProductForm.product_name.$dirty && addProductForm.product_name.$invalid">
				 		<span ng-show="addProductForm.product_name.$error.required">请输入产品名称.</span>
            </span>
        </td>
    </tr>
    <tr>
        <td>
            输入产品价格：
            <br>
            <input style="width:300px" type="number" value="" name="product_price" id="product_price" ng-model="product_price" required>（元）</input>
            <span style="color:red" ng-show="addProductForm.product_price.$dirty && addProductForm.product_price.$invalid">
				 		<span ng-show="addProductForm.product_price.$error.required">请输入产品价格.</span>
            <span ng-show="addProductForm.product_price.$error.number">产品价格需要为数字.</span>
            </span>
        </td>
    </tr>
    <tr>
        <td>
            输入经销商产品价格：
            <br>
            <input style="width:300px" type="number" value="" name="product_dealer_price" id="product_dealer_price" ng-model="product_dealer_price" required>（元）</input>
            <span style="color:red" ng-show="addProductForm.product_dealer_price.$dirty && addProductForm.product_dealer_price.$invalid">
				 		<span ng-show="addProductForm.product_dealer_price.$error.required">请输入经销商产品价格.</span>
            <span ng-show="addProductForm.product_dealer_price.$error.number">经销商产品价格需要为数字.</span>
            </span>
        </td>
    </tr>
    <tr>
        <td>
            选择产品类别：
            <br>
            <select style="width:300px" name="product_type" id="product_type" ng-model="product_type">
                <option value="0" selected>疫苗类产品</option>
                <option value="1">其他产品</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            选择产品支付流程：
            <br>
            <select style="width:300px" name="product_paytype" id="product_paytype" ng-model="product_paytype">
                <option value="0" selected>支付流程一</option>
                <option value="1">支付流程二</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            产品是否在首页展示：
            <br>
            <select style="width:300px" name="product_show" id="product_show" ng-model="product_show">
                <option value="0">不在首页显示</option>
                <option value="1" selected>在首页显示</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            输入产品介绍：
            <?php wp_editor("", "description");?>
        </td>
    </tr>
    <tr>
        <td>
        	<button onclick="saveProduct('<?php echo get_bloginfo('wpurl') . "/save-product";?>')" ng-disabled="addProductForm.product_name.$dirty && addProductForm.product_name.$invalid || addProductForm.product_price.$dirty && addProductForm.product_price.$invalid || addProductForm.product_dealer_price.$dirty && addProductForm.product_dealer_price.$invalid">保存产品</button>
        	<button ng-click="submit()">保存产品</button>
         </td>
    </tr>
</table>
</form>
</div>
<script>
var app = angular.module('addProductApp', []);
app.controller('addProductCtrl', function($scope, $http) {

});
</script>
<?php

}

?>