function selectAll(obj) {            
    jQuery('input:checkbox[name=xq_checkbox]').each(function() {
        //alert(jQuery(this).attr('id'));             
        jQuery(this).prop('checked', obj.checked);
    });
}

function deleteProducts(url) {
    var ids = "";
    var count = 0;
    var checkBoxs = jQuery('input:checkbox[name=xq_checkbox]:checked');
    var checkBoxsLength = checkBoxs.length;
    if (checkBoxsLength == 0) {
        alert("请选择要删除的记录");
        return;
    }

    if (confirm("确认要删除吗？")) {
        checkBoxs.each(function() {
            //alert(jQuery(this).attr('id'));
            //jQuery(this).prop('checked', obj.checked);
            count++;
            if (count < checkBoxsLength) {
                ids += jQuery(this).attr('id') + ",";
            } else if (count = checkBoxsLength) {
                ids += jQuery(this).attr('id');
            }

        });
        //alert(ids);
        var Obj = {
            ids: ids
        }
        jQuery.post(url, Obj,
            function(data) {
                alert(data);
			    $http.get('http://localhost/xuanqi/show-product";?>').success(function(response) {
			        $scope.names = response.records;
			    });                
            });
    }

}

function saveProduct(url) {

    var product_name = jQuery("#product_name").val();
    var product_price = jQuery("#product_price").val();
    var product_dealer_price = jQuery("#product_dealer_price").val();
    var product_type = jQuery("#product_type").val();
    var product_paytype = jQuery("#product_paytype").val();
    var product_show = jQuery("#product_show").val();
    //var product_description = jQuery("#product_description").val();
    var product_description = document.getElementById("description").value;
    alert(product_description);
    var product_id = jQuery("#product_id").val();

    /*
    if ("" == recordTime || !/^[0-9]*$/.test(recordTime)) {
        alert("Record time should be integer!" + recordTime);
        return;
    }

    if ("" == room || !/^[a-zA-Z\d_\s]*$/.test(room)) {
        alert("Wrong room name!");
        return;
    }

    if ("" == ip || !/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/.test(ip)) {
        alert("Wrong IP address!");
        return;
    }
    */


    var productObj = {
        product_name: product_name,
        product_price: product_price,
        product_dealer_price: product_dealer_price,
        product_type: product_type,
        product_paytype: product_paytype,
        product_show: product_show,
        product_description: product_description
    }


    if ("" != product_id) {
        //更新页面信息
        //jQuery("#loading").show();
        jQuery.post("http://trendnet.nmlibrary.ul.ie/?page_id=329", productObj,
            function(data) {
                /*
                jQuery.get("http://trendnet.nmlibrary.ul.ie", function(data, status) {
                    var resultDom = jQuery(data);
                    var content = resultDom.find('div.entry-content').html();
                    jQuery("#loading").hide();
                    jQuery("#content").html(content);
                });
*/
                alert(data);

            });
    } else {
        //增加页面信息
        jQuery("#loading").show();
        jQuery.post(url, productObj,
            function(data) {
                alert(data);
                //window.location.href = "http://trendnet.nmlibrary.ul.ie/html5/control/cameralistadmin.html";
            });
    }
    return;

}