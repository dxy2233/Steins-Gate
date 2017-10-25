$(function() {   
	var iframeObj=$('.iframe');
	var aling = $(".leftbox a"); //获取功能导航菜单
	$(".name_bz").click(function(){//修改资料界面
		$(".iframe").attr("src", "xiugaiziliao.html"); 
		return false;
	});
	//饭票金额设置
	$(".sousuo_btn2").click(function(){
		console.log(iframeObj); 
		iframeObj.attr("src","fanpiaojine.html");
		return false;
	})
	
	
	
	$(".leftbox a").click(function() {    
		$(this).addClass("active_bg").siblings().removeClass("active_bg");
		/*点击左边功能导航，切换显示界面*/
		var index = $(this).index();
		for(var i = 0; i < aling.length; i++) {
			if(i == index) {
				if(i == 0) {
					$(".iframe").attr("src", "index1.html"); 
					return false;
				}
				if(i == 1) {
					$(".iframe").attr("src", "index2.html"); 
					return false;
				}
				if(i == 2) {
					$(".iframe").attr("src", "index3.html");
					return false;
				}
				if(i == 3) {
					$(".iframe").attr("src", "index4.html");
					return false;
				}
				if(i == 4) {
					$(".iframe").attr("src", "index5.html");
					return false;
				}
				if(i == 5) {
					$(".iframe").attr("src", "index6.html");
					return false;
				}
				if(i == 6) {
					$(".iframe").attr("src", "index7.html");
					return false;
				}
				if(i == 7) {
					$(".iframe").attr("src", "index8.html");
					return false;
				}
				if(i == 8) {
					$(".iframe").attr("src", "index9.html");
					return false;
				}
				if(i == 9) {
					$(".iframe").attr("src", "index10.html");
					return false;
				}
				if(i == 10) {
					$(".iframe").attr("src", "index11.html");
					return false;
				}
				
			}

		}

	})
	

})