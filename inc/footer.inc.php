    <!-- 底部 -->
    <footer id="blog-footer">
        <div class="container">
            Copyright © 2015.&nbsp;&nbsp;All Rights Reserved.&nbsp;&nbsp;Theme By Duan Ruimin
            <br>
            <a href="http://www.miibeian.gov.cn/" target="_blank" rel="nofollow" style="display:block;margin-top: 4px;color: #fff;">苏ICP备14057537号-1</a>
        </div>
    </footer>
    <!-- 回到顶端 -->
	<div id="blog-gotop">
		<i class="glyphicon glyphicon-chevron-up"></i>
	</div>
    <script src="js/jquery-2.1.1.js"></script>
	<script src="js/jQuery.easing.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script>
		$(document).ready(function(){
			// 返回顶部
			$('#blog-gotop').click(function (){
				$('body,html').animate({'scrollTop': 0}, 300);
			});
			//导航栏样式
			$('#menu-navbar>li').removeClass("current-menu-item");
			$('#menu-navbar>li').eq(<?php echo $current_item?>).addClass("current-menu-item");
			
			$("#menu-navbar").on('click','li',function(){
				$('#menu-navbar>li').removeClass("current-menu-item");
				$(this).addClass("current-menu-item");
			});
			
		});
	</script>
</body>
</html>
<?php
@close($link);
?>