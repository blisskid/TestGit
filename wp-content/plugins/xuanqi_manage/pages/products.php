<?php
global $wpdb;
$searchSql = "SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_direct_price`, `product_origin_price`, `product_type`, `product_introduction`, `bad_date`, `img_url`, `reserved_text` FROM `xq_products`";
$productArray = $wpdb->get_results($searchSql);

foreach ($productArray as $product) {
?>
<div>
	<table>
		<tr>
			<td>
				<div class="xqFormHat"><?php echo $product->product_name; ?></div>
				<div class="xqFormPage" style="height: 275px">
					<img style="width: 680px;float: left;" src="<?php echo $product->img_url; ?>" />
					<!--
					<div style="width: 680px;border:1px dashed #3da7eb;float: left;padding:10px;background-image: http://www.caringyou.com.cn/wp-content/uploads/2015/07/53d49a932d6bb.jpg;">
					</div>
				-->
					<div style="width: 300px;margin-left: 700px;padding:10px;">
						<table>
							<tr>
								<td><label for="product_product_name">产品名称：</label><span id="product_product_name"><?php echo $product->product_name; ?></span></td>
							</tr>								
							<tr>
								<td><label for="product_introduction">产品简介：</label><span id="product_introduction"><?php echo $product->product_introduction; ?></span></td>
							</tr>
							<tr>
								<td><label for="product_origin_price">产品原价：</label><span id="product_origin_price" style="text-decoration:line-through;color:red;">￥<?php echo $product->product_origin_price; ?>元</span></td>
							</tr>														
							<tr>
								<td><label for="product_price">产品现价：</label><span style="color:blue" id="product_price">￥<?php echo $product->product_price; ?>元</span></td>
							</tr>
							<tr>
								<td><input type="button" value="查看详细" style="float: right" onclick="checkProductDetail('<?php echo $product->ID; ?>')"></input></td>
							</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

<?php
}

?>