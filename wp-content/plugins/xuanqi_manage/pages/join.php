[layerslider id="4"]
<div class="xqFormPage">
	<form name="addUserForm" action="<?php echo get_bloginfo('wpurl') . "/加盟成功";?>" method="post">
		<table align="center">
		    <tr>
		        <td>
					<input type="radio" name="user_type" value="0" checked>个人
					<input type="radio" name="user_type" value="1">企业
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <input style="width:100%" type="text" id="user_name"  name="user_name" placeholder="请输入姓名/企业姓名" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <input style="width:100%" type="email" id="user_email" name="user_email" placeholder="请输入邮箱" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <input style="width:100%" type="text" pattern="[0-9]{11}" title="请输入11位手机号码" id="user_phone" name="user_phone" placeholder="请输入11位手机号码" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <input style="width:100%" type="text" id="user_city" name="user_city" placeholder="请输入加盟地区" required></input>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <textarea style="width:100%;height: 100px" id="user_joinmsg" name="user_joinmsg" placeholder="请留言"></textarea>
		        </td>
		    </tr>
		    <tr>
		        <td>
		        	<button type="submit">加盟我们</button>
		         </td>
		    </tr>
		</table>
	</form>
</div>