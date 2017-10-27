<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>会员中心</title>
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
			 <div class="vip">
			 	<div class="vippage1">会员列表 (共<span>{count($user_msg)}</span>个)</div>
			 	<!-- /img/touxiangicon.png -->
			 	<!-- {if $user_msg} -->
				<!-- {foreach from=$user_msg item=item} -->
			 	<div class="vippage2">
			 		<div class="vipage1">
			 			<i><img src="{$item.image_path}"/></i>
			 			<span>{$item.nickname|default:$item.user_name}</span>
			 		</div>
			 		<div class="vipage2">
			 			<span>注册时间：<label>{date('Y-m-d H:i:s',$item.reg_time)}</label></span>
			 			<span>共在你店里消费过<label>{$item.total_once}</label>次</span>
			 			<span>合计<label>{$item.total_money}</label>元</span>
			 			
			 		</div> 
			 	</div>
			 	<!-- {/foreach} -->
			 	<!--{/if} -->
			 </div>
			 
			 
		</div>
	</body>

</html>