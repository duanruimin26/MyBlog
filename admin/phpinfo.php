<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
if (!is_manage_login($link)){    
    header('Location:login.php');
    exit();
}
phpinfo();
?>
