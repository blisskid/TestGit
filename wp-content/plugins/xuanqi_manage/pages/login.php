<div class="xqFormHat">用户登录</div>
<div class="xqFormPage">
    <form id="xqLoginForm" action="<?php echo get_bloginfo('wpurl');?>" method="post">
        <table align="center">
            <tr>
                <td>
                    <label for="user_name">请输入用户名：</label>
                    <input style="width:100%" type="text" id="user_name"  name="user_name" placeholder="请输入用户名" required></input>
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
                    <label><input id="remember" name="remember" type="checkbox" value="forever"></input>&nbsp;&nbsp;记住密码</label>
                </td>
            </tr>            
            <tr>
                <td>
                    <input type="button" onclick="xqLogin()" value="登录"></input>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.caringyou.com.cn/?p=1158">注册新用户</a>
                 </td>               
            </tr>
            <tr>
                <td>
                    <div id="hintDiv" style="display: none;color: red"></div>
                 </td>
            </tr>            
        </table>
    </form>
</div>