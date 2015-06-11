function selectAll(obj) {            
    jQuery('input:checkbox[name=xq_checkbox]').each(function() {
        //alert(jQuery(this).attr('id'));             
        jQuery(this).prop('checked', obj.checked);
    });
}


function hideHotelAirlineDiv() {
    //jQuery('#hotelAirlineDiv').fadeOut(200);
    jQuery('#hotelAirlineDiv').fadeOut(200);
    //将日期相关的内容清空
    jQuery("#out_date").val("");
    jQuery("#in_date").val("");
    jQuery("#start_date").val("");
    jQuery("#back_date").val("");
    jQuery("#start_price").val("");
    jQuery("#back_price").val("");
    $("#start_date").unregMod("calendar", "6.0");
    $("#back_date").unregMod("calendar", "6.0");
    $("#in_date").unregMod("calendar", "6.0");
    $("#out_date").unregMod("calendar", "6.0");

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
        jQuery('#airlineDiv').hide();
        jQuery("input[type='radio'][name='if_airplane'][value='0']").attr("checked", "checked");
        jQuery('#hotelAirlineDiv').fadeIn(200);
    } else {
        jQuery('#airlineDiv').show();
        //jQuery('#if_airplane').val("1");
        jQuery("input[type='radio'][name='if_airplane'][value='1']").attr("checked", "checked");
        //机票的时间控件

        var url = wpUrl + "/airport-info";
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
            jQuery('#hotelAirlineDiv').fadeIn(200);
        });

    }
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

//是否选择入住酒店
function showHotelDateDiv(value) {
    if ("1" == value) {
        jQuery('#hotelDateDiv').show(200);
    } else if ("0" == value) {
        jQuery('#hotelDateDiv').hide(200);
    }
}

//是否选择乘坐飞机
function showAirplaneDateDiv(value) {
    if ("1" == value) {
        jQuery('#airplaneDateDiv').show(200);
    } else if ("0" == value) {
        jQuery('#airplaneDateDiv').hide(200);
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
    var in_date = jQuery("#in_date").val();
    var out_date = jQuery("#out_date").val();
    var start_date = jQuery("#start_date").val();
    var back_date = jQuery("#back_date").val();
    var inject_date = jQuery("#inject_date").val();
    if ("1" == ifHotel) {
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

    var ifAirplane = jQuery("input:radio[name='if_airplane']:checked").val();
    if ("1" == ifAirplane) {
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

function mobileValidation(o) {
    var phone = jQuery("#phone").val();
    if ("" == phone) {
        alert("手机号码为空");
        return;
    }
    if (!/1\d{10}/.test(phone)) {
        alert("手机号码格式不正确");
        return;
    }
    var url = "http://www.caringyou.com.cn/mobile";
    var vnumber = "";

    var random = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
    for (var i = 0; i < 4; i++) {
        var index = Math.floor(Math.random() * 10);
        vnumber += random[index];
    }

    var Obj = {
        vnumber: vnumber,
        phone: phone
    }

    jQuery.post(url, Obj, function(data) {
        alert(data);
        jQuery("#revnumber").val(vnumber);
        time(o, 120);
    })
}


function time(o, wait) {
    if (wait == 0) {
        o.removeAttribute("disabled");
        o.value = "获取验证码";
        wait = 60;
    } else {
        o.setAttribute("disabled", true);
        o.value = wait + "秒后重新发送";
        wait--;
        setTimeout(function() {
                time(o, wait)
            },
            1000)
    }
}
