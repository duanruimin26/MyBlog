<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once 'inc/upload.inc.php';
$link=connect();
if (!is_manage_login($link)){    
    header('Location:login.php');
    exit();
};
$query="select * from blog_manage where id={$_SESSION['manage']['id']}";
$result_manage=execute($link, $query);
$data_manage=mysqli_fetch_assoc($result_manage);

if (isset($_POST['submit'])){
    $save_path='uploads/'.date('Y/m/d/');
    $upload=upload($save_path,'8M','photo');
    if($upload['return']){
        $query="update blog_manage set photo='{$upload['save_path']}' where id={$_SESSION['manage']['id']}";
        execute($link, $query);
        if (mysqli_affected_rows($link)==1){
            skip("index.php", "ok", "头像设置成功","../css/remind.css");
        }else{
            skip("photo_update.php","error","头像设置失败，请重试！","../css/remind.css");
        }
    }else{
        skip("photo_update.php","error",$upload['error'],"../css/remind.css");
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<style type="text/css">
body {
	font-size:12px;
	font-family:微软雅黑;
}
h2 {
	padding:0 0 10px 0;
	border-bottom: 1px solid #e3e3e3;
	color:#444;
}
.submit {
	background-color: #3b7dc3;
	color:#fff;
	padding:5px 22px;
	border-radius:2px;
	border:0px;
	cursor:pointer;
	font-size:14px;
}
#main {
	width:80%;
	margin:0 auto;
}
</style>
</head>
<body>
	<div id="main">
		<h2>更改头像</h2>
		<div>
			<h3>原头像：</h3>
			<img src="<?php if($data_manage['photo']!=''){echo $data_manage['photo'];}else{echo '../image/photo.jpg';}?>">
		    <br>
		               最佳图片尺寸：180*180
		</div>
		<div style="margin:15px 0 0 0;">
			<form method="post" enctype="multipart/form-data">
				<input style="cursor:pointer;" name="photo" width="100" type="file" /><br /><br />
				<input class="submit" type="submit" name="submit" value="保存" />
			</form>
		</div>
	</div>
</body>
</html>