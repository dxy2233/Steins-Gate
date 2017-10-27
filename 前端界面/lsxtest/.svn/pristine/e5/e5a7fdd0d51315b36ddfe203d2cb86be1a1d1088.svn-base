
var page99 = 0,page0 = 0,page1 = 0,page3 = 0,page2 = 0;
function load_msg(sta){
	if ($('.down_msg').val()==1) {
		$('.down_msg').val(0);
	if ($('.all_show'+sta).find('.is_msg').html()!='没有更多数据') {
		var page = 0;
			 	if (sta==99) {
					page = page99;
					page99++;
			 	}else if (sta==0) {
			 		page = page0;
					page0++;
			 	}else if (sta==1) {
			 		page = page1;
					page1++;
			 	}else if (sta==3) {
			 		page = page3;
					page3++;
			 	}else if (sta==2) {
			 		page = page2;
					page2++;
			 	}
		if (page>=0) {
			$.ajax({
				cache: false,
				type: "POST",
				url: "/order/order/index",
				data: {page:page,sta:sta},
				success: function(result) {
					if (result.status == 1) {
						if (result.list_msg) {
							var html = '';
							// 0拼席中，1拼席成功，2已退款，3已完成）
							for (var i = 0; i < result.list_msg.length; i++) {
								var order_status ='';
								var css_order ='';
								if (result.list_msg[i].order_status==0) {
									order_status = '拼席中';
								}else if (result.list_msg[i].order_status==1) {
									order_status = '拼席成功';	
									css_order ='pinxichegngong';
								}else if (result.list_msg[i].order_status==3) {
									order_status = '已完成';
									css_order ='yiwanchegn';
								}else if (result.list_msg[i].order_status==2) {
									order_status = '已退款';
									css_order ='yituikuan';
								}
								html+='<div class="pingxizhogn">';
							 	 		 html+='<i><img src="'+result.list_msg[i].banquet_url+'"/></i>';
							 	 		 html+='<div class="pingxinrong">';
							 	 		 	html+='<div class="pingxi_name">';
							 	 		 		html+='<span class="pingxi_name_page">'+result.list_msg[i].banquet_name+'</span>';
							 	 		 		html+='<span class="zhuagntai '+css_order+'">'+order_status+'</span>';
							 	 		 	html+='</div>';
							 	 		 	html+='<div class="pingxi_name pingxi_name_top">';
							 	 		 		html+='<span class="pingxi_name_dianpu">总价：<label>￥'+result.list_msg[i].total_peoples*result.list_msg[i].order_price+'</label></span>';
							 	 		 	html+='</div>';
							 	 		 	html+='<div class="pingxi_name pingxi_name_top">';
							 	 		 		html+='<span class="pingxi_name_dianpu">开席时间:<label>'+result.list_msg[i].banquet_time+'</label></span>';
							 	 		 		html+='<span class="zhuagntai_morer_coro">';
							 	 		 	        html+='<a href="detail?order_id='+result.list_msg[i].order_id+'" class="chakank">查看</a>';
							 	 		 		html+='</span>';
							 	 		 	html+='</div> ';
							 	 		 html+='</div>';
							 	 	html+='</div>';
								
							};

						$('.all_show'+sta).append(html);
						};
					} else {
						if (sta==99) {
							page99=-1;
					 	}else if (sta==0) {
							page0=-1;
					 	}else if (sta==1) {
							page1=-1;
					 	}else if (sta==3) {
							page3=-1;
					 	}else if (sta==2) {
							page2=-1;
					 	}	
						$('.all_show'+sta).append("<div class='is_msg' style='margin-left:35%'>没有更多数据</div>");
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
	}else{
		$('.down_msg').val(1);
	};

	};
		 	
		
}


 
