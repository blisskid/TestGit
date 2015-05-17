function selectAll(obj) {            
    jQuery('input:checkbox[name=xq_checkbox]').each(function() {
        //alert(jQuery(this).attr('id'));             
        jQuery(this).prop('checked', obj.checked);
    });
}

function showProcessDiv(value, airportUrl) {
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

function showOrderDate(value, disCountUrl) {
    if ("YES" == value) {
        jQuery('#allOrderDate').hide();
        //需要从后台取出所有的discountDate
        var fromAirport = jQuery('#from_airport').val();
        var toAirport = jQuery('#to_airport').val();
        var Obj = {
            fromAirport: fromAirport,
            toAirport: toAirport
        }
        jQuery.post(disCountUrl, Obj,
            function(data) {
                alert(data);
            });

        jQuery('#discountDate').show(200);
    } else if ("NO" == value) {
        jQuery('#discountDate').hide();
        jQuery('#allOrderDate').show(200);
    }
}


function ajaxTime(){
    jQuery.get("http://www.caringyou.com.cn/date",function(data) {
        pickerEvent.setPriceArr(eval("("+data+")"));
        pickerEvent.Init("calendar");
    });
}