<div class="xqFormHat">用户注册</div>
<div class="xqFormPage">
	<form id="xqRegisterForm" action="<?php echo get_bloginfo('wpurl') . "/login/";?>" method="post">
		<table align="center">
		    <tr>
		        <td>
		        	<label for="user_name">请输入用户名：</label>
		            <input style="width:100%" type="text" id="user_name"  name="user_name" placeholder="请输入用户名" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <input style="width:100%" type="text" pattern="[0-9]{11}" title="请输入11位手机号码" id="user_phone" name="user_phone" placeholder="请输入11位手机号码" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<input type="button" value="获取验证码" onclick="joinUsmobileValidation(this)"/>
		        	<input id="revnumber" type="hidden" name="revnumber"/>
					<input style="width:100%" id="vnumber" type="text" value="" name="vnumber" placeholder="请输入4位验证码" required/>
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