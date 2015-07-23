<?php
global $wpdb;
$searchSql = "SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_direct_price`, `product_origin_price`, `product_type`, `product_introduction`, `bad_date`, `reserved_text` FROM `xq_products`";
$productArray = $wpdb->get_results($searchSql);

foreach ($productArray as $product) {
?>
<div>
	<table>
		<tr>
			<td>
				<div class="xqFormHat"><?php echo $product->product_name; ?></div>
				<div class="xqFormPage">
					<div style="width: 660px;border:1px dashed #3da7eb;float: left;padding:10px;">
						插入图片
						插入图片
						插入图片
					</div>
					<div style="width: 440px;border:1px dashed #3da7eb;margin-left: 700px;padding:10px;">
						<table>
							<tr>
								<td>价格：<?php echo $product->product_price; ?></td>
							</tr>
							<tr>
								<td>经销商价格：<?php echo $product->product_dealer_price; ?></td>
							</tr>						
							<tr>
								<td>直销商价格：<?php echo $product->product_direct_price; ?></td>
							</tr>
							<tr>
								<td><input type="button" value="查看详细" style="float: right"></input></td>
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