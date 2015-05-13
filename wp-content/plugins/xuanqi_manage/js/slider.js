var cbAnimStart = function(data) { 
    jQuery(".productDiv").hide();
    jQuery("#product_" + data.curLayerIndex).show(1000);
};