[layerslider id="1"]
<div class="xqPage">
    <?php 
    global $wpdb; 
    $productArray=$wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `product_description` FROM `xq_products` WHERE product_show='1'"); 
    ?>
    <div class="xqProductList">
        <table>
            <tr>
                <td style="width: 33%;padding: 20px;">
                    <?php echo $productArray[0]->product_description; ?>
                </td>
                <td style="width: 0.5%;"></td>
                <td style="width: 33%;padding: 20px;">
                    <?php echo $productArray[1]->product_description; ?>
                </td>
                <td style="width: 0.5%;"></td>
                <td style="width: 33%;padding: 20px;">
                    <?php echo $productArray[2]->product_description; ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="xqProductList">
        <table>
            <tr>
                <td style="width: 33%;padding: 20px;">
                    服务优势：
                    <br> [dt_list style="1" bullet_position="middle" dividers="true"] [dt_list_item image=""]优势一[/dt_list_item] [dt_list_item image=""]优势二[/dt_list_item] [dt_list_item image=""]优势三[/dt_list_item] [/dt_list]
                </td>
                <td style="width: 0.5%;"></td>
                <td style="width: 33%;padding: 20px;">
                    合作伙伴：
                    <br> 展示四个logo，并在下面附上“欢迎加入我们”超链接文本，连接至“加盟轩祺”页面。
                    <br>
                    <a href="http://www.caringyou.com.cn/%E5%8A%A0%E7%9B%9F%E8%BD%A9%E7%A5%BA/">加入我们</a>
                </td>
                <td style="width: 0.5%;"></td>
                <td style="width: 33%;padding: 20px;">
                    第三块使用shortcodes里的blog mini，样式选择“post with rectangular images”
                </td>
            </tr>
        </table>
    </div>
</div>
<?php ?>
