<?php
session_start();
header("Content-type:text/html;charset=utf-8");
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD','');
define('DB_DATABASE','myblog');
define('DB_PORT', 3306);
date_default_timezone_set('Asia/Shanghai');

define('SA_PATH', dirname(dirname(__FILE__)));
define('SUB_URL', str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', SA_PATH)).'/');
?>
