var mainApp={
	bodyClass: function(){
		var avaiWidth=document.body.clientWidth;
		if(avaiWidth>=1280){
			$("body").removeClass().addClass("large");
		}else{
			$("body").removeClass().addClass("small");
		}
	},
	navbarAd:function(){
		var pageWidth=$(window).width();
		if(pageWidth<1040){
			if(pageWidth>980){
				$("#navbarAd").width(200-(1040-avaiWidth)/2);
			}else{
				$("#navbarAd").width(170);
			}
			$(".header .layout").css("position","static");
			$("#navbarAd").addClass("part");
		}else{
			$(".header .layout").css("position","relative");
			$("#navbarAd").width(200);
			$("#navbarAd").removeClass("part");
		}
	},
	navbarShow: function(){
		
		var timer = '';

		$('.navbar').on('mouseenter', 'dl', function() {
		  	clearTimeout(timer);
		  	timer = setTimeout(function() {
			  $('.navbar').addClass('navbar-hover');
			}, 300);
		}).on('mouseleave', function() {
			clearTimeout(timer);
			$('.navbar').removeClass('navbar-hover');
		}).on('click', 'a', function() {
			clearTimeout(timer);
			$('.navbar').removeClass('navbar-hover');
		});
	},
	hotspotTab: function(){

		$("#hotLemmas .title-nav a").click(function(){
			var time=$(this).attr("data-time");
			$("#hotLemmas .title-nav a").removeClass("show");
			$(this).addClass("show");

			$("#hotLemmas .content").removeClass("show");
			$("#hotLemmas .content."+time).addClass("show");

		});
	},
	frontBackTab: function(){

		var timer = '', timer1 = '', timer2 = '';

		$("#userCards .card").on('mouseenter',function(){
			clearTimeout(timer);
			var $this = $(this);
			
			timer = setTimeout(function(){
				$this.find(".flip").removeClass("flipToFront").addClass("flipToBack");
				timer1=setTimeout(function(){$this.find(".flip .back").show();$this.find(".flip .front").hide();},250);
			},500);

		}).on('mouseleave',function(){
			clearTimeout(timer);
			var $this = $(this);

			$this.find(".flip").removeClass("flipToBack").addClass("flipToFront");
			timer2=setTimeout(function(){$this.find(".flip .front").show();$this.find(".flip .back").hide();},250);
		})
	},
	featureMarquee: function(){

		var addCategory = $("#fancyCategories #viewport .category").clone(true);
		var moreAddCategory = $("#fancyCategories #viewport .category").clone(true);

		if($("body").hasClass("large")){

			$("#fancyCategories #viewport ul").append(addCategory);
		}else{
			
			$("#fancyCategories #viewport ul").append(addCategory);
			$("#fancyCategories #viewport ul").append(moreAddCategory);
			$("#fancyCategories #viewport ul").css("width",9000);
		}

		$("#fancyCategories .next").click(function(){
			var left=Math.ceil(Number($("#fancyCategories #viewport ul").css("left").split("px")[0])/(-1200))*(-1200)-1200+"px";
			if(left=="-6000px"){
				left="0px";
			}
			$("#fancyCategories #viewport ul").animate({"left": left},400);
		});
		$("#fancyCategories .prev").click(function(){
			var left=Math.floor(Number($("#fancyCategories #viewport ul").css("left").split("px")[0])/(-1200))*(-1200)+1200+"px";
			if(left=="1200px"){
				left="-4800px";
			}
			$("#fancyCategories #viewport ul").animate({"left": left},400);
		})
	},
	init:function(){
		mainApp.bodyClass();
		mainApp.navbarAd();
		mainApp.navbarShow();
		mainApp.hotspotTab();
		mainApp.frontBackTab();
		mainApp.featureMarquee();
	}
};

$(function(){
	mainApp.init();
	window.onresize=function(){
		mainApp.bodyClass();
		mainApp.navbarAd();
	}
});
	