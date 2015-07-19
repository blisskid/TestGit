<div class="xqFormHat">找回密码</div>
<div class="xqFormPage">
	<form id="xqFindPasswordForm" action="http://www.caringyou.com.cn/重置密码" method="post">
		<table align="center">
		    <tr>
		        <td>
		        	<label for="user_name">请输入用户名：</label>
		            <input style="width:100%" type="text" id="user_name"  name="user_name" placeholder="请输入用户名" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <input style="width:100%" type="text" pattern="[0-9]{11}" title="请输入11位手机号码" id="user_phone" name="user_phone" placeholder="请输入注册手机号码" required></input>
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
		        	<input type="button" onclick="xqFindPassword()" value="下一步"></input>
		         </td>
		    </tr>
		</table>
	</form>
</div>