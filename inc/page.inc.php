<?php 
/*
调用：$page=page(100,10,9);
返回值：array('limit','html')
 参数说明：
$count：总记录数
$page_size：每页显示的记录数
$num_btn：要展示的页码按钮数目
$page：分页的get参数
*/
function page($count,$page_size,$num_btn=4,$page='page'){
    	if(!isset($_GET[$page]) || !is_numeric($_GET[$page]) || $_GET[$page]<1){
    		$_GET[$page]=1;
    	}
	if($count>0){
	    //总页数
	    $page_num_all=ceil($count/$page_size);
	    if($_GET[$page]>$page_num_all){
	        $_GET[$page]=$page_num_all;
	    }
	    
    	$start=($_GET[$page]-1)*$page_size;
    	$limit="limit {$start},{$page_size}";
    
    	$current_url=$_SERVER['REQUEST_URI'];//获取当前url地址
    	$arr_current=parse_url($current_url);//将当前url拆分到数组里面
    	$current_path=$arr_current['path'];//将文件路径部分保存起来
    	$url='';
    	if(isset($arr_current['query'])){
    		parse_str($arr_current['query'],$arr_query);
    		unset($arr_query[$page]);
    		if(empty($arr_query)){
    			$url="{$current_path}?{$page}=";
    		}else{
    			$other=http_build_query($arr_query);
    			$url="{$current_path}?{$other}&{$page}=";
    		}
    	}else{
    		$url="{$current_path}?{$page}=";
    	}
    	$html=array();
    	if($num_btn>=$page_num_all){
    		//把所有的页码按钮全部显示
    		for($i=1;$i<=$page_num_all;$i++){//这边的$page_num_all是限制循环次数以控制显示按钮数目的变量,$i是记录页码号
    			if($_GET[$page]==$i){
    				$html[$i]="<li class='active'><span>{$i}</span></li>";
    			}else{
    				$html[$i]="<li><a href='{$url}{$i}'>{$i}</a></li>";
    			}
    		}
    	}else{
    		$num_left=floor(($num_btn-1)/2);
    		$start=$_GET[$page]-$num_left;
    		$end=$start+($num_btn-1);
    		if($start<1){
    			$start=1;
    		}
    		if($end>$page_num_all){
    			$start=$page_num_all-($num_btn-1);
    		}
    		for($i=0;$i<$num_btn;$i++){
    			if($_GET[$page]==$start){
    				$html[$start]="<li class='active'><span>{$start}</span></li>";
    			}else{
    				$html[$start]="<li><a href='{$url}{$start}'>{$start}</a></li>";
    			}
    			$start++;
    		}
    		//如果按钮数目大于等于3的时候做省略号效果
    		if(count($html)>=3){
    			reset($html);
    			$key_first=key($html);
    			end($html);
    			$key_end=key($html);
    			if($key_first!=1){
    				array_shift($html);
    				array_unshift($html,"<li><a href='{$url}1'>1...</a></li>");
    			}
    			if($key_end!=$page_num_all){
    				array_pop($html);
    				array_push($html,"<li><a href='{$url}{$page_num_all}'>...{$page_num_all}</a></li>");
    			}
    		}
    	}
    	if($_GET[$page]!=1){
    		$prev=$_GET[$page]-1;
    		array_unshift($html,"<li><a href='{$url}{$prev}'>« 上一页</a></li>");
    	}
    	if($_GET[$page]!=$page_num_all){
    		$next=$_GET[$page]+1;
    		array_push($html,"<li><a href='{$url}{$next}'>下一页 »</a></li>");
    	}
    	$html=implode(' ',$html);
    }else{
        $limit='';
        $html='';
    }
	$data=array(
			'limit'=>$limit,
			'html'=>$html
	);
	return $data;
}
?>