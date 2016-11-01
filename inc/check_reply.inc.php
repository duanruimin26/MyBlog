<?php
if(empty($_POST['form-name'])){
    skip($_SERVER['REQUEST_URI'], 'error', '名称不得为空！','css/remind.css');
}
if(empty($_POST['form-email'])){
    skip($_SERVER['REQUEST_URI'],'error', '邮件地址不得为空！','css/remind.css');
}
if(!filter_var($_POST['form-email'], FILTER_VALIDATE_EMAIL)){
    skip($_SERVER['REQUEST_URI'],'error', '请输入有效的邮件地址！','css/remind.css');
}

$form_email=explode('@',$_POST['form-email']);
$domain=$form_email[count($form_email)-1];
if (!checkdnsrr($domain, 'MX')) {
    skip($_SERVER['REQUEST_URI'],'error', '输入邮件的域名无效！','css/remind.css');
}
if(empty($_POST['comment'])){
    skip($_SERVER['REQUEST_URI'],'error', '内容不得为空！','css/remind.css');
}
if(mb_strlen($_POST['comment'])<3){
    skip($_SERVER['REQUEST_URI'], 'error', '对不起回复内容不得少于3个字！','css/remind.css');
}
?>