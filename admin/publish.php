<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
include_once 'inc/upload.inc.php';
$link=connect();
if (!is_manage_login($link)){
    header('Location:login.php');
    exit();
}

if(isset($_POST['submit'])){
    include 'inc/check_publish.inc.php';
    $save_path='uploads/'.date('Y/m/d');
    $upload=upload($save_path,'8M','themeImg');
    
    $_POST=escape($link, $_POST);
    
    $query="insert into blog_content (module_id,title,tag,description,content,photo,time) VALUES ({$_POST['module_id']},'{$_POST['title']}','{$_POST['tag']}','{$_POST['description']}','{$_POST['content']}','{$upload['save_path']}',now())";
    execute($link, $query);
    if (mysqli_affected_rows($link)==1){
        skip('publish.php', 'ok', '发布成功！','../css/remind.css');
    }else{
        skip('publish.php', 'error', '发布失败，请重试！','../css/remind.css');
    }
}
$template['title']="发布帖子";
$template['css']=array("../css/bootstrap.css","../css/font-awesome.css","../css/style.css","../css/summernote.css");
?>
<?php include 'inc/header.inc.php';?>
    <div class="page-content">
		<div class="page-breadcrumbs">
			<div class="breadcrumb">
				内容管理 > 发布帖子 
			</div>
		</div>
		<div class="page-body">
    		<div id="publish">
            	<form method="post" enctype="multipart/form-data">
            		<select name="module_id">
            		    <option value='-1'>请选择一个子版块</option>
            			<?php 
            			$query="select * from blog_father_module order by id";
            			$result_father=execute($link, $query);
            			while($data_father=mysqli_fetch_assoc($result_father)){
            			    echo "<optgroup label='{$data_father['module_name']}'>";
            			    $query="select * from blog_son_module where father_module_id={$data_father['id']} order by id";
            			    $result_son=execute($link, $query);
            			    while ($data_son=mysqli_fetch_assoc($result_son)){
            			        echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
            			    }
            			    echo "</optgroup>";
            			}
            			?>			
            		</select>
            		<input class="title" placeholder="请输入标题" name="title" type="text" />
            		<input class="tag" placeholder="请输入标签" name="tag" type="text" />
            		<input style="cursor: pointer" name="themeImg" type="file"/>
            		<span style="display:block;margin: 5px 0 20px;color: #737373">请选择主题图片</span>
            		<textarea class="description" placeholder="请输入描述" name="description" rows="3" /></textarea>
            		<div id="summernote"></div>
            		<textarea id="content" class="hidden" name="content"></textarea>
            		<input class="publish" type="submit" name="submit" value="发布" />
            	</form>
        	</div>
        </div>
	</div>
<?php include 'inc/footer.inc.php';?>