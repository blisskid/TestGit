<article>
    <h5>
<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
	return;

} else {

	if (isset($_POST["user_type"]) && isset($_POST["user_name"]) && isset($_POST["user_email"]) && isset($_POST["user_phone"]) && isset($_POST["user_city"]) && isset($_POST["user_joinmsg"])) {

		global $wpdb;
		$user_name = trim($_POST["user_name"]);
		$user_email = trim($_POST["user_email"]);
		$user_phone = trim($_POST["user_phone"]);
		$user_city = trim($_POST["user_city"]);
		$user_joinmsg = trim($_POST["user_joinmsg"]);
		$user_type = trim($_POST["user_type"]);

		$userdata = array(
			'user_login' => $user_phone,
			'user_email' => $user_email);

		$user_id = wp_insert_user($userdata);

		update_user_meta($user_id, 'sex', '女');
		update_user_meta($user_id, 'age', '');
		update_user_meta($user_id, 'job', '');
		update_user_meta($user_id, 'allergy', '');
		update_user_meta($user_id, 'user_type', $user_type);
		update_user_meta($user_id, 'user_city', $user_city);
		update_user_meta($user_id, 'user_joinname', $user_name);
		update_user_meta($user_id, 'user_joinmsg', $user_joinmsg);
		update_user_meta($user_id, 'phone', $user_phone);

		$user_pass = wp_generate_password();
		wp_set_password($user_pass, $user_id);

		echo "加盟成功！<br>您的用户名为：" . $user_phone . "<br>生成的随机密码为：" . $user_pass . "<br>请复制密码登录系统并修改密码";

	} else {
		echo "<font color='red'>输入参数有误！</font>";

	}
}
?>
	</h5>
</article>