<?php
if(empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
    skip("publish.php", "error", "所属板块id不合法！",'../css/remind.css');
}
$query="select * from blog_son_module where id={$_POST['module_id']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)!=1){
    skip("publish.php", "error", "请选择一个所属版块！",'../css/remind.css');
}
if(empty($_POST['title']) ){
    skip('publish.php', 'error', '标题不得为空！','../css/remind.css');
}
if(mb_strlen($_POST['title'])>255){
    skip('publish.php', 'error', '标题不得超过255个字符！','../css/remind.css');
}
?>