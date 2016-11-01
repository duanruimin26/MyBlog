<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link=connect();
$member_id=is_login($link);

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php', 'error', '帖子id参数不合法!','css/remind.css');
}
// 获取帖子信息
$query="select * from blog_content where id={$_GET['id']}";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)==0){
    skip('index.php', 'error', '本帖子不存在!','css/remind.css');
}
$query="update blog_content set times=times+1 where id={$_GET['id']}";
execute($link, $query);

$data_content=mysqli_fetch_assoc($result_content);
$data_content['times']=$data_content['times']+1;
$data_content['title']=htmlspecialchars($data_content['title']);
// 获取面包屑需要的子版块信息
$query="select * from blog_son_module where id={$data_content['module_id']}";
$result_son=execute($link, $query);
$data_son=mysqli_fetch_assoc($result_son);
// 获取面包屑需要的父版块信息
$query="select * from blog_father_module where id={$data_son['father_module_id']}";
$result_father=execute($link, $query);
$data_father=mysqli_fetch_assoc($result_father);

// 根据评论数分页
$query="select count(*) from blog_reply where content_id={$_GET['id']}";
$count_reply=num($link, $query);
$page_size=3;
$page=page($count_reply,$page_size);

// 提交评论
if(isset($_POST['submit'])){
    include 'inc/check_reply.inc.php';
    $_POST=escape($link, $_POST);
    if(isset($_GET['reply_id'])){
        $query="insert into blog_reply (name,email,content_id,quote_id,content,time) values ('{$_POST['form-name']}','{$_POST['form-email']}',{$_GET['id']},{$_GET['reply_id']},'{$_POST['comment']}',now())";

    }else{
        $query="insert into blog_reply (name,email,content_id,content,time) values ('{$_POST['form-name']}','{$_POST['form-email']}',{$_GET['id']},'{$_POST['comment']}',now())";

    }
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){
        $query="select count(*) from blog_reply where content_id={$_GET['id']}";
        $count_reply=num($link, $query);
        $pages=ceil($count_reply/$page_size);
        skip("content_show.php?id={$_GET['id']}&&page={$pages}", 'ok', '评论成功!','css/remind.css');
    }else{
        skip($_SERVER['REQUEST_URI'], 'error', '回复失败，请重试!','css/remind.css');
    }
}

$template['title']="小花匠";
$template['css']=array("css/bootstrap.css","css/font-awesome.css","css/main.css");
$current_item=$data_father['id'];
?>
<?php include 'inc/header.inc.php';?>
    <!-- 主体部分 -->
	<div id="blog-bodyer">
		<div class="container">
			<div class="row">
                <!-- 主体文章 -->
                <div class="col-md-8">
                    <!-- 文章显示 -->
                    <article class="article container well">
                        <!-- 面包屑 -->
                        <div class="breadcrumb">
                            <i class="fa fa-home"></i>
                            <a href="index.php" class="home">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a> &gt; <a href="list_son.php?id=<?php echo $data_son['id']?>"><?php echo $data_son['module_name']?></a> &gt; <?php echo $data_content['title']?>
                        </div>
                        <!-- 大型设备文章属性 -->
                        <div class="hidden-xs">
                            <div class="title-article">
                                <h1>
                                    <?php echo $data_content['title']?>
                                </h1>
                            </div>
                            <div class="tag-article container">
                                <span class="label label-blog">
                                    <i class="fa fa-tags"></i>
                                    <span><?php echo date("y-m-d",strtotime($data_content['time']))?></span>
                                </span>
                                <span class="label label-blog">
                                    <i class="fa fa-tags"></i>
                                    <span><?php echo $data_content['tag']?></span>
                                </span>
                                <span class="label label-blog">
                                    <i class="fa fa-eye"></i>
                                    <span><?php echo $data_content['times']?></span>
                                </span>
                            </div>
                        </div>
                        <!-- 小型设备文章属性 -->
                        <div class="visible-xs">
                            <div class="title-article">
                                <h4>
                                    <?php echo $data_content['title']?>
                                </h4>
                            </div>
                            <p>
                                <i class="fa fa-calendar"></i>
                                <span><?php echo date("y-m-d",strtotime($data_content['time']))?></span>
                                <i class="fa fa-eye"></i>
                                <span><?php echo $data_content['times']?></span>
                            </p>
                        </div>
                        <!-- 文章内容 -->
                        <div class="content-article">
                            <figure class="thumbnail hidden-xs">
                                <img width="750" height="300" src="<?php echo "admin/".$data_content['photo']?>" class="attachment-full wp-post-image" alt="" />
                            </figure>
                            <!-- summernote输入内容 -->
                            <div class="article-words">
                                <?php echo $data_content['content']?>
                            </div>
                        </div>                                                 
                    </article>
                    <!-- 评论 -->
                    <div id="comments-template">
                        <div class="comments-wrap">
                            <!-- 已有评论 -->
                            <div id="comments">
                                <h3 id="comments-title" class="comments-header alert alert-info">
                                    <i class="fa fa-comments"></i>
                                    <?php echo $count_reply;?>条评论
                                </h3>                                          				
                                <ol class="commentlist" style="display: block;">
                                    <?php 
                                    	$query="select * from blog_reply where content_id={$_GET['id']} order by id asc {$page['limit']}";
                                    	$result_reply=execute($link, $query);
                                    	$i=($_GET['page']-1)*$page_size+1;
                                    	while($data_reply=mysqli_fetch_assoc($result_reply)){
                                    	    $data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
                                	?>
                                    <li class="comment">
                                        <article class="comment-body">
                                            <footer class="comment-meta">
                                                <div class="comment-author">
                                                    <img src="<?php $query='select * from blog_manage';$result_manage=execute($link, $query);$data_manage=mysqli_fetch_assoc($result_manage);if($data_reply['name']==$data_manage['name']){echo 'admin/'.$data_manage['photo'];}else{echo 'image/portrait.png';}?>" height="70" width="70">
                                                    <b class="fn"><?php echo $data_reply['name']?></b>
                                                    <span class="says">说道：</span>
                                                </div>
                                                <div class="comment-metadata">
                                                    <time><?php echo $data_reply['time']?></time>
                                                    <span style="font-weight: bold">&nbsp;&nbsp;<?php echo $i++?>楼&nbsp;|&nbsp;<a href="content_show.php?id=<?php echo $_GET['id']?>&&page=<?php echo $_GET['page']?>&&reply_id=<?php echo $data_reply['id']?>">引用</a></span>
                                                </div>
                                            </footer>
                                            <div class="comment-content">
                                                <p><?php echo $data_reply['content']?></p>
                                            </div>
                                        </article>
                                        <?php 
                                    		if($data_reply['quote_id']){ 
                                    		    $query="select count(*) from blog_reply where content_id={$_GET['id']} and id<={$data_reply['quote_id']}";
                                    		    $floor=num($link, $query);
                                    		    $query="select * from blog_reply where id={$data_reply['quote_id']}";
                                    		    $result_quote=execute($link, $query);
                                    		    $data_quote=mysqli_fetch_assoc($result_quote);
                                        ?>
                                        <ol class="children">
                                            <li class="comment">
                                                <article class="comment-body">
                                                    <footer class="comment-meta">
                                                        <div class="comment-author">
                                                            <span>引用 <?php echo $floor?>楼 </span> 
                                                            <b class="fn"><?php echo $data_quote['name']?></b>
                                                            <span class="says">发表的：</span>
                                                        </div>
                                                        <div class="comment-metadata">
                                                            <time><?php echo $data_quote['time']?></time>
                                                        </div>
                                                    </footer>
                                                    <div class="comment-content">
                                                        <p><?php echo nl2br(htmlspecialchars($data_quote['content']))?></p>
                                                    </div>
                                                </article>
                                            </li>
                                        </ol>
                                        <?php }?>
                                    </li>
                                    <?php }?>
                                </ol>
                                <nav id="comment-nav" class="clearfix">
                                    <ul class="pagination pagination-blog pull-right">
            							<?php echo $page['html'];?>
            						</ul>
                                </nav>
                            </div>
                            <!-- 添加评论 -->
                            <div id="respond" class="comment-respond">
                                <h3 id="reply-title" class="comment-reply-title">
                                    <i class="fa fa-pencil">
                                    </i>
                                                                                                                              欢迎留言                                                                                         
                                </h3>
                                <?php 
                                    if(isset($_GET['reply_id'])){
                                        $comment_url="content_show.php?id={$_GET['id']}&&page={$_GET['page']}&&reply_id={$_GET['reply_id']}";
                                        $query="select count(*) from blog_reply where content_id={$_GET['id']} and id<={$_GET['reply_id']}";
                                        $floor=num($link, $query);
                                        $query="select * from blog_reply where id={$_GET['reply_id']}";
                                        $result_quote=execute($link, $query);
                                        $data_quote=mysqli_fetch_assoc($result_quote);
                                ?>
                                <ol class="commentlist children">
                                    <li class="comment">
                                        <article class="comment-body">
                                            <footer class="comment-meta">
                                                <div class="comment-author">
                                                    <span>引用 <?php echo $floor?>楼 </span> 
                                                    <b class="fn"><?php echo $data_quote['name']?></b>
                                                    <span class="says">发表的：</span>
                                                </div>
                                                <div class="comment-metadata">
                                                    <time><?php echo $data_quote['time']?></time>
                                                </div>
                                            </footer>
                                            <div class="comment-content">
                                                <p><?php echo nl2br(htmlspecialchars($data_quote['content']))?></p>
                                            </div>
                                        </article>
                                    </li>
                                </ol>
                                <?php }else{
                                    $comment_url="content_show.php?id={$_GET['id']}&&page={$_GET['page']}";
                                }
                                
                                ?>                       
                                <form method="post" id="commentform" class="comment-form" action="<?php echo $comment_url;?>">
                                <?php if($member_id){
                                    $query="select * from blog_manage where id={$member_id}";
                                    $result_manage=execute($link, $query);
                                    $data_manage=mysqli_fetch_assoc($result_manage);
                                ?>
                                    <input type="input" name="form-name" class="form-info" value="<?php echo $data_manage['name']?>">
                                    <input type="input" name="form-email" class="form-info" value="<?php echo $data_manage['email']?>">
                                <?php 
                                    }else{
                                ?>
                                    <input type="input" name="form-name" class="form-info" placeholder="名称（必须）">
                                    <input type="input" name="form-email" class="form-info" placeholder="邮件地址（不会被公开）（必须）">
                                <?php }?>
                                    <textarea name="comment" rows="3" cols="45" placeholder="赶快发表你的见解吧"></textarea>
                                    <input type="submit" name="submit" id="submit" value="发表评论">
                                </form>
                            </div>
                        </div>
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