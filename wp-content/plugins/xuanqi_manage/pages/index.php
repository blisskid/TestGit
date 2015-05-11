[layerslider id="1"]
<?php
global $wpdb;
$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products`");
$outp = "";
foreach ($productArray as $product) {

}
?>
<div class="xqPage">
    <div class="xqProductList">
        <table>
            <tr>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
            </tr>
        </table>
    </div>
</div>