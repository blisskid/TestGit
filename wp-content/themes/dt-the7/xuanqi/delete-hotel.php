<?php

$current_user = wp_get_current_user();
$wpurl = get_bloginfo('wpurl');

if (0 == $current_user->ID) {

	echo "用户未登录！";

} else {

	if (isset($_POST["ids"])) {
		global $wpdb;
		$ids = $_POST["ids"];
		$sql = "DELETE FROM xq_hotels WHERE ID in ($ids)";

		$result = $wpdb->query($sql);
		//var_dump($result);
		if (0 < $result) {
			echo "删除成功，删除了" . $result . "条记录";
		} else {
			echo "删除失败，信息为："+$result;
		}

	} else {
		echo "数据不完整!";
	}

}

?>
