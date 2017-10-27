<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>统计中心</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<div class="box">
			<div class="tongjiname">
				<div class="tongjipage1">累计统计</div>
				<div class="qian_com">
					<a href="#" class="qian_nav">
						<i class="nav_img"><img src="/img/xiaoshoueicon.png"/></i>
						<span class="bangding">累计销售额<label class="tongji_morey">￥{$statistics.0.total_moeny|default:0}</label></span>
						
					</a>
					<a href="#" class="qian_nav">
						<i class="nav_img nav_img2"><img src="/img/dingdanicon.png"/></i>
						<span class="bangding">累计成交订单数<label class="tognjishu">{$statistics.0.total_order|default:0}</label></i></span>
					</a>
					<a href="#" class="qian_nav">
						<i class="nav_img nav_img3"><img src="/img/leijiyongshuicon.png"/></i>
						<span class="bangding">累计用户数<label class="tognjishu">{$statistics.1|default:0}</label></span>
					</a> 
				</div>  
			</div>
			<div class="tongjiname">

			<form class="mui-input-group" id='findmsg'  action='findmsg' method='post' >
				<div class="tongjipage1">累计统计
				   <input type="date" name='star_time' class="datainput" />
				</div>
				<div class="tongjipage1">截止日期
				   <input type="date" name='end_time' class="datainput" />
				</div>  
				</div>
				<div class="sublebtn">
						<input type="submit" value="搜索" />
				</div>
			</form >

		</div>
	</body>
	<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		$("#findmsg").submit(function() {
			var star_time = $('input[name="star_time"]').val();
			var end_time = $('input[name="end_time"]').val();
			if (star_time==''||star_time==null) {
				alert('请选择统计时间');
				return false;
			};
			if (end_time==''||end_time==null) {
				alert('请选择截止日期');
				return false;
			};
		});

	});
	</script>
</html>