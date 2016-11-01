<?php
if(empty($_POST['name'])){
    skip("login.php", "error", "用户名不得为空！",'css/remind.css');
}
if(mb_strlen($_POST['name'])>32){
    skip('login.php', 'error', '用户名长度不要超过32个字符！','css/remind.css');
}
if (empty($_POST['pw'])){
    skip('login.php', 'error', '密码不得为空！','css/remind.css');
}
if (strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
    skip('login.php', 'error', '验证码输入错误！','css/remind.css');
}
if(empty($_POST['time'])||is_numeric($_POST['time'])||$_POST['time']>2592000){
    $_POST['time']=2592000;
}
?>