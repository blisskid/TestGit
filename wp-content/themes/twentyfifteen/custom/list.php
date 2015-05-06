<?php
echo "<table>";
echo "<th>产品名称</th>";
echo "<th>产品价格（元）</th>";
echo "<th>经销商产品价格（元）</th>";
echo "<th>产品描述</th>";
echo "<th>产品优势</th>";
echo "<th>产品类别</th>";
echo "<th>支付流程</th>";
global $wpdb;
$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_description`, `product_advantage`, `product_type`, `product_paytype`, `reserved_text` FROM `xq_products`");
foreach ($productArray as $product) {
	echo "<tr>";
	echo "<td>$product->product_name</td>";
	echo "<td>$product->product_price</td>";
	echo "<td>$product->product_dealer_price</td>";
	echo "<td>$product->product_description</td>";
	echo "<td>$product->product_advantage</td>";
	echo "<td>$product->product_type</td>";
	echo "<td>$product->product_paytype</td>";
	echo "</tr>";
}

echo "</table>";
?>