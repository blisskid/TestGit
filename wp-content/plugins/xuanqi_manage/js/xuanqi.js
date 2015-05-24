function selectAll(obj) {            
    jQuery('input:checkbox[name=xq_checkbox]').each(function() {
        //alert(jQuery(this).attr('id'));             
        jQuery(this).prop('checked', obj.checked);
    });
}

function showOrderDiv() {
    jQuery('#orderDiv').show(200);
    $("#inject_date").regMod("calendar", "6.0", {
        options: {
            autoShow: !1,
            showWeek: !0,
            maxDate: function() {
                var a = (new Date).addYears(1);
                return a.getFullYear() + "-" + (a.getMonth() + 1) + "-" + a.getDate();
            }()
        },
        listeners: {
            onBeforeShow: function() {},
            onChange: function() {}
        }
    })

    //酒店的时间控件
    $("#in_date").regMod("calendar", "6.0", {
        options: {
            autoShow: !1,
            showWeek: !0,
            maxDate: function() {
                var a = (new Date).addYears(1);
                return a.getFullYear() + "-" + (a.getMonth() + 1) + "-" + a.getDate();
            }()
        },
        listeners: {
            onBeforeShow: function() {},
            onChange: function() {}
        }
    })

    $("#out_date").regMod("calendar", "6.0", {
        options: {
            autoShow: !1,
            showWeek: !0,
            maxDate: function() {
                var a = (new Date).addYears(1);
                return a.getFullYear() + "-" + (a.getMonth() + 1) + "-" + a.getDate();
            }()
        },
        listeners: {
            onBeforeShow: function() {},
            onChange: function() {}
        }
    }) 

}

function hideHotelAirlineDiv() {
    jQuery('#hotelAirlineDiv').hide(200);
    //将日期相关的内容清空
    jQuery("#out_date").val("");
    jQuery("#in_date").val("");
    jQuery("#start_date").val("");
    jQuery("#back_date").val("");
    jQuery("#start_price").val("");
    jQuery("#back_price").val("");
    pickerEvent.remove();
}

//显示酒店航线信息
function showHotelAirlineDiv(wpUrl) {

    if (jQuery("#inject_date").val() == "") {
        alert("请选择疫苗注射日期");
        return;
    } 

   
    var fromAirport = jQuery('#from_airport').val();
    var province = fromAirport.split(",")[1];
    if ("guangdong" == province) {
        //广东省不需要选择机票
        jQuery('#airlineDiv').hide(200);
        jQuery('#if_airplane').val("NO");
        jQuery('#hotelAirlineDiv').show(200);
    } else {
        jQuery('#airlineDiv').show(200);
        jQuery('#if_airplane').val("YES");
        //机票的时间控件
        /*
        $("#start_date").regMod("calendar", "6.0", {
            options: {
                autoShow: !1,
                showWeek: !0,
                maxDate: function() {
                    var a = (new Date).addYears(1);
                    return a.getFullYear() + "-" + (a.getMonth() + 1) + "-" + a.getDate()
                }()
            },
            listeners: {
                onBeforeShow: function() {},
                onChange: function() {}
            }
        })
        $("#back_date").regMod("calendar", "6.0", {
            options: {
                autoShow: !1,
                showWeek: !0,
                maxDate: function() {
                    var a = (new Date).addYears(1);
                    return a.getFullYear() + "-" + (a.getMonth() + 1) + "-" + a.getDate()
                }()
            },
            listeners: {
                onBeforeShow: function() {},
                onChange: function() {}
            }
        })
        */ 
        var disCountUrl = wpUrl + "/airlines-info";
        var fromAirport = jQuery('#from_airport').val().split(",")[0];
        var toAirport = jQuery('#to_airport').val();
        var twoAirport = fromAirport < toAirport ? fromAirport + "|" + toAirport : toAirport + "|" + fromAirport;
        var Obj = {
            two_airport_code: twoAirport
        }

        jQuery.post(disCountUrl, Obj, function(data) {
            //alert(data);
            pickerEvent.setPriceArr(eval("(" + data + ")"));
            jQuery('#hotelAirlineDiv').show(200);
        });

    }
}

//是否选择入住酒店
function showHotelDateDiv(value) {
    if ("YES" == value) {
        jQuery('#hotelDateDiv').show(200);
    } else if ("NO" == value) {
        jQuery('#hotelDateDiv').hide(200);
    }
}

/*
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
*/

//选择机票起飞日期
function getStartDate(wpUrl) {
    pickerEvent.Init("start_date", "start_price");
}

//选择返程机票日期
function getBackDate(wpUrl) {
    pickerEvent.Init("back_date", "back_price");
    /*
    var disCountUrl = wpUrl + "/airlines-info";
    var fromAirport = jQuery('#to_airport').val();
    var toAirport = jQuery('#from_airport').val().split(",")[0];
    var twoAirport = fromAirport < toAirport ? fromAirport + "|" + toAirport : toAirport + "|" + fromAirport;
    var Obj = {
        two_airport_code: twoAirport
    }

    jQuery.post(disCountUrl, Obj, function(data) {
        //alert(data);
        pickerEvent.setPriceArr(eval("(" + data + ")"));
        pickerEvent.Init("back_date", "back_price");
    });
*/
}

//费用结算
function toSettlement() {

    var ifHotel = jQuery("input:radio[name='if_hotel']:checked").val();
    if ("YES" == ifHotel) {
        if (jQuery("#in_date").val() == "") {
            alert("请选择酒店入住日期");
            return;
        }
        if (jQuery("#out_date").val() == "") {
            alert("请选择酒店退房日期");
            return;
        }        
    }

    var ifAirplane = jQuery("#if_airplane").val();
    if ("YES" == ifAirplane) {
        if (jQuery("#start_date").val() == "") {
            alert("请选择出发日期");
            return;
        }
        if (jQuery("#back_date").val() == "") {
            alert("请选择返程日期");
            return;
        }        
    }

    jQuery("#orderForm").submit();

}