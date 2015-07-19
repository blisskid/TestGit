<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if (isset($_POST["user_name"]) && isset($_POST["user_pass"]) && isset($_POST["repeat_pass"])) {

	global $wpdb;
	$user_name = trim($_POST["user_name"]);
	$user_pass = trim($_POST["user_pass"]);
	$repeat_pass = trim($_POST["repeat_pass"]);

	$user_id = username_exists($user_name);

	if ($user_id != null) {
		wp_set_password($user_pass, $user_id);
		echo '{"flag":"0","error":""}';
	} else {
		echo '{"flag":"1","error":"用户不存在！"}';
	}
} else {
	echo '{"flag":"1","error":"输入参数有误"}';
}
?>
