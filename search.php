<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();
$member_id=is_login($link);

if(!isset($_GET['keyword'])){
    $_GET['keyword']="";
}
$_GET['keyword']=trim($_GET['keyword']);
$_GET['keyword']=escape($link, $_GET['keyword']);
$query="select count(*) from blog_content where title like '%{$_GET['keyword']}%'";
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
				        <a href="index.php" class="home">首页</a> &gt; <span>搜索结果 '<?php echo $_GET['keyword']?>'</span>
				    </div>
					<!-- 文章列表 -->
					<div id="article-list">
                    <?php 
                    $query="select * from blog_content where title like '%{$_GET['keyword']}%' order by id desc {$page['limit']}";
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
										<span><?php echo $data['time']?></span>
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
									<span><?php echo $data['time']?></span>
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
