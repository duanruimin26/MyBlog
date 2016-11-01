<?php
    if(empty($_POST['name'])){
        skip('login.php', "error", "管理员名称不得为空！",'../css/remind.css');
    }
    if(mb_strlen($_POST['name'])>32){
        skip('login.php', "error", "管理员名称不得多于32个字符！",'../css/remind.css');
    }
    if(mb_strlen($_POST['pw'])<6){
        skip('login.php', "error", "密码不能少于6位！",'../css/remind.css');
    }
?>
