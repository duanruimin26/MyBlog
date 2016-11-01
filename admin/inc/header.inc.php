<!DOCTYPE html>
<html lang="zh-CN">
<!-- Head部分 -->
<head>
    <meta charset="UTF-8">
    <title><?php echo $template['title'];?></title>
    <meta name="keywords" content="后台界面" />
    <meta name="description" content="后台界面" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php 
        foreach ($template['css'] as $val){
            echo "<link rel='stylesheet' type='text/css' href='{$val}' />";
        }
    ?>
</head>
<body>
    <!-- 导航栏 -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="navbar-container clearfix">
				<!-- 导航栏标题 -->
				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						小花匠-后台管理
					</a>
				</div>
				<!-- 网站首页链接 -->
				<div class="web-home">
					<a href="../index.php" title="网站首页">
						<i class="collapse-icon fa fa-home"></i>
					</a>
				</div>
				<!-- 登录信息和设置 -->
				<?php 
    				$query="select * from blog_manage where id={$_SESSION['manage']['id']}";
                    $result_manage=execute($link, $query);
                    $data_manage=mysqli_fetch_assoc($result_manage);
                ?>
				<div class="navbar-header pull-right">
					<div class="account-info">
						<a class="login-info pull-left">
							<div class="portrait">
								<img src="<?php echo $data_manage['photo']?>" alt="">
							</div>
							<span class="profile"><?php echo $_SESSION['manage']['name']?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="email">
								<a><?php echo $_SESSION['manage']['email']?></a>
							</li>
							<li>
								<div class="portrait-area">
									<img src="<?php echo $data_manage['photo']?>" alt="">
									<a href="photo_update.php"><span class="caption">更换头像</span></a>
								</div>
							</li>
						</ul>
						<a class="logout pull-left" href="logout.php" title="注销">
							<i class="fa fa-gear"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 页面 -->
	<div class="main-container container-fluid">
		<div class="page-container">
			<div class="page-sidebar">
				<ul class="nav sidebar-menu">
					<li>
						<a class="menu-dropdown">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text">系统</span>
							<i class="menu-icon fa fa-angle-down"></i>
						</a>
						<ul class="submenu">
							<li <?php if(basename($_SERVER['SCRIPT_NAME'])=='index.php'){echo 'class="active"';}?>>
								<a href="index.php">
									<span class="menu-text">系统信息</span>
								</a>
							</li>
							<li  <?php if(basename($_SERVER['SCRIPT_NAME'])=='web_set.php'){echo 'class="active"';}?>>
								<a href="web_set.php">
									<span class="menu-text">网站设置</span>
								</a>
							</li>
						</ul>
					</li>
					<li>
						<a class="menu-dropdown">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text">内容管理</span>
							<i class="menu-icon fa fa-angle-down"></i>
						</a>
						<ul class="submenu">
							<li <?php if(basename($_SERVER['SCRIPT_NAME'])=='publish.php'){echo 'class="active"';}?>>
								<a href="publish.php">
									<span class="menu-text">发布帖子</span>
								</a>
							</li>
							<li>
								<a target="_blank" href="../index.php">
									<span class="menu-text">帖子修改</span>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
