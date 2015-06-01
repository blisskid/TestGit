<?php
$txt = "hello";

// 以下的邮箱地址改成你的
$mail = '172542114@qq.com';

// 发送邮件
//var_dump(mail($mail, "My subject", $txt));

//echo 'message was sent!';

$to = '172542114@qq.com';
$subject = 'php mail test';
$message = 'hello';
//$headers = 'From: webmaster@example.com' . "\r\n" . 'Reply-To: webmaster@example.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

$res = mail($to, $subject, $message);
var_dump($res);
?>