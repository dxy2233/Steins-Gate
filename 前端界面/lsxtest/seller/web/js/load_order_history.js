
var page = 0;
function load_msg_history(){
	if ($('.down_msg').val()!=0) {
		$('.down_msg').val(0);
		if (page>=0) {
			$.ajax({
				cache: false,
				type: "POST",
				url: "/shop/flowingverification/history",
				data: {page:page},
				success: function(result) {
					if (result.status == 1) {
						if (result.history) {
							var html = '';
							for (var i = 0; i < result.history.length; i++) {

								html+='<div class="yanzhen">';
							 	  html+='<div class="yanzhenpage1">';
							 	  	  html+='<i class="logimgtu"><img src="'+result.history[i].banquet_url+'"/></i>';
							 	  	  html+='<div class="yangetiti">';
							 	  	  	  html+='<span class="titiname">'+result.history[i].banquet_name+'</span>';
							 	  	  	  html+='<span class="titiname">开席时间：<label>'+result.history[i].banquet_time+'</label></span>';
							 	  	  	  html+='<span class="zuohoa">桌号：<label>'+result.history[i].banquet_number+'</label></span>';
							 	  	  	  html+='<span class="zuohoa">用户：<label>'+result.history[i].user_name+'</label></span>';
							 	  	  	  
							 	  	  html+='</div>';
							 	  html+='</div>';
							 	  html+='<div class="dindanxixi">订单信息</div>';
							 	  html+='<div class="xiaoxiyan">';
							 	  	  html+='<div class="xiopage1"><span>数量：</span><label>'+result.history[i].buy_seats+'</label></div>';
							 	  	  html+='<div class="xiopage1"><span>价格：</span><label>￥'+result.history[i].pay_amount+'</label></div>';
							 	  	  html+='<div class="xiopage1"><span>订单号：</span><label>'+result.history[i].banquet_sn+'</label></div>';
							 	  	  html+='<div class="xiopage1"><span>流水码：</span><label>'+result.history[i].buy_number+'</label></div>';
							 	  	  html+='<div class="xiopage1"><span>验证时间：</span><label>'+result.history[i].check_time+'</label></div>';
							 	  	  if (result.history[i].is_check==1) {
							 	  	  	html+='<div class="tubiao"><img src="/img/yinzhagn.png"/></div>';	
							 	  	  };
							 	  html+='</div>';
							 html+='</div>';
								
							};
						page++;
						$('.box').append(html);
						};
					} else {
					page=-1;	
						$('.box').append("<div style='margin-left:35%'>没有更多数据</div>");
						// alert('没有更多数据');
					}
					$('.down_msg').val(1);
				},
				error: function(result) {
					alert("异常", {
						icon: 2
					});
					$('.down_msg').val(1);
				}
			});
		};
	};
		 	
		
}


 
