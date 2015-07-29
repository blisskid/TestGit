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
    if (!/^0?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(phone)) {
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
        alert("验证码已发送，请在2分钟内输入");
        jQuery("#revnumber").val(vnumber);
        time(o, 60);
    })
}

function joinUsmobileValidation(o) {
    var phone = jQuery("#user_phone").val();
    if ("" == phone) {
        alert("手机号码为空");
        return;
    }

    if (!/^0?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(phone)) {
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
        alert("验证码已发送，请在2分钟内输入");
        jQuery("#revnumber").val(vnumber);
        time(o, 60);
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

function joinUs() {

    if (jQuery("#user_name").val() == "") {
        alert("请输入姓名/企业姓名");
        return;
    }

    if (jQuery("#user_email").val() == "") {
        alert("请输入邮箱");
        return;
    }

    if (jQuery("#user_phone").val() == "") {
        alert("请输入手机号");
        return;
    }

    if (!/^0?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(jQuery("#user_phone").val())) {
        alert("手机号码格式不正确");
        return;
    }

    if (jQuery("#user_city").val() == "") {
        alert("请输入加盟地区");
        return;
    }

    var vnumber = jQuery("#vnumber").val();

    if (vnumber == "") {
        alert("验证码为空");
        return;
    }

    var revnumber = jQuery("#revnumber").val();
    if (vnumber != revnumber) {
        alert("验证码不正确！");
        return;
    }
    jQuery("#addUserForm").submit();
}

function xqFindPassword() {
    if (jQuery("#user_name").val() == "") {
        alert("请输入用户名");
        return;
    }

    if (jQuery("#user_phone").val() == "") {
        alert("请输入手机号");
        return;
    }

    if (!/^0?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(jQuery("#user_phone").val())) {
        alert("手机号码格式不正确");
        return;
    }

    var vnumber = jQuery("#vnumber").val();

    if (vnumber == "") {
        alert("验证码为空");
        return;
    }

    var revnumber = jQuery("#revnumber").val();
    if (vnumber != revnumber) {
        alert("验证码不正确！");
        return;
    }
    jQuery("#xqFindPasswordForm").submit();       
}

function xqRegister() {

    if (jQuery("#user_name").val() == "") {
        alert("请输入用户名");
        return;
    }

    if (jQuery("#user_phone").val() == "") {
        alert("请输入手机号");
        return;
    }

    if (!/^0?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(jQuery("#user_phone").val())) {
        alert("手机号码格式不正确");
        return;
    }

    var vnumber = jQuery("#vnumber").val();

    if (vnumber == "") {
        alert("验证码为空");
        return;
    }

    var revnumber = jQuery("#revnumber").val();
    if (vnumber != revnumber) {
        alert("验证码不正确！");
        return;
    }       

    if (jQuery("#user_pass").val() == "") {
        alert("请输入密码");
        return;
    }

    if (jQuery("#repeat_pass").val() == "") {
        alert("请再次输入密码");
        return;
    }

    if (jQuery("#repeat_pass").val() != jQuery("#user_pass").val()) {
        alert("两次输入的密码不一致");
        return;
    }

    var url = "http://www.caringyou.com.cn/save-user";

    var Obj = {
        user_name: jQuery("#user_name").val(),
        user_phone: jQuery("#user_phone").val(),
        user_pass: jQuery("#user_pass").val(),
        repeat_pass: jQuery("#repeat_pass").val()
    }

    jQuery.post(url, Obj, function(data) {
        if (data.flag == 0) {
            jQuery("#xqRegisterForm").submit();
        } else {
            alert(data.error);
        }
    });    
}

function xqResetPassword() {
    if (jQuery("#user_name").val() == "") {
        alert("请输入用户名");
        return;
    }
      

    if (jQuery("#user_pass").val() == "") {
        alert("请输入密码");
        return;
    }

    if (jQuery("#repeat_pass").val() == "") {
        alert("请再次输入密码");
        return;
    }

    if (jQuery("#repeat_pass").val() != jQuery("#user_pass").val()) {
        alert("两次输入的密码不一致");
        return;
    }

    var url = "http://www.caringyou.com.cn/reset-pass";

    var Obj = {
        user_name: jQuery("#user_name").val(),
        user_pass: jQuery("#user_pass").val(),
        repeat_pass: jQuery("#repeat_pass").val()
    }

    jQuery.post(url, Obj, function(data) {
        if (data.flag == 0) {
            alert("修改密码成功！");
            jQuery("#xqResetForm").submit();
        } else {
            alert(data.error);
        }
    });      
}


function xqLogin() {

    if (jQuery("#user_name").val() == "") {
        alert("请输入用户名");
        return;
    }    

    if (jQuery("#user_pass").val() == "") {
        alert("请输入密码");
        return;
    }

    var remember = "0";
    if (jQuery("#remember").attr("checked")) {
        remember = "1";
    }

    var url = "http://www.caringyou.com.cn/check-user";

    var Obj = {
        user_name: jQuery("#user_name").val(),
        user_pass: jQuery("#user_pass").val(),
        remember:  remember
    }

    jQuery.post(url, Obj, function(data) {
        //alert(data);
        if (data.flag == 0) {
            jQuery("#xqLoginForm").submit();
        } else {
            //alert(data.error);
            //替换忘记密码的链接
            //jQuery("#hintDiv").html(data.error.replace(/<a href=\"xuanqi\">忘记了密码？/, "<a href=\"http://www.caringyou.com.cn/?p=1214\">忘记了密码？"));
            jQuery("#hintDiv").html(data.error.replace(/<a href=.*忘记了密码？/, "<a href=\"http://www.caringyou.com.cn/?p=1214\">忘记了密码？"));
            jQuery("#hintDiv").show();
        }
    });    
}

function toPay(product_name, inject_date, product_price, if_airplane, start_airport_name, start_date, back_date, airline_price, if_hotel, in_date, out_date, hotel_price, total_price) {
    var url = "http://www.caringyou.com.cn/save-order";
    var Obj = {
        product_name: product_name,
        inject_date: inject_date,
        product_price: product_price,
        if_airplane: if_airplane,
        start_airport_name: start_airport_name,
        start_date: start_date,
        back_date: back_date,
        airline_price: airline_price,
        if_hotel: if_hotel,
        in_date: in_date,
        out_date: out_date,
        hotel_price: hotel_price,
        total_price: total_price
    }

    jQuery.post(url, Obj, function(data) {
        jQuery("#p5_Pid").val(data);
        jQuery("#payForm").submit();
    });
}

function checkProductDetail(productId) {
    window.location.href="http://www.caringyou.com.cn/?p=1369&id=" + productId;
}

function gotoOrder(product_id) {
    if (jQuery("#order_date").val() == "") {
        alert("请输入预约日期！");
        return;
    }

    window.location.href="http://www.caringyou.com.cn/?p=1387&id=" + product_id + "&orderDate=" + jQuery("#order_date").val();
}

function addCustomer(product_origin_price, product_price) {
    var now_origin_price = parseInt(jQuery("#product_origin_price").html());
    var now_product_price = parseInt(jQuery("#product_price").html());
    var origin_price = parseInt(product_origin_price);
    var price = parseInt(product_price);
    var index = now_origin_price / origin_price;
    var nextIndex = index + 1;
    var str =   '<tr id="customer_' + nextIndex + '"><td colspan="2"><div class="xqFormHat">顾客' + nextIndex + '</div><div class="xqFormPage"><table><tr><td><label for="name_' + nextIndex + '">姓名：</label><input type="text" id="name_' + nextIndex + '" name="name_' + nextIndex + '" placeholder="张三"/></td><td><label>性别：</label><input type="radio" value="女" name="sex_' + nextIndex + '" checked/>女<input type="radio" value="男" name="sex_' + nextIndex + '" />男</td></tr>' + 
                '<tr><td><label for="age_' + nextIndex + '">年龄：</label><input type="text" id="age_' + nextIndex + '" name="age_' + nextIndex + '" placeholder="18"/></td><td><label for="job_' + nextIndex + '">职业：</label><input type="text" id="job_' + nextIndex + '" name="job_' + nextIndex + '" placeholder="学生"/></td></tr>' + 
                '<tr><td><label for="age_' + nextIndex + '">邮箱：</label><input type="text" id="age_' + nextIndex + '" name="age_' + nextIndex + '" placeholder="18"/></td><td><label for="tel_' + nextIndex + '">电话：</label><input type="text" id="tel_' + nextIndex + '" name="tel_' + nextIndex + '" placeholder="请填写联系方式"/></td></tr>' + 
                '<tr><td><label for="allergy_' + nextIndex + '">过敏：</label><input type="text" id="allergy_' + nextIndex + '" name="allergy_' + nextIndex + '" placeholder="请填写过敏药物名称"/></td></tr>' +                                                                          
                '</table></div></td></tr>';
    jQuery("#order_table #customer_" + index).after(str);
    jQuery("#customer_button").val("移除顾客");
    jQuery("#customer_button").attr("onclick", "removeCustomer('" + nextIndex + "', '" + product_origin_price + "', '" + product_price + "');");
    //价格乘以2
    var add_origin_price = now_origin_price + origin_price;
    var add_product_price = now_product_price + price;
    jQuery("#product_origin_price").html(add_origin_price);
    jQuery("#product_price").html(add_product_price);
}

function removeCustomer(index, product_origin_price, product_price) {
    var now_origin_price = parseInt(jQuery("#product_origin_price").html());
    var now_product_price = parseInt(jQuery("#product_price").html());
    var origin_price = parseInt(product_origin_price);
    var price = parseInt(product_price);    
    jQuery("#order_table #customer_" + index).remove();
    jQuery("#customer_button").val("添加顾客");
    jQuery("#customer_button").attr("onclick", "addCustomer('" + product_origin_price + "', '" + product_price + "');");
    var sub_origin_price = now_origin_price - origin_price;
    var sub_product_price = now_product_price - price;
    jQuery("#product_origin_price").html(sub_origin_price);
    jQuery("#product_price").html(sub_product_price);    
}

function toOnlinePay(product_name, order_date) {

}
