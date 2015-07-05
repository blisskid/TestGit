[layerslider id="7"]
<div class="xqFormPage">
	<form id="xqRegisterForm" action="<?php echo get_bloginfo('wpurl') . "/wp-login.php";?>" method="post">
		<table align="center">
		    <tr>
		        <td>
		        	<label for="user_name">请输入用户名：</label>
		            <input style="width:100%" type="text" id="user_name"  name="user_name" placeholder="请输入用户名" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<label for="user_email">请输入邮箱：</label>
		            <input style="width:100%" type="email" id="user_email" name="user_email" placeholder="请输入邮箱" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<label for="user_pass">请输入密码：</label>
		            <input style="width:100%" type="password" id="user_pass" name="user_pass" placeholder="请输入密码" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<label for="repeat_pass">确认密码：</label>
		            <input style="width:100%" type="password" id="repeat_pass" name="repeat_pass" placeholder="请再次输入密码" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<input type="button" onclick="xqRegister()" value="注册"></input>
		         </td>
		    </tr>
		</table>
	</form>
</div>