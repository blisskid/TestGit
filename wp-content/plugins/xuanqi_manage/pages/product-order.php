<?php
/*判断是否是修改，如果是修改需要往控件中填值*/
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "请 <a href=\"" . $wpurl . "/login\">登录</a>.";
	return;

} else {

	//var_dump($_POST);

	if (isset($_GET["id"]) && "" != trim($_GET["id"]) && isset($_GET["orderDate"]) && "" != trim($_GET["orderDate"])) {

		global $wpdb;

		$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_direct_price`, `product_origin_price`, `product_description`, `product_introduction`, `bad_date` FROM `xq_products` WHERE ID=" . trim($_GET["id"]));
		//var_dump($productArray);
?>


<div class="xqFormHat"><?php echo $productArray[0]->product_name; ?></div>
<div class="xqFormPage">
    <table id="order_table">
        <tr><td><label for="product_name">产品名称：</label><span id="product_name"><?php echo $productArray[0]->product_name;?></span></td></tr>
        <tr><td><label for="product_per_price">产品单价：</label><span style="color:blue" id="product_per_price"><?php echo $productArray[0]->product_price;?></span></td></tr>
        <tr><td><label for="order_date">预约日期：</label><span id="order_date"><?php echo trim($_GET["orderDate"]);?></span></td></tr>
        <tr id="customer_1">
            <td colspan="2">
                <div class="xqFormHat">顾客1</div>
                <div class="xqFormPage">
                    <table>
                        <tr>
                            <td>
                                <label for="name_1">姓名：</label><input type="text" id="name_1" name="name_1" placeholder="张三"/>
                            </td>
                            <td>
                                <label>性别：</label><input type="radio" value="女" name="sex_1" checked/>女<input type="radio" value="男" name="sex_1" />男
                            </td>                            
                        </tr>
                        <tr>
                            <td>
                                <label for="age_1">年龄：</label><input type="text" id="age_1" name="age_1" placeholder="18"/>
                            </td>
                            <td>
                                <label for="job_1">职业：</label><input type="text" id="job_1" name="job_1" placeholder="学生"/>
                            </td>                            
                        </tr>
                        <tr>
                            <td>
                                <label for="email_1">邮箱：</label><input type="text" id="email_1" name="email_1" placeholder="zhangxx@163.com"/>
                            </td>
                            <td>
                                <label for="tel_1">电话：</label><input type="text" id="tel_1" name="tel_1" placeholder="请填写联系方式"/>
                            </td>                            
                        </tr>
                        <tr>
                            <td>
                                <label for="allergy_1">过敏：</label><input type="text" id="allergy_1" name="allergy_1" placeholder="请填写过敏药物名称"/>
                            </td>                            
                        </tr>                                                                         
                    </table>
                </div>
            </td>
        </tr>                   
        <tr><td colspan="2"><input id="customer_button" type="button" value="添加顾客" style="float: right" onclick="addCustomer('<?php echo $productArray[0]->product_origin_price;?>', '<?php echo $productArray[0]->product_price;?>')"></input></td></tr>
        <tr>
            <td>
                <div style="background-color: #f2dede;width: 500px;height: 100px;text-align: center;line-height: 100px;font-weight: 30px;color: red;">
                    原价：<span id="product_origin_price" style="text-decoration:line-through;"><?php echo $productArray[0]->product_origin_price;?></span>
                </div>
            </td>
            <td>
                <div style="background-color: #d9edf7;width: 500px;height: 100px;line-height: 100px;text-align: center;font-weight: 30px;color: red;">
                    总价：<span id="product_price"><?php echo $productArray[0]->product_price;?></span>
                </div>
            </td>            
        </tr>
        <tr>
            <td>
                <input type="button" value="返回" style="float: left" onclick="backToProductDetail('<?php echo $productArray[0]->ID;?>')"></input>
            </td>
            <td>
                <input type="button" style="float: right" onclick="toOnlinePay('<?php echo $productArray[0]->product_name;?>','<?php echo trim($_GET["orderDate"]);?>')" value="支付费用"></input>
            </td>
        </tr>
    </table>
</div>
<?php        
	}
}
?>