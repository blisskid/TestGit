[layerslider id="3"]
<div class="xqPage">

<?php
global $wpdb;
$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_description` FROM `xq_products`");
foreach ($productArray as $product) {
	?>
	<div id="product_<?php echo $product->ID;?>" class="productDiv">
	    <?php echo $product->product_description;?>
	</div>

<?php
}

?>
</div>