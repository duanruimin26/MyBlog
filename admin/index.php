<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
if (!is_manage_login($link)){    
    header('Location:login.php');
    exit();
}

$query="select * from blog_manage where id={$_SESSION['manage']['id']}";
$result_manage=execute($link, $query);
$data_manage=mysqli_fetch_assoc($result_manage);

$query="select count(*) from blog_father_module";
$count_father_module=num($link, $query);

$query="select count(*) from blog_son_module";
$count_son_module=num($link, $query);

$query="select count(*) from blog_content";
$count_content=num($link, $query);

$query="select count(*) from blog_reply";
$count_reply=num($link, $query);

$query="select count(*) from blog_manage";
$count_manage=num($link, $query);

$template['title']="小花匠-后台管理";
$template['css']=array("../css/bootstrap.css","../css/font-awesome.css","../css/style.css");
?>
<?php include 'inc/header.inc.php';?>
    <div class="page-content">
		<div class="page-breadcrumbs">
			<div class="breadcrumb">
				系统 > 系统信息 
			</div>
		</div>
		<div class="page-body">
			<div class="explain">
        		<ul>
        			<li>|- 您好，<?php echo $data_manage['name']?></li>
        			<li>|- 创建时间：<?php echo $data_manage['create_time']?></li>
        		</ul>
        	</div>
        	<div class="explain">
        		<ul>
        			<li>|- 父版块(<?php echo $count_father_module?>) 
            			           子版块(<?php echo $count_son_module?>) 
            			           帖子(<?php echo $count_content?>) 
            			           回复(<?php echo $count_reply?>) 
            			           管理员(<?php echo $count_manage?>)
        			</li>
        		</ul>
        	</div>
        	<div class="explain">
        		<ul>
        			<li>|- 服务器操作系统：<?php echo PHP_OS?></li>
        			<li>|- 服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE']?> </li>
        			<li>|- MySQL 版本：<?php echo mysqli_get_server_info($link)?></li>
        			<li>|- 最大上传文件：<?php echo ini_get('upload_max_filesize')?></li>
        			<li>|- 内存限制：<?php echo ini_get('memory_limit')?></li>
        			<li>|- <a target="_blank" href="phpinfo.php">PHP 配置信息</a></li>
        		</ul>
        	</div>
        	
        	<div class="explain">
        		<ul>
        			<li>|- 程序安装位置(绝对路径)：<?php echo SA_PATH?></li>
        			<li>|- 程序在web根目录下的位置(首页的url地址)：<?php echo SUB_URL?></li>
        			<li>|- 程序版本：myblog V1.0 <a target="_blank" href="http://www.dayuandme.com">[查看最新版本]</a></li>
        			<li>|- 程序作者：段瑞敏</li>
        			<li>|- 网站：<a target="_blank" href="http://www.dayuandme.com">www.dayuandme.com</a></li>
        		</ul>
        	</div>
		</div>
	</div>
<?php include 'inc/footer.inc.php';?>

