<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if($member_id=is_login($link)){
    skip('index.php', 'error', '你已经登录，请不要重复登录！','css/remind.css');
}
if(isset($_POST['submit'])){
    include 'inc/check_login_inc.php';
    $_POST=escape($link, $_POST);
    $query="select * from blog_manage where name='{$_POST['name']}' and pw='{$_POST['pw']}'";
    $result=execute($link, $query);
    if(mysqli_num_rows($result)==1){
        setcookie('blog[name]',$_POST['name'],time()+$_POST['time']);
        setcookie('blog[pw]',$_POST['pw'],time()+$_POST['time']);
        skip('index.php', 'ok', '登录成功！','css/remind.css');
    }else{
        skip('login.php', 'error', '用户名或密码填写错误！','css/remind.css');
    }
}
$template['title']="会员登录";
$template['css']=array("css/bootstrap.css","css/main.css","css/login.css");
?>
<?php include 'inc/header.inc.php';?>
	<div id="login">
		<form method="post">
			<label>用户名：<input type="text" name="name" class="input"/><span></span></label>
			<label>密码：<input type="password" name="pw" class="input"/><span></span></label>
			<label>验证码：<input name="vcode" type="text" class="input"/><span>*请输入下方验证码</span></label>
			<img class="vcode" src="show_code.php" />
			<label>自动登录：
				<select name="time" class="input">
					<option value="3600">1小时内</option>
					<option value="86400">1天内</option>
					<option value="259200">3天内</option>
					<option value="2592000">30天内</option>
				</select>
				<span>*公共电脑上请勿长期自动登录</span>
			</label>
			<input class="btn" type="submit" name="submit" value="登录" />
		</form>
	</div>
<?php include 'inc/footer.inc.php';?>
