
var page = 0;
function load_msg_result(){
	if ($('.down_msg').val()!=0) {
		$('.down_msg').val(0);
		if (page>=0) {
			$.ajax({
				cache: false,
				type: "POST",
				url: "/money/mywallet/result",
				data: {page:page},
				success: function(result) {
					if (result.status == 1) {
						if (result.sr_list) {
							var html = '';
							for (var i = 0; i < result.sr_list.length; i++) {
								var sta = '';
						 	if(result.sr_list[i].request_status==0){
						 		sta = '申请中';
						 	}else if(result.sr_list[i].request_status==1){
						 		sta = '审核通过';
						 	}else if(result.sr_list[i].request_status==2){
						 		sta = '审核未通过';
						 	}
								html+='<div class="tixianjieguo">';
							 	  html+='<div class="txjg_zhuagntai txjg_shz">'+sta+'</div>';
							 	  	  html+='<div class="txjg_jine">提现金额：<label>'+result.sr_list[i].request_amount+'</label>元</div>';
					 	  	  	  html+='<div class="txjg_jine">提交时间：<label>'+result.sr_list[i].request_time+'</label></div>';
				 	  	  	    	if (result.sr_list[i].request_status==2) {
				 	  	  	    		html+='<div class="txjg_jine_yuanyin">拒绝原因：<label>'+result.sr_list[i].content+'</label></div>'
				 	  	  	    	};
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


 
