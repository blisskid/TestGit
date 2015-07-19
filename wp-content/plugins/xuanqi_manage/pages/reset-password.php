<?php
echo '<div class="xqFormHat">重置密码</div>';
echo '<div class="xqFormPage">';
if (isset($_POST["user_name"]) && isset($_POST["user_phone"]) && isset($_POST["vnumber"])) {
	//判断用户和手机号码是否正确
	$user_id = username_exists($_POST["user_name"]);
	//var_dump($user_id);
	if ($user_id != null) {
		$user_phone = get_usermeta($user_id, 'phone');
		//var_dump($user_phone);
		if ($user_phone == $_POST["user_phone"]) {
?>
	<form id="xqResetForm" action="http://www.caringyou.com.cn//login/" method="post">
		<table align="center">
		    <tr>
		        <td>
		        	<label for="user_pass">请输入新密码：</label>
		            <input style="width:100%" type="password" id="user_pass" name="user_pass" placeholder="请输入密码" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<label for="repeat_pass">请重新输入密码：</label>
		            <input style="width:100%" type="password" id="repeat_pass" name="repeat_pass" placeholder="请再次输入密码" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<input type="button" onclick="xqResetPassword()" value="重置密码"></input>
		        	<input type="hidden" id="user_name" name="user_name" value="<?php echo $_POST["user_name"];?>"></input>
		         </td>
		    </tr>
		</table>
	</form>
<?php		
		} else {
			echo "<font color='red'>手机号码不正确！</font>";
		}
	} else {
		echo "<font color='red'>用户不存在！</font>";
	}
}
echo "</div>";
?>