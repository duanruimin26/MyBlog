// 函数定义
var mainApp={
	backToTop: function(){
		$(window).scroll(function(){
			var dis=$(this).scrollTop();
			if(dis>100){
				$("#back-to-top").fadeIn();
			}else{
				$("#back-to-top").fadeOut();
			}
		});

		$("#back-to-top").click(function(e){
			e.preventDefault();
			$("body").animate({scrollTop: 0},1000);
			return false;
		});
	},
	init: function(){
		mainApp.backToTop();
	}
};

// 初始化
$(function(){
	mainApp.init();
});