<?php 
$query="select * from blog_info where id=1;";
$result_info=execute($link, $query);
$data_info=mysqli_fetch_assoc($result_info);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title><?php echo $template['title']?> - <?php echo $data_info['title']?></title>
	<meta name="keywords" content="<?php echo $data_info['keywords']?>">
	<meta name="description" content="<?php echo $data_info['description']?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" />
	<?php 
	   foreach ($template['css'] as $val){
	       echo "<link rel='stylesheet' href='{$val}'>";
	   }
	   echo "\n";
	?>
</head>
<body>
	<!-- 头部 -->
	<header id="blog-header" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a href="index.php">
					<div class="navbar-brand">小花匠</div>					
				</a>
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="fa fa-reorder fa-lg"></span>
				</button>
			</div>
			<nav class="navbar-collapse bs-navbar-collapse collapse">
				<ul id="menu-navbar" class="nav navbar-nav">
					<li>
						<a title="博客首页" href="index.php">
							<i class="fa fa-home"></i>  首页
						</a>
					</li>
					<?php 
                    $icons=array('fa fa-cog','fa fa-magic','fa fa-download');
                    $icons_i=0;
                    $header_query="select * from blog_father_module order by id";
                    $header_result_father=execute($link, $header_query);                        
                    while ($header_data_father=mysqli_fetch_assoc($header_result_father)){    
                    ?>
                        <li class="dropdown">
                        	<a class="dropdown-toggle"  data-toggle="dropdown"><i class="<?php echo $icons[$icons_i];?>"></i>  <?php echo $header_data_father['module_name']?></a>
                        	<ul class="dropdown-menu">
                                <?php 
                                $header_query="select * from blog_son_module where father_module_id={$header_data_father['id']} order by id";
                                $header_result_son=execute($link, $header_query);
                                while ($header_data_son=mysqli_fetch_assoc($header_result_son)){
                                ?>
                            		<li>
                            			<a href="list_son.php?id=<?php echo $header_data_son['id'];?>"><?php echo $header_data_son['module_name']?></a>
                            		</li>
                                <?php }?>						
                        	</ul>
                        </li>
					<?php $icons_i++;}?>					
				</ul>
			</nav>
		</div>
	</header>