<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>查询结果</title>
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
			 <div class="chaxunjieguoboxage">
			 	  <div class="chaxunjieguoboxage_nametiti">
			 	    <span>自</span>
			 	  	<label>{date('Y-m-d H:i:s',$star_time)}</label>~<label>{date('Y-m-d H:i:s',$end_time)}</label>
			 	  </div>
			 	  <div class="chakanklishi_navboxage">
			 	  	 <i><img src="/img/dingdan_iconimg.png"/></i>
			 	  	 <span>
			 	  	 	<label>累计销售额</label>
			 	  	 	<label class="chakanklishi_navboxage_moery">¥{$statistics.0.total_moeny|default:0}</label> 
			 	  	 </span>
			 	  </div>
			 	  
			 	  <div class="chakanklishi_navboxage">
			 	  	 <i><img src="/img/xiaoshoue_iconimg.png"/></i>
			 	  	 <span>
			 	  	 	<label>累计成交订单数</label>
			 	  	 	<label class="chakanklishi_navboxage_moery_shulaign">{$statistics.0.total_order|default:0}</label> 
			 	  	 </span>
			 	  </div>
			 	  
			 	  
			 	  <div class="chakanklishi_navboxage">
			 	  	 <i><img src="/img/xinzenyonghu_iconimg.png"/></i>
			 	  	 <span>
			 	  	 	<label>累计用户数</label>
			 	  	 	<label class="chakanklishi_navboxage_moery_shulaign">{$statistics.1|default:0}</label> 
			 	  	 </span>
			 	  </div>
			 </div>
		</div>
	</body>

</html>