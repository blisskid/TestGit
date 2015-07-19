<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if (isset($_POST["user_name"]) && isset($_POST["user_pass"]) && isset($_POST["remember"])) {

	global $wpdb;
	$user_name = trim($_POST["user_name"]);
	$user_pass = trim($_POST["user_pass"]);
	$remember = $_POST["remember"] == "1" ? true : false;

	$userdata = array(
		'user_login' => $user_name,
		'user_password' => $user_pass,
		'remember' => $remember);
	//var_dump($userdata);
	$user_verify = wp_signon($userdata, true);
	//var_dump($user_verify);
	if (is_wp_error($user_verify)) {
		echo '{"flag":"1","error":"'.addslashes($user_verify->get_error_message()).'"}';
	} else {
		wp_set_password($user_pass, $user_id);
		echo '{"flag":"0","error":""}';
	}
}
/*
else if (isset($_POST["user_name"]) && isset($_POST["user_phone"]) && isset($_POST["vnumber"])) {
	//判断用户和手机号码是否正确
	$user_id = username_exists();
	var_dump($user_id);
	if ($user_id != null) {
		$user_phone = get_usermeta($user->ID, 'phone')
		if ($user_phone == $_POST["user_phone"]) {
			echo '{"flag":"0","error":""}';
		} else {
			echo '{"flag":"0","error":"手机号码不正确！"}';
		}
	} else {
		echo '{"flag":"0","error":"用户不存在！"}';
	}
}
*/
else {
	echo '{"flag":"1","error":"输入参数有误"}';
}
?>
