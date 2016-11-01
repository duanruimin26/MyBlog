<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();
$member_id=is_login($link);

if(!isset($_GET['time'])){
    $_GET['time']="";
}
$_GET['time']=trim($_GET['time']);
$_GET['time']=escape($link, $_GET['time']);
$time = explode('/', $_GET['time']);

$template['title']="小花匠";
$template['css']=array("css/bootstrap.css","css/font-awesome.css","css/main.css");
$current_item=0;
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
                    <a href="index.php" class="home">首页</a> &gt; <span><?php echo $time[0]."年".$time[1]."月" ?> 存档</span>
                </div>
                <!-- 文章列表 -->
                <div id="article-list">
                    <?php
                    $query="select count(*) from blog_content where date_format(time,'%Y')=$time[0] and date_format(time,'%m')=$time[1]";
                    $count_all=num($link,$query);
                    $page=page($count_all,10);

                    $query="select * from blog_content where date_format(time,'%Y')=$time[0] and date_format(time,'%m')=$time[1] order by id desc {$page['limit']}";
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
                <!-- 搜索 -->
                <aside id="blog-search">
                    <div class="search">
                        <form action="search.php" class="form-inline clearfix" method="get" id="searchform">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="搜索...">
                            <button type="submit" class="btn btn-danger btn-small">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </form>
                    </div>
                </aside>
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

                <!-- 登录信息 -->
                <?php
                if(isset($member_id) && $member_id){
                    $query="select * from blog_manage where id={$member_id}";
                    $result_user=execute($link, $query);
                    $data_user=mysqli_fetch_assoc($result_user);
                    ?>
                    <!--登录显示内容 -->
                    <aside id="blog-logged">
                        <div class="panel panel-blog">
                            <div class="panel-heading">
                                <i class="glyphicon glyphicon-cloud"></i>
                                欢迎
                            </div>
                            <div class="login-panel text-center">
                                <img src="<?php echo 'admin/'.$data_user['photo']?>" alt="">
                                <a href="admin/index.php" class="user-name"><?php echo $_COOKIE['blog']['name']?></a>
                                <a href="logout.php" class="btn btn-inverse-primary" title="退出登录">退出登录</a>
                            </div>
                        </div>
                    </aside>
                    <!-- 未登录显示内容 -->
                    <?php
                }else{
                    $str=<<<A
        					<aside id="blog-login">
        						<div class="panel panel-blog">
        							 <div class="panel-heading">请登录</div>
        							 <form action="" class="login-form" method="post">
        							 	<div class="form-group">
        							 		<div class="input-group">
        							 			<div class="input-group-addon">
        							 				<i class="glyphicon glyphicon-user"></i>
        							 			</div>
        							 			<input type="text" class="form-control" id="log" name="log" size="20">
        							 		</div>
        							 	</div>
        							 	<div class="form-group">
        							 		<div class="input-group">
        							 			<div class="input-group-addon">
        							 				<i class="glyphicon glyphicon-lock"></i>
        							 			</div>
        							 			<input type="password" class="form-control" id="pwd" name="pwd" size="20">
        							 		</div>
        							 	</div>
        							 	<a class="btn btn-inverse-primary btn-block" type="submit" name="submit" href="login.php" role="button">登录</a>
        							</form>
        						</div>
        					</aside>
A;
                    echo $str;
                }
                ?>
            </aside>
        </div>
    </div>
</div>
<?php include 'inc/footer.inc.php';?>
