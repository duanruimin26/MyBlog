<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
if (!is_manage_login($link)){    
    header('Location:login.php');
    exit();
}

$query="select * from blog_info where id=1";
$result_info=execute($link, $query);
$data_info=mysqli_fetch_assoc($result_info);

if(isset($_POST['submit'])){
    $_POST=escape($link, $_POST);
    $query="update blog_info set title='{$_POST['title']}',keywords='{$_POST['keywords']}',description='{$_POST['description']}'";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        skip("web_set.php", "ok", "修改成功！",'../css/remind.css');
    }else{
        skip("web_set.php", "error", "修改失败，请重试！",'../css/remind.css');
    }
}

$template['title']="小花匠-后台管理";
$template['css']=array("../css/bootstrap.css","../css/font-awesome.css","../css/style.css");
?>
<?php include 'inc/header.inc.php';?>
    <div class="page-content">
		<div class="page-breadcrumbs">
			<div class="breadcrumb">
				系统 > 网站设置 
			</div>
		</div>
		<div class="page-body">
    		<form method="post">
    		<table class="au" id="webset">
    			<tr>
    				<td>网站标题</td>
    				<td><input name="title" type="text" value="<?php echo $data_info['title']?>"/></td>
    				<td>
    					就是前台页面的标题
    				</td>
    			</tr>
    			<tr>
    				<td>关键字</td>
    				<td><input name="keywords" type="text"  value="<?php echo $data_info['keywords']?>"/></td>
    				<td>
    					关键字
    				</td>
    			</tr>
    			<tr>
    				<td>描述</td>
    				<td>
    				    <textarea name="description"><?php echo $data_info['description']?></textarea>
    				</td>
    				<td>
    					描述
    				</td>
    			</tr>
    		</table>
    		<input class="webset-btn" type="submit" name="submit" value="设置" />
    		</form>
		</div>
	</div>
<?php include 'inc/footer.inc.php';?>