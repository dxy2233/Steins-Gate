<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>流水席管理</title>
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
			 <div class="quanbuliushuixi">
			 	<span>全部流水席　共 <label>{count($list)}</label> 席</span>
			 </div>
			 <!-- {if $list} -->
				<!-- {foreach from=$list item=item} -->
					<div class="quanbu_guanli">
					 	<div class="guanlixiagnqi">
					 		<div class="logoimg"><img src="{imageurl($item.banquet_url)|default:'/img/haixian_icon.png'}"/></div>
					 		<div class="xia_qin">
					 			 <span class="jindain">{$item.banquet_name}</span>
					 			 <span class="kaixi">开席人数：<label>{$item.total_peoples}</label>人</span>
					 			 <span class="menshijia">门市价：<label>￥{$item.banquet_amount}</label></span> 
					 		</div>
					 		<div class="zhuagntai">
					 			 <span class="zhuagntai_kaixk">
					 			 	
					 			 	<!-- {if $item.banquet_status<1} -->
					 			 	已停止
					 			 	<!-- {else} -->
					 			 	开席中
					 			 	<!-- {/if} -->
					 			 </span>
					 			 <span class="kaixi">席桌上线：<label>{$item.banquet_number}</label>桌/天</span>
					 			 <span class="menshijia">每人价格：<label>￥{$item.price}</label></span>  
					 		</div> 
					 	</div>
					    <div class="chakan_bianji"> 
				 	 		 	<a href="update?banquet_id={$item.banquet_id}" class="chakankbox">编辑</a>
				 	 		 	<a href="detail?banquet_id={$item.banquet_id}" class="chakankbox">查看</a> 
					    </div> 
					 </div>

			 	<!-- {/foreach} -->
			 <!--{/if} -->
			 <!-- <div style='display: inline-block;width: 0.93rem;height: 0.93rem;'>
			</div> -->
			<br/>
			<br/>
			<br/>
			 <div class="tianjiaicon">
				<a href="addmain"><img src="/img/tianjaiinco.png"/></a>
			</div>
		</div>
	</body>

</html>