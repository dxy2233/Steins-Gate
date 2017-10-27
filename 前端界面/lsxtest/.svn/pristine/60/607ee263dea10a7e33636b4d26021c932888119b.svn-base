<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
    <script type="text/javascript" src="/js/style.js" ></script>
    <script type="text/javascript" src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/load_order_msg.js"></script>

    <!-- <script type="text/javascript" src="/js/base.js" ></script>-->
    
    <link href="/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/base.css" />
    <!-- <link rel="stylesheet" href="/css/index.css" /> -->
    <script type="text/javascript" charset="utf-8">
      	mui.init();
    </script>
</head>
<body id='scrol'>
	<div class="box">
		 <!--内容区-->
		 <div class="combox"> 
		 	<!--导航-->
		 	 <div class="navbox_xd">
		 	 	<a><span class="iskey actiovanav" sta='99'>全部</span></a>
		 	 	<a><span class="iskey" sta='0'>拼席中</span></a>
		 	 	<a><span class="iskey" sta='1'>拼成功</span></a>
		 	 	<a><span class="iskey" sta='3'>已完成</span></a>
		 	 	<a><span class="iskey" sta='2'>已退款</span></a> 
		 	 </div>
		 	 <input type="hidden" class='down_msg' value='1'>
		 	 <!--显示主要内容-->
		 	<div class="navboxcom">
		 	 	<!--占位-->
		 	 	<div class="hight"></div>

		 	 	<!--全部-->
		 	 	<div class='all_show all_show99'>
		 	 		
			 	 	
		 	 	</div>
				
				<!--拼席中-->
		 	 	<div class='all_show all_show0' style='display:none'>
		 	 		
			 	 	
		 	 	</div>

		 	 	<!--拼席成功-->
		 	 	<div class='all_show all_show1' style='display:none'>
		 	 		
			 	 	
		 	 	</div>

				<!--已完成-->
		 	 	<div class='all_show all_show3' style='display:none'>
		 	 		
			 	 	
		 	 	</div>
		 	 	<!--已退款-->
		 	 	<div class='all_show all_show2' style='display:none'>

		 	 	</div>
		 	 	</div>
		 	 	
		 	 	 
		 	 </div>
		 	  
		 	  
		 </div>
		 
	</div>
</body>
<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		if ($(".all_show"+$('.actiovanav').attr('sta')+'>div').html()==''||$(".all_show"+$('.actiovanav').attr('sta')+'>div').html()==null) {
				load_msg($('.actiovanav').attr('sta'));
			};
		$(".iskey").click(function() {
			var sta = $(this).attr('sta');
			var all_show_block = $(".all_show"+sta);
			var all_show = $(".all_show");
			$(".iskey").removeClass('actiovanav');
			 for (var i = 0; i<all_show.length;i++) {
			   all_show[i].style.display="none";
			 };
			$(this).addClass('actiovanav');
			for (var i = 0; i<all_show_block.length;i++) {
			   all_show_block[i].style.display="block";
			 };
			 if ($(".all_show"+sta+'>div').html()==''||$(".all_show"+sta+'>div').html()==null) {
			 	load_msg(sta);
			 }
		});
	});
	// window.setInterval(showalert, 5000);
	// function showalert()
	// {
	// 	if ($(".all_show"+$('.actiovanav').attr('sta')+'>div').html()==''||$(".all_show"+$('.actiovanav').attr('sta')+'>div').html()==null) {
	// 			load_msg($('.actiovanav').attr('sta'));
	// 		};
	// }
// //滚动条在Y轴上的滚动距离
 
// function getScrollTop(){
// 　　var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
// 　　if(document.body){
// 　　　　bodyScrollTop = document.body.scrollTop;
// 　　}
// 　　if(document.documentElement){
// 　　　　documentScrollTop = document.documentElement.scrollTop;
// 　　}
// 　　scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
// 　　return scrollTop;
// }
 
// //文档的总高度
 
// function getScrollHeight(){
// 　　var scrollHeight = 0, bodyScrollHeight = 0, documentScrollHeight = 0;
// 　　if(document.body){
// 　　　　bodyScrollHeight = document.body.scrollHeight;
// 　　}
// 　　if(document.documentElement){
// 　　　　documentScrollHeight = document.documentElement.scrollHeight;
// 　　}
// 　　scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight;
// 　　return scrollHeight;
// }
 
// //浏览器视口的高度
 
// function getWindowHeight(){
// 　　var windowHeight = 0;
// 　　if(document.compatMode == "CSS1Compat"){
// 　　　　windowHeight = document.documentElement.clientHeight;
// 　　}else{
// 　　　　windowHeight = document.body.clientHeight;
// 　　}
// 　　return windowHeight;
// }
 
// window.onscroll = function(){
// 　　if(getScrollTop() + getWindowHeight() == getScrollHeight()){
// 　　　　alert("已经到最底部了！!");
// 　　}
// };
 
// 如果用jquery来实现的话就更简单了，
 
$(window).scroll(function(){
	if ($('.down_msg').val()==1) {
		var scrollTop = $(this).scrollTop();
	　　var scrollHeight = $(document).height();
	　　var windowHeight = $(this).height();
	　　if(scrollTop + windowHeight == scrollHeight){
	　　　　load_msg($('.actiovanav').attr('sta'));
	　　}	
	};
　　
});

	
	</script>
</html>