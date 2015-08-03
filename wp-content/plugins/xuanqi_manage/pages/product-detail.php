<?php
/*判断是否是修改，如果是修改需要往控件中填值*/
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "请 <a href=\"" . $wpurl . "/login\">登录</a>.";
	return;

} else {

	//var_dump($_POST);

	if (isset($_GET["id"]) && "" != trim($_GET["id"])) {

		global $wpdb;

		$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_direct_price`, `product_origin_price`, `product_description`, `product_introduction`, `bad_date`, `img_url` FROM `xq_products` WHERE ID=" . trim($_GET["id"]));
		//var_dump($productArray);
?>

<table>
    <tr>
        <td>
            <div class="xqFormHat"><?php echo $productArray[0]->product_name; ?></div>
            <div class="xqFormPage" style="height: 275px">
                <img style="width: 680px;float: left;" src="<?php echo $productArray[0]->img_url; ?>" />
                <div style="width: 300px;margin-left: 700px;padding:10px;">
                    <table>
                        <tr><td><label for="product_name">产品名称：</label><span id="product_name"><?php echo $productArray[0]->product_name;?></span></td></tr>
                        <tr><td><label for="product_price">产品价格：</label><span style="color:blue" id="product_price"><?php echo $productArray[0]->product_price;?></span></td></tr>
                        <tr><td><label for="order_date">预约日期：</label><input type="text" id="order_date" name="order_date" autocomplete="off"/></td></tr>
                        <tr><td><input type="button" value="马上预约" style="float: right" onclick="gotoOrder('<?php echo $productArray[0]->ID; ?>')"></input></td></tr>
                    </table>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="xqFormHat">服务介绍</div>
            <div class="xqFormPage">
                <table>
                    <tr><td><?php echo $productArray[0]->product_description;?></td></tr>
                </table>
            </div>
        </td>
    </tr>
</table>
<script type="text/javascript">
$("#order_date").regMod("calendar", "6.0", {
    options: {
        autoShow: !1,
        showWeek: !0,
        hideAll: !0,
        permit: '<?php echo $productArray[0]->bad_date;?>',
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
}
?>