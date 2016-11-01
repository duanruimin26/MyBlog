<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
if (is_manage_login($link)){
    skip('index.php', 'ok', '您已经登录，请不要重复登录！','../css/remind.css');
}

if(isset($_POST['submit'])){
    include_once 'inc/check_login.inc.php';
    $_POST=escape($link, $_POST);
    $query="select * from blog_manage where name='{$_POST["name"]}' and pw='{$_POST["pw"]}'";
    $result=execute($link, $query);
    if (mysqli_num_rows($result)==1){
        $data=mysqli_fetch_assoc($result);
        $_SESSION['manage']['name']=$data['name'];
        $_SESSION['manage']['pw']=$data['pw'];
        $_SESSION['manage']['id']=$data['id'];
        $_SESSION['manage']['photo']=$data['photo'];
        $_SESSION['manage']['email']=$data['email'];
        skip('index.php', 'ok', '登录成功！','../css/remind.css');        
    }else{
        skip('login.php', 'error', '用户名或者密码错误，请重试！','../css/remind.css');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Head部分 -->
<head>
    <meta charset="UTF-8">
    <title>小花匠-后台登录</title>
    <meta name="keywords" content="后台登录" />
    <meta name="description" content="后台登录" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<div class="login-container fadeInDown">
		<div class="loginbox">
			<div class="loginbox-title">后台登录</div>
			<form method="post">
				<div class="loginbox-textbox">
					<input type="text" class="form-control" placeholder="用户名" name="name">
				</div>
				<div class="loginbox-textbox">
					<input type="text" class="form-control" placeholder="密码" name="pw">
				</div>
				<div class="loginbox-submit">
					<input type="submit" class="btn btn-primary btn-block" value="登录" name="submit">
				</div>
			</form>
		</div>
	</div>
</body>
</html>