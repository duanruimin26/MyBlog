<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
include_once 'inc/page.inc.php';
$link=connect();
$member_id=is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php', 'error', '子版块id参数不合法!','css/remind.css');
}
$query="select * from blog_son_module where id={$_GET['id']}";
$result_son=execute($link, $query);
if(mysqli_num_rows($result_son)==0){
    skip('index.php', 'error', '子版块不存在!','css/remind.css');
}
$data_son=mysqli_fetch_assoc($result_son);

$query="select * from blog_father_module where id={$data_son['father_module_id']}";
$result_father=execute($link, $query);
$data_father=mysqli_fetch_assoc($result_father);
$current_item=$data_father['id'];

$query="select count(*) from blog_content where module_id={$_GET['id']}";
$count_all=num($link, $query);
$page=page($count_all,10);

$template['title']="小花匠";
$template['css']=array("css/bootstrap.css","css/font-awesome.css","css/main.css");
?>
<?php include 'inc/header.inc.php';?>
	<!-- 主体部分 -->
	<div id="blog-bodyer">
		<div class="container">
			<div class="row">
				<!-- 主体文章 -->
				<div id="mainstay" class="col-md-8">
				    <div class="breadcrumb blog-breadcrumb">
				        <i class="fa fa-home"></i>
				        <a href="index.php" class="home">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name'];?></a> &gt; <span><?php echo $data_son['module_name'];?></span>
				    </div>
					<!-- 文章列表 -->
					<div id="article-list">
                    <?php 
                    $query="select * from blog_content where module_id={$_GET['id']} order by id desc {$page['limit']}";
                    $result=execute($link, $query);
                    while ($data=mysqli_fetch_assoc($result)){
                    ?>                        					      				
						<div class="article well clearfix">
							<!-- 大型设备文章属性 -->
							<section class="hidden-xs">
								<div class="article-title">
									<h1>
										<a href="content_show.php?id=<?php echo $data['id']?>"><?php echo $data['title']?></a>
									</h1>
								</div>
								<div class="article-tag">
								    <span class="label label-blog">
										<i class="glyphicon glyphicon-calendar"></i>
										<span><?php echo date("y-m-d",strtotime($data['time']))?></span>
									</span>
									<span class="label label-blog">
										<i class="glyphicon glyphicon-tag"></i>
										<span><?php echo $data['tag']?></span>
									</span>
									<span class="label label-blog">
										<i class="glyphicon glyphicon-eye-open"></i>
										<span><?php echo $data['times']?></span>
									</span>
								</div>
								<div class="article-content">
									 <figure class="thumbnail">
									 	<a href="content_show.php?id=<?php echo $data['id']?>">
									 		<img src="<?php echo "admin/".$data['photo']?>" alt="" width=750" height="300" class="attachment-full wp-post-image">
									 	</a>
									 </figure>
									 <div class="alert alert-blog">				
										<?php echo $data['description']?>
									</div>
								</div>
								<a href="content_show.php?id=<?php echo $data['id']?>" class="btn btn-danger pull-right read-more">
									阅读全文
								</a>
							</section>
							<!-- 小型设备文章属性 -->
							<section class="visible-xs">
								<div class="article-title">
									<h4>
										<a href="content_show.php?id=<?php echo $data['id']?>"><?php echo $data['title']?></a>
									</h4>
								</div>
								<p>
									<i class="glyphicon glyphicon-calendar"></i>
									<span><?php echo date("y-m-d",strtotime($data['time']))?></span>
									<i class="glyphicon glyphicon-eye-open"></i>
									<span><?php echo $data['times']?></span>
								</p>
								<div class="article-content">
									 <figure class="thumbnail">
									 	<a href="content_show.php?id=<?php echo $data['id']?>">
									 		<img src="<?php echo "admin/".$data['photo']?>" alt="" width=750" height="300" class="attachment-full wp-post-image">
									 	</a>
									 </figure>
									 <div class="alert alert-blog">				
										<?php echo $data['description']?>
									</div>
								</div>
								<a href="content_show.php?id=<?php echo $data['id']?>" class="btn btn-danger pull-right read-more btn-block">
									阅读全文
								</a>
							</section>
						</div>
					<?php } ?>
					</div>
					<!-- 分页 -->
					<div id="blog-page" class="clearfix">
						<ul class="pagination pagination-blog pull-right">
    						<?php 
                                echo $page['html'];
            				?>
						</ul>
					</div>
				</div>
				<!-- 侧边栏 -->
				<aside id="sidebar" class="col-md-4">
				    <!-- 最热文章 -->
					<aside id="blog-hotest-posts">
						<div class="panel panel-blog hot hidden-xs">
							<div class="panel-heading">
								<i class="glyphicon glyphicon-fire"></i>
								最热文章
							</div>
							<ul class="list-group list-group-flush">
								<?php                            
                                    $query="select * from blog_content order by times desc limit 8";
                                    $result=execute($link, $query);
                                    while ($data=mysqli_fetch_assoc($result)){
                                ?>   
								<li class="list-group-item">
									<span class="post-title">
										<a href="content_show.php?id=<?php echo $data['id'];?>"><?php echo $data['title'];?></a>
									</span>
									<span class="badge"><?php echo $data['times'];?></span>
								</li>
								<?php }?>
							</ul>
						</div>
					</aside>

					<!-- 文章存档 -->
					<aside id="blog-article-archives">
						<div class="panel panel-blog archive hidden-xs">
							<div class="panel-heading">
								<i class="glyphicon glyphicon-book"></i>
								文章存档
							</div>
							<ul class="list-group list-group-flush">
								<?php
								$query="select date_format(time,'%Y') as year,date_format(time,'%m') as month,count(*) as counts from blog_content group by year,month order by year desc,month desc";
								$result_archive=execute($link, $query);
								while ($data_archive=mysqli_fetch_assoc($result_archive)){
									?>
									<li class="list-group-item">
										<span class="post-time">
											<a href="index_time.php?time=<?php echo $data_archive['year'].'/'.$data_archive['month'];?>"><?php echo $data_archive['year']."年".$data_archive['month']."月";?></a>
										</span>
										<span class="badge"><?php echo $data_archive['counts'];?></span>
									</li>
								<?php }?>
							</ul>
						</div>
					</aside>
				</aside>
			</div>
		</div>
	</div>
<?php include 'inc/footer.inc.php';?>

