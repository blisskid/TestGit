<?php
global $wpdb;
$searchSql = "SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_direct_price`, `product_type`, `product_paytype`, `product_show`, `reserved_text` FROM `xq_products`";
$productArray = $wpdb->get_results($searchSql);

foreach ($productArray as $product) {
?>
<div>
	<table>
		<tr>
			<td>
				<div class="xqFormHat"><?php echo $product->product_name; ?></div>
				<div class="xqFormPage">
					<div style="width: 60%;border:1px dashed #3da7eb;float: left;">
						插入图片<br/>
						插入图片<br/>
						插入图片<br/>
						插入图片<br/>
					</div>
					<div style="width: 35%;border:1px dashed #3da7eb;margin-left: 65%;">
						价格：<span><?php echo $product->product_price; ?></span><br/>
						经销商价格：<span><?php echo $product->product_dealer_price; ?></span><br/>
						直销商价格：<span><?php echo $product->product_direct_price; ?></span><br/>
						<input type="button" style="float: right" value="查看详细"></input>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

<?php
}

?>