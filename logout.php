<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
    skip('index.php', 'error', '你没有登录，不需要退出！','css/remind.css');
}
setcookie('blog[name]','',time()-3600);
setcookie('blog[pw]','',time()-3600);
skip('index.php', 'ok', '退出成功！','css/remind.css');
?>