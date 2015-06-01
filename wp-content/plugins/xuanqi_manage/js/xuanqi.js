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


    var fromAirport = jQuery('#airport_code').val();
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
        
        var url = wpUrl + "/show-airport";
        var airport_code = jQuery('#airport_code').val().split(",")[0];
        //var twoAirport = fromAirport < toAirport ? fromAirport + "|" + toAirport : toAirport + "|" + fromAirport;
        var Obj = {
            airport_code: airport_code
        }

        jQuery.post(url, Obj, function(data) {
            //alert(data.records[0].bad_date);
            $("#start_date").regMod("calendar", "6.0", {
                options: {
                    autoShow: !1,
                    showWeek: !0,
                    hideAll: !0,
                    permit: data.records[0].bad_date,
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
                    hideAll: !0,
                    permit: data.records[0].bad_date,
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

//添加不可选的日期到DIV
function addBadDates() {
    var badDate = jQuery('#choose_bad_date').val();
    if (badDate != "") {
        var bad_dates = jQuery("#bad_date").val();
        if (-1 === bad_dates.indexOf(badDate)) {
            var badDatesDiv = document.getElementById("badDatesDiv");
            var deleteFunction = "deleteBadDateDiv('" + badDate + "')";
            var objectStr = "<div id=" + badDate + "><label>" + badDate + "<input type='button' value='删除' onclick=" + deleteFunction + "></input></label></div>";
            //var badDateDiv = $('<div>', { id: badDate, text: objectStr});
            badDatesDiv.innerHTML += objectStr;

            if (bad_dates == "") {
                bad_dates = badDate;
            } else {
                bad_dates += ",";
                bad_dates += badDate;
            }
            jQuery("#bad_date").val(bad_dates);
        } else {
            alert("所选日期已存在");
        }

    } else {
        alert("请选择日期");
    }
}

function deleteBadDateDiv(badDate) {
    var badDateDiv = document.getElementById(badDate);
    badDateDiv.parentNode.removeChild(badDateDiv);

    var bad_dates = jQuery("#bad_date").val().split(',');
    for (var i = bad_dates.length - 1; i >= 0; i--) {
        if (bad_dates[i] === badDate) {
            bad_dates.splice(i, 1);
        }
    }
    jQuery("#bad_date").val(bad_dates.join(','));
}

//费用结算
function toSettlement() {

    var ifHotel = jQuery("input:radio[name='if_hotel']:checked").val();
    var in_date= jQuery("#in_date").val();
    var out_date = jQuery("#out_date").val();
    var start_date = jQuery("#out_date").val();
    var back_date = jQuery("#out_date").val();
    var inject_date = jQuery("#inject_date").val();
    if ("YES" == ifHotel) {
        if (in_date == "") {
            alert("请选择酒店入住日期");
            return;
        }
        if (out_date == "") {
            alert("请选择酒店退房日期");
            return;
        }
        if (out_date <= in_date) {
            alert("退房日期需晚于入住日期");
            return;          
        }       
    }

    var ifAirplane = jQuery("#if_airplane").val();
    if ("YES" == ifAirplane) {
        if (start_date == "") {
            alert("请选择出发日期");
            return;
        }
        if (back_date == "") {
            alert("请选择返程日期");
            return;
        }
        if (back_date <= start_date) {
            alert("返程日期需晚于出发日期");
            return;          
        }
        if (start_date > inject_date) {
            alert("出发日期不能晚于于疫苗注射日期");
            return;             
        } 
        if (back_date < inject_date) {
            alert("返程日期不能早于疫苗注射日期");
            return;             
        }               
    }

    jQuery("#orderForm").submit();

}
