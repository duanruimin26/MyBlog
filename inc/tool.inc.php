<?php
function skip($url,$pic,$message,$css){
$html=<<<A
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<meta http-equiv="refresh" content="3;URL={$url}"/>
<title>正在跳转中</title>
<link rel="stylesheet" type="text/css" href="{$css}"/>
</head>
<body>
<div class="notice"><span class="pic {$pic}"></span>{$message} <a href="{$url}">3秒后自动跳转</a></div>
</body>
</html>
A;
echo $html;
exit;
}
//验证管理员是否登录,登录则返回管理员的id，否则返回false
function is_login($link){
    if (isset($_COOKIE['blog']['name'])&&isset($_COOKIE['blog']['pw'])){
        $query="select * from blog_manage where name='{$_COOKIE['blog']['name']}' and pw='{$_COOKIE['blog']['pw']}'";
        $result=execute($link, $query);
        if (mysqli_num_rows($result)==1){
            $data=mysqli_fetch_assoc($result);
            return $data['id'];
        }else{
            return false;
        }
    }
}
function check_user($member_id,$content_member_id,$is_manage_login){
    if ($member_id==$content_member_id || $is_manage_login){
        return true;
    }else{
        return false;
    }
}
//验证后台管理员是否登录。登录则返回true，否则返回false
function is_manage_login($link){
    if(isset($_SESSION['manage']['name'])&&isset($_SESSION['manage']['pw'])){
        $query="select * from blog_manage where name='{$_SESSION['manage']['name']}' and pw='{$_SESSION['manage']['pw']}'";
        $result=execute($link, $query);
        if(mysqli_num_rows($result)==1){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
?>
