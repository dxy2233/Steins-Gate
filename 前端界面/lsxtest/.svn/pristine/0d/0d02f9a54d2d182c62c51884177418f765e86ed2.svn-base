
var page = 0;
function load_msg_detail(){
	if ($('.down_msg').val()!=0) {
		$('.down_msg').val(0);
		if (page>=0) {
			$.ajax({
				cache: false,
				type: "POST",
				url: "/money/mywallet/detailed",
				data: {page:page},
				success: function(result) {
					if (result.status == 1) {
						if (result.sad_list) {
							var html = '';
							for (var i = 0; i < result.sad_list.length; i++) {
								var sta = '';
						 	if(result.sad_list[i].account_status==0){
						 		sta = '席单收入';
						 	}else if(result.sad_list[i].account_status==1){
						 		sta = '平台扣除席单佣金';
						 	}else if(result.sad_list[i].account_status==2){
						 		sta = '申请提现金额';
						 	}else if(result.sad_list[i].account_status==3){
						 		sta = '提现扣除金额';
						 	}else if(result.sad_list[i].account_status==4){
						 		sta = '提现退还金额';
						 	}
								html+='<div class="zh_mingxi">';
							 	  html+='<span class="zh_kouchu">'+sta+'</span>';
							 	  	  html+='<span class="zh_datashj">'+result.sad_list[i].caeate_time+'</span>';
					 	  	  	  html+='<label>'+result.sad_list[i].acount_amount+'</label>';
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


 
