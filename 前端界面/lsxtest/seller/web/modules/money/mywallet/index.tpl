<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>我的钱包</title>
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
			 <div class="qianbao_box">
			 	<div class="title">账户余额(元)</div>
			 	<div class="qian_moery">{$msg.total_balnce}</div>
			 </div>
			 <div class="qian_com">
			 	<a href="/money/mywallet/bondcard" class="qian_nav">
			 		<i class="nav_img"><img src="/img/yinhangka.png"/></i>
			 		<span class="bangding">绑定银行卡<i><img src="/img/leftimg.png"/></i></span>
			 	</a>
			 	<a href="/money/mywallet/apply" class="qian_nav">
			 		<i class="nav_img nav_img2"><img src="/img/shenqintixian.png"/></i>
			 		<span class="bangding">申请提现<i><img src="/img/leftimg.png"/></i></span>
			 	</a>
			 	<a href="/money/mywallet/result" class="qian_nav">
			 		<i class="nav_img nav_img3"><img src="/img/tixianjieguo.png"/></i>
			 		<span class="bangding">提现结果<i><img src="/img/leftimg.png"/></i></span>
			 	</a>
			 	<a href="/money/mywallet/detailed" class="qian_nav">
			 		<i class="nav_img nav_img4"><img src="/img/shourumignxi.png"/></i>
			 		<span class="bangding">账户明细<i><img src="/img/leftimg.png"/></i></span>
			 	</a>
			 	
			 </div>
			 
			 
			 
		</div>
	</body>

</html>