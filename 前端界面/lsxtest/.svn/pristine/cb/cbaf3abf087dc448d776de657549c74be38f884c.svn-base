<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>席单详情</title>
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
			  <div class="xidanxiangqing">
			  	   <a href="detail_next?banquet_id={$list_msg.banquet_id}&order_id={$list_msg.order_id}" class="xidanxiangqing_nav">
			  	   	  <div class="xd_logoimg"><img src="{imageurl($list_msg.banquet_url)|default:'/img/xdxqimg.png'}"/></div>
			  	   	  <div class="xd_canpintitle">
			  	   	  	  <span class="xd_naemage">{$list_msg.shop_name}</span>
			  	   	  	  <span class="xd_naemage">{$list_msg.banquet_name}</span>
			  	   	  	  <span class="xd_shuliangzognjai">数量:<label>{$list_msg.joined_peoples}</label></span> 
			  	   	  	  <span class="xd_shuliangzognjai" style="margin-right: 0rem;">总价 :¥<label>{$list_msg.total_peoples*$list_msg.order_price}</label></span> 
					      <i class="lefig"><img src="/img/leftimg.png"/></i>
			  	   	  </div> 
			  	   </a>
			  	   <div class="xq_page1age1box">
			  	   	 <span>席信息</span>
			  	   	 <!-- 0拼席中，1拼席成功，2已退款，3已完成 -->
			  	   	 {if $list_msg.order_status==0}
			  	   	 	<label>拼席中</label>
			  	   	 {else if  $list_msg.order_status==1}
			  	   	 	<label>拼席成功</label>
			  	   	 {else if  $list_msg.order_status==2}
			  	   	 	<label>已退款</label>
			  	   	 {else if  $list_msg.order_status==3}
			  	   	 	<label>已完成</label>
			  	   	 {/if}
			  	   </div>
			  	   <div class="xq_xixinxixbox">
			  	   	    <div class="xq_outage"><span>席桌号：</span><label>{$list_msg.banquet_number}</label></div>
			  	   	    <div class="xq_outage"><span>席标题：</span><label>{$list_msg.banquet_title}</label></div>
			  	   	    <div class="xq_outage"><span>开席时间：</span><label>{date('Y-m-d H:i:s',$list_msg.banquet_time)}</label></div>
			  	   	    <div class="xq_outage"><span>席单号：</span><label>{$list_msg.banquet_sn}</label></div>
			  	   	    
			  	   </div> 
			  </div>
			  
			  <div class="xq_yonghuxinxiout">
			  	     <div class="xq_ygnnaeoutba">用户信息</div>
			  	     <!-- {if $user_list} -->
					 <!-- {foreach from=$user_list item=item} -->
			  	     <div class="xq_yonghuboxage">
			  	     	  <div class="yonghu_imgicon">
			  	     	  	   <i class="iconyongimg"><img src="{$item.image_path|default:'/img/yonghuimgicon.png'}"/></i>
			  	     	  	   <span class="icnnameboxageout">{$item.nickname|default:$item.user_name}</span>
			  	     	  </div>
			  	     	  <div class="yonghu_tiitilebxo">
			  	     	  	    <p class="yonghudianhaooutob"><span>订单号：</span><label>{$item.record_sn}</label></p>
			  	     	  	    <p class="yonghudianhaooutob"><span>付款时间：</span><label>{date('Y-m-d H:i:s',$item.pay_time)}</label></p>
			  	     	  	    <p class="yonghudianhaooutob"><span>购买数量：</span><label>{$item.buy_seats}</label></p>
			  	     	  	    <p class="yonghudianhaooutob"><span>价格：</span><label>¥{$item.pay_amount}</label></p>
			  	     	  	    <p class="yonghudianhaooutob"><span>状态：</span>{if $item.order_status==0}<label>拼席中</label>{else if  $item.order_status==1}<label>拼席成功</label>{else if  $item.order_status==2}<label>已退款</label>{else if  $item.order_status==3}<label>已完成</label>{/if}</p>
							  	     	  	 
							</div> 
			  	     </div> 
					 <!-- {/foreach} -->
			  	     <!-- {/if} -->
			  </div>
			  
			  
			  
			  
		</div>
	</body>

</html>