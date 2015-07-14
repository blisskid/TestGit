<?php
/*
if (isset($_POST["user_name"]) && isset($_POST["user_pass"]) && isset($_POST["remember"])) {

    global $wpdb;
    $user_name = trim($_POST["user_name"]);
    $user_pass = trim($_POST["user_pass"]);
    $remember = $_POST["remember"] == "1" ? true : false;

    $userdata = array(
        'user_login' => $user_name,
        'user_password' => $user_pass,
        'remember' => $remember);
    var_dump($userdata);
    $user_verify = wp_signon($userdata, true);
    var_dump($user_verify);
    if (is_wp_error($user_verify)) {
        echo $user_verify->get_error_message();
    } else {
        //跳转到主页面
        echo '<script type="text/javascript" language="javascript">window.location.href="http://www.caringyou.com.cn";</script>';
    }
} else {
}
*/
?>

<div class="xqFormHat">用户登录</div>
<div class="xqFormPage">
    <form id="xqLoginForm" method="post">
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
                    <input type="button" onclick="xqLogin()" value="登录"></input>
                 </td>
            </tr>
            <tr>
                <td>
                    <div id="hintDiv" style="display: none;"></div>
                 </td>
            </tr>            
        </table>
    </form>
</div>