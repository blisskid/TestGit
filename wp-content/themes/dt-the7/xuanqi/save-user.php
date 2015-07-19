<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if (isset($_POST["user_name"]) && isset($_POST["user_phone"]) && isset($_POST["user_pass"]) && isset($_POST["repeat_pass"])) {

	global $wpdb;
	$user_name = trim($_POST["user_name"]);
	$user_phone = trim($_POST["user_phone"]);
	$user_pass = trim($_POST["user_pass"]);
	$repeat_pass = trim($_POST["repeat_pass"]);

	$userdata = array(
		'user_login' => $user_name);
	//var_dump($userdata);
	$user_id = wp_insert_user($userdata);
	if (is_wp_error($user_id)) {
		echo '{"flag":"1","error":"'.$user_id->get_error_message().'"}';
	} else {
		wp_set_password($user_pass, $user_id);
		update_user_meta($user_id, 'phone', $user_phone);
		echo '{"flag":"0","error":""}';
	}
} else {
	echo '{"flag":"1","error":"输入参数有误"}';
}
?>
