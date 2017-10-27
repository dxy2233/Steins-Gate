<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
		<link rel="stylesheet" href="/css/jcDate.css" />
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
		<script type="text/javascript" src="/js/jQuery-jcDate.js" ></script>
		<script type="text/javascript" src="/js/base.js" ></script>
	</head>
	<body>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><label>营销管理</label>
			</div>
		 	<div class="yinxiao"> 
		 	  <!--发放日期-->
                            <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['marketing/index'])}" >
		 	    <div class="fafangriqi">
		 	    	 <div class="inputbox">
		 	    	 	<span class="fafang_name">商家名称：</span>
		 	    	 	<input type="text" name="name" value="{$post.name}" class="shagnjai_name" placeholder="请输入商家名称" />
                                        <span class="fafang_name">状态：</span>
                                        <select class="zhaugntai" name="ticket_status">
                                            <option value="1" {if $post.ticket_status == 1}selected{/if}>抵扣消费</option>
                                            <option value="2" {if $post.ticket_status == 2}selected{/if}>获赠饭票奖励</option>
                                            <option value="3" {if $post.ticket_status == 3}selected{/if}>退还饭票</option>
                                        </select>
		 	    	 	<span class="fafang_name">发放日期：</span>
						<input class="jcDate" name="add_time_begin" value="{$post.add_time_begin}" style="width:100px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
						<span>-</span>
						<input class="jcDate" name="add_time_end" value="{$post.add_time_end}" style="width:100px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
						<button class="sousuo_btn">搜　索</button>
						<a href="{yii\helpers\Url::to(['marketing/fanpiaojine'])}" class="fanpiao_shezi">饭票金额设置</a>
						
					</div>
		 	    </div>
                            <input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}">
                            </form>
		 	    <!--饭票发放记录-->
		 	    <div class="fanpiaojilu">
		 	    	<div class="fafang_jilu">
		 	    		饭票发放记录
		 	    	  <span class="jilu">共搜索到<span>{$page.count}</span>条记录　饭票总额￥<span>{$amount}元</span></span>
		 	    	</div>
		 	    	<table class="tablebox" border="1" cellpadding="0" cellspacing="0">
		 	    		<tr class="topfot">
		 	    			<td class="tabnthfo">拼成的订单</td>
		 	    			<td>饭票金额￥</td>
                                                <td>饭票来源</td>
		 	    			<td>用户姓名</td>
		 	    			<td>手机号</td>
		 	    			<td>商家名称</td>
		 	    			<td class="tabnthfo2">发放日期</td>  
		 	    		</tr>
                        {if $data neq ""}
		 	    		<tbody>
                                                {foreach from=$data item=$val}
		 	    			<tr>
		 	    				<td class="tacolor">{if $val.ticket_status == 0 || $val.ticket_status == 1}{$user_order_list[$val.ticket_order].record_sn}{else}{$back_order_list[$val.ticket_order].return_sn}{/if}</td>
		 	    				<td>{$val.ticket_amount}</td>
                                                        <td>
                                                            {if $val.ticket_status == 0}
                                                                饭票抵扣消费
                                                            {else if $val.ticket_status == 1}
                                                                获赠饭票奖励
                                                            {else if $val.ticket_status == 2}
                                                                退还饭票
                                                            {else}
                                                                其他
                                                            {/if}
                                                        </td>
		 	    				<td>{$val.user_name}</td>
		 	    				<td>{$val.mobile}</td>
		 	    				<td>{$val.shop_name}</td>
		 	    				<td>{date('Y-m-d H:i:s',$val.caeate_time)}</td> 
		 	    			</tr>
		 	    			{/foreach} 
		 	    			
		 	    		</tbody>
		 	    		{/if}
		 	    	</table>
		 	    	
		 	    	
		 	    	
		 	    </div>
		 	    <!--分页-->
		 	    	    <div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/marketing/marketing/index'])}" method="get">
                            {foreach from=$post item=post_info key=post_info_key}
								<input type="hidden" name="post[{$post_info_key}]" value="{$post_info}"/>
                            {/foreach}
							<div class="fenye_conbox">
								<div class="fenye_titile">
									显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
									<a href="{\yii\helpers\Url::to(['/marketing/marketing/index','post'=>$post])}">首页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/marketing/marketing/index','post'=>$post,'page'=>$page.page-1])}">上一页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/marketing/marketing/index','post'=>$post,'page'=>$page.page+1])}">下一页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/marketing/marketing/index','post'=>$post,'page'=>10000])}">尾页</a>
									<input name="page" type="text" class="text" />
									<input type="submit" value="跳 转" class="tiaozhuan" />
								</div>
							</div>
						</form>
			 	    </div>
		 	    
		 	
		 	</div>
		 	
		 	
		 	
		 	
		 </div>
		 
	</body>
	<script>
$(function (){
	$(".jcDate").jcDate({					       
			IcoClass : "jcDateIco",
			Event : "click",
			Speed : 100,
			Left : 0,
			Top : 28,
			format : "-",
			Timeout : 100
	});
});
</script>
</html>
