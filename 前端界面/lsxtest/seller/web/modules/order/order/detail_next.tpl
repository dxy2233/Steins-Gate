<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>查看流水席</title>
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
			 <div class="chakna">
			 	   <div class="chapage1">
			 	   	   <span>席状态</span>
			 	   	   <label><!-- {if $list_msg.banquet_status<1} -->
					 			 	已停止
					 			 	<!-- {else} -->
					 			 	开席中
					 			 	<!-- {/if} -->
					 	</label>
			 	   </div>
			 	   <div class="fenmian">
			 	   	    <span>封面图</span>
			 	   	    <label><img src="{imageurl($list_msg.banquet_url)|default:'/img/haixian_icon.png'}"/></label>
			 	   </div>
			 	   <div class="chapage1">
			 	   	   <span>名称</span>
			 	   	   <label>{$list_msg.banquet_name}</label>
			 	   </div>
			 	   <div class="chapage1">
			 	   	   <span>类别</span>
			 	   	   <label class="leibir">{$list_msg.type_name}</label>
			 	   </div>
			 	   <div class="tishi">
			 	   	   <span>菜品</span>
			 	   	   <label>* 菜品的价格不会作为实际价格结算，只作展示用</label>
			 	   </div>
					<!-- {if $menu_list} -->
					<!-- {foreach from=$menu_list item=item} -->
			 	   <div class="chapage1">
			 	   	   <span>{$item.menu_name}</span>
			 	   	   <label class="chakanshul">{$item.menu_quantity}</label>
			 	   	   <label class="leibir">￥{$item.menu_price*$item.menu_quantity}</label>
			 	   </div>
			 	<!-- {/foreach} -->
			 	<!--{/if} -->
			 	   <div class="qita">其他参数</div>
			 	   <div class="chapage1">
			 	   	   <span>每位价格</span> 
			 	   	   <label class="leibir">￥{$list_msg.price}</label>
			 	   </div>
			 	    <div class="chapage1">
			 	   	   <span>开席人数</span> 
			 	   	   <label class="leibir">{$list_msg.total_peoples}</label>
			 	   </div>
			 	   <div class="chapage1">
			 	   	   <span>每席总价</span> 
			 	   	   <label class="leibir">￥{$list_msg.total_peoples*$list_msg.price}</label>
			 	   </div>
			 	   <div class="chapage1" style="margin-top: 0.2rem;">
			 	   	   <span>每日最多开席数</span> 
			 	   	   <label class="leibir">{$list_msg.banquet_number}</label>
			 	   </div>
			 	    <div class="chapage1" style="margin-top: 0.2rem;">
			 	   	   <span>开启时间</span> 
			 	   	   <label class="leibir">{$list_msg.begin_time}</label>
			 	   </div>
			 	    <div class="chapage1">
			 	   	   <span>关闭时间</span> 
			 	   	   <label class="leibir">{$list_msg.end_time}</label>
			 	   </div>
			 	   
			 	   
			 </div>
			 
			 
		</div>
	</body>

</html>