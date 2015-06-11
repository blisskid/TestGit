<?php
//载入ucpass类
require_once 'lib/Ucpaas.class.php';

if (isset($_POST["phone"]) && isset($_POST["vnumber"]) ) {
	//初始化必填
	$options['accountsid'] = 'a6af662d4e073274f4b13226ec96d39f';
	$options['token'] = '54a72f0a03c114fbc36c5fd4e87718f5';

	//初始化 $options必填
	$ucpass = new Ucpaas($options);

	//开发者账号信息查询默认为json或xml

	$ucpass->getDevinfo('xml');

	//短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
	$appId = "ce7259b2939d443fa2c3d401baf29ab7";
	$to = trim($_POST["phone"]);
	$templateId = "7861";
	$param = trim($_POST["vnumber"]) . ",2";

	echo $ucpass->templateSMS($appId, $to, $templateId, $param);	
}
