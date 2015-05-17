<article>
    <h5>
<?php
$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "请 <a href=\"" . $wpurl . "/wp-login.php\">登录</a>.";
	return;

} else {

	//var_dump($_POST);

	if (isset($_POST["user_type"]) && isset($_POST["user_name"]) && isset($_POST["user_email"]) && isset($_POST["user_phone"]) && isset($_POST["user_city"]) && isset($_POST["user_joinmsg"])) {

		global $wpdb;
		$user_name = trim($_POST["user_name"]);
		$user_email = trim($_POST["user_email"]);
		$user_phone = trim($_POST["user_phone"]);
		$user_city = trim($_POST["user_city"]);
		$user_joinmsg = trim($_POST["user_joinmsg"]);
		$user_type = trim($_POST["user_type"]);

		$sql = "INSERT INTO `xq_users`(`user_name`, `user_type`, `user_email`, `user_phone`, `user_city`, `user_joinmsg`) VALUES ('$user_name','$user_type','$user_email','$user_phone','$user_city','$user_joinmsg')";

		//var_dump($sql);
		$result = $wpdb->query($sql);
		//var_dump($result);
		if (0 < $result) {
			echo "加盟成功！";
		} else {
			echo "<font color='red'>数据插入错误，信息为："+$result+"</font>";
		}

	} else {
		echo "<font color='red'>输入参数有误！</font>";

	}
}
?>
	</h5>
</article>