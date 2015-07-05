<?php

if (isset($_POST["user_name"]) && isset($_POST["user_email"]) && isset($_POST["user_pass"]) && isset($_POST["repeat_pass"])) {

	global $wpdb;
	$user_name = trim($_POST["user_name"]);
	$user_email = trim($_POST["user_email"]);
	$user_pass = trim($_POST["user_pass"]);
	$repeat_pass = trim($_POST["repeat_pass"]);

	$userdata = array(
		'user_login' => $user_name,
		'user_email' => $user_email,
		'user_pass'   =>  $user_pass);

	$user_id = wp_insert_user($userdata);
	var_dump($user_id);
	if (is_wp_error($user_id)) {
		echo '{"flag":"1","error":"'.$user_id->get_error_message().'"}';
	} else {
		echo '{"flag":"0","error":""}';
	}
} else {
	echo '{"flag":"1","error":"输入参数有误"}';
}
?>
