<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>流水码验证</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<script type="text/javascript" src="/js/regular.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<div class="box"> 
			<form  id='watter_submit' action='result' method='post'>
				<div class="mui-input-row">
					<label>流水码</label>
					<input type="text" name='buy_number' onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" maxlength='6' minlength='6'class="mui-input-clear" placeholder="请输入流水码">
				</div> 
			<div class="btn2"><input class='gocheck' type="button" value="点击验证"></div>
			</form>
			<div class="chakanklishi"><a href="history">查看历史</a></div>
			<div class="yanzhencg" style='display:none'>
				<div class="yzcgimg"><imgsrc="/img/yzcgimg_02.png"/></div>
				<div class="yanzhen">
			 	  <div class="yanzhenpage1">
			 	  	  <i class="logimgtu"><img  class='img_class'  src="/img/feiji.png"/></i>
			 	  	  <div class="yangetiti">
			 	  	  	  <span class="titiname xi_name">经典4人餐</span>
			 	  	  	  <span class="titiname">开席时间：<label class='banquet_time'>2017-9-18 17:45</label></span>
			 	  	  	  <span class="zuohoa">桌号：<label class='zhuohao'>005</label></span>
			 	  	  	  <span class="zuohoa">用户：<label class='user_name'>张先生</label></span>
			 	  	  	  
			 	  	  </div>
			 	  </div>
			 	  <div class="dindanxixi">订单信息</div>
			 	  <div class="xiaoxiyan">
			 	  	  <div class="xiopage1"><span>数量：</span><label class='order_num'>2</label></div>
			 	  	  <div class="xiopage1"><span>价格：</span>￥<label class='pay_amount'>2</label></div>
			 	  	  <div class="xiopage1"><span>订单号：</span><label class='record_id'>1234567892</label></div>
			 	  	  <div class="xiopage1"><span>流水码：</span><label class='buy_number'>1234567892</label></div>
			 	  	  <div class="xiopage1"><span>验证时间：</span><label class='check_time'>1234567892</label></div>
			 	  	  <!--图标-->
			 	  	  <div class="tubiao"><img src="/img/yinzhagn.png"/></div>
			 	  </div>
			 </div>
			</div>
		</div>
	</body>
<script type="text/javascript" charset="utf-8">
	var status_like=1;
$().ready(function() {
		$('.gocheck').click(function(){
			if (status_like==0) {
				return false;
			};
			status_like=0;
			var buy_number = $("input[name='buy_number']").val();
			if (buy_number=='') {
				alert('请输入6位流水码');
				return false;
			};
			$.ajax({
				cache: false,
				type: "POST",
				url: "/shop/flowingverification/result",
				data: $("#watter_submit").serialize(),
				success: function(result) {
					if (result.status == 1) {
						if (result.msg) {
							$('.img_class').attr('src',result.msg.banquet_url);
							$('.xi_name').html(result.msg.banquet_name);
							$('.banquet_time').html(result.msg.banquet_time);
							$('.zhuohao').html(result.msg.banquet_number);
							$('.user_name').html(result.msg.user_name);
							$('.order_num').html(result.msg.buy_seats);
							$('.pay_amount').html(result.msg.pay_amount);
							$('.record_id').html(result.msg.banquet_sn);
							$('.buy_number').html(result.msg.buy_number);
							$('.check_time').html(result.msg.check_time);
							if (result.msg.is_check==1) {
				 	  	  		$('.tubiao').html('<img src="/img/yinzhagn.png"/>');	
				 	  	  };
				 	  	  $('.yanzhencg').css('display','block');
						};
						alert('流水码验证成功');
					} else {
						alert(result.msg);
					}
					status_like=1;
				},
				error: function(result) {
					alert("异常", {
						icon: 2
					});
					status_like=1;
				}
			});
		});
});

	
	</script>
</html>