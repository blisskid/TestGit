<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>仿携程网带价格的jQuery日期选择控件 - 素材家园(www.sucaijiayuan.com)</title>
<style type="text/css">
*{margin:0;padding:0px;}
#calendar{margin-top:100px;padding:0px 5px;width:250px;height:30px;line-height:30px;border-radius:3px;border:1px solid #ccc;cursor:pointer;text-align:center;}
</style>
<script>
function AjaxTime(){
	jQuery.get("date.php",function(data) {
		pickerEvent.setPriceArr(eval("("+data+")"));
		pickerEvent.Init("calendar");
	});
}
</script>
</head>

<body>
<center>
<input type="text" id="calendar" name="calendar" readonly="readonly" onclick="AjaxTime();" placeholder="点击选择时间"/>
</center>
</body>
</html>
