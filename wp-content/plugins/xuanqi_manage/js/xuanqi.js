function selectAll(obj) {            
    jQuery('input:checkbox[name=xq_checkbox]').each(function() {
        //alert(jQuery(this).attr('id'));             
        jQuery(this).prop('checked', obj.checked);
    });
}

function showProcessDiv(value) {
    //alert(value);
    //jQuery("#product_select option[index='0']").remove();
    jQuery('#makeYourChoice').remove();
    var selectedArray = value.split(",");
    if ("0" == selectedArray[1]) {
        //疫苗类产品
        jQuery('#yimiaoDiv').show(200);
        jQuery('#notYimiaoDiv').hide();

    } else if ("1" == selectedArray[1]) {
        //非疫苗类产品，需要将一些值填入默认值
        jQuery('#notYimiaoDiv').show(200);
        jQuery('#yimiaoDiv').hide();
    }

}

function showOrderDate(value) {
    if ("YES" == value) {
        jQuery('#discountDate').show(200);
    } else if ("NO" == value) {
        jQuery('#discountDate').hide(200);
        pickerEvent.remove();
    }
}

function getStartDate(wpUrl) {
    var disCountUrl = wpUrl + "/discountAirlines";
    var fromAirport = jQuery('#from_airport').val();
    var toAirport = jQuery('#to_airport').val();
    var Obj = {
        start_airport_code: fromAirport,
        arrive_airport_code: toAirport
    }
    
    jQuery.post(disCountUrl, Obj, function(data) {
        //alert(data);
        pickerEvent.setPriceArr(eval("(" + data + ")"));
        pickerEvent.Init("start_date");
    });
}

function getBackDate(wpUrl) {
    var disCountUrl = wpUrl + "/discountAirlines";
    var fromAirport = jQuery('#to_airport').val();
    var toAirport = jQuery('#from_airport').val();
    var Obj = {
        start_airport_code: fromAirport,
        arrive_airport_code: toAirport
    }
    
    jQuery.post(disCountUrl, Obj, function(data) {
        //alert(data);
        pickerEvent.setPriceArr(eval("(" + data + ")"));
        pickerEvent.Init("back_date");
    });
}
