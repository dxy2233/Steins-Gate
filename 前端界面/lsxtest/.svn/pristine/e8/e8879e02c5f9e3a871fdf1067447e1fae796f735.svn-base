<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
	</head>
	<body>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><a href="javascript:window.history.back(-1)" class="label">席单管理</a>><label>席单信息</label>
			</div>
		 	<!--查看-->
		 	<div class="shagnjiachakan">
		 		<div class="chakntongji">
		 			<div class="shagnjiaqiben">订单基本信息</div>
		 			<table class="chakankshagjai" cellpadding="0" cellspacing="0">
		 				 <tr>
		 				 	<td>席单号：<span>{$data.banquet_sn}</span></td>
		 				 	<td>订单状态：<span>
									{if $data.order_status eq 0}拼席中{/if}
                                    {if $data.order_status eq 1}拼席成功{/if}
                                    {if $data.order_status eq 2}已退款{/if}
                                    {if $data.order_status eq 3}已完成{/if}
								</span></td>
		 				 	<td>价格：<span>{$data.order_amount}</span></td>
		 				 	<td>已付金额：<span>{$data.joined_peoples*$data.order_price}</span></td>
		 				 </tr>
		 				 <tr>
		 				 	<td>所属商家：<span>{$data.shop_name}</span></td>
		 				 	<td>流水席编号：<span>{$data.banquet_id}</span></td>
		 				 	<td>流水席名称：<span>{$data.banquet_name}</span></td>
		 				 	<td>订单创建时间：<span>{date("Y-m-d H:i:s",$data.create_time)}</span></td>
		 				 </tr>
		 				   
		 			</table> 
		 		</div>
		 		
		 		<div class="chakntongji">
		 			<div class="shagnjiaqiben">席信息</div>
		 			<table class="chakankshagjai" cellpadding="0" cellspacing="0">
		 				 <tr>
		 				 	<td>人数要求：<span>{$data.total_peoples}</span></td>
		 				 	<td>参与人数：<span>{$data.joined_peoples}</span></td>
		 				 	<td>缺少人数：<span>{$data.total_peoples-$data.joined_peoples}</span></td>
		 				 	<td>席桌号：<span>{$data.banquet_number}</span></td>
		 				 </tr>
		 				 <tr>
		 				 	<td>商家地址：<span>{$data.address}</span></td>
		 				 	<td>商家电话：<span>{$data.merchant_telphone}</span></td>
		 				 	<td>开席时间：<span>{date("Y-m-d H:i:s", $data.banquet_time)}</span></td>
		 				 	<td>席标语：<span>{$data.banquet_title}</span></td>
		 				 </tr> 
		 			</table> 
		 		</div>
				{if $data.is eq 1}
		 		<div class="chakntongji" style="border-bottom: 0px;">
		 			<div class="shagnjiaqiben">该席订单列表</div>
                    {foreach from=$rows item=rows_info key=rows_info_key}
		 			<table class="chakankshagjai chakankshagjai2" cellpadding="0" cellspacing="0">
		 				 <tr class="xidan_nav">
		 				 	<td><span class="bianhao">#<label>{$rows_info.key}</label></span>订单号：<span>{$rows_info.record_sn}</span></td>
		 				 	<td>用户名：<span>{$rows_info.user_name}</span></td>
		 				 	<td>电话号码：<span>{$rows_info.mobile}</span></td>
		 				 	<td>订单状态：<span class="zhauntiacons">
									{if $rows_info.order_status eq 0}拼席中{/if}
                                    {if $rows_info.order_status eq 1}拼席成功{/if}
                                    {if $rows_info.order_status eq 2}已退款{/if}
                                    {if $rows_info.order_status eq 3}已完成{/if}
								</span></td>
		 				 </tr>
		 				 <tbody class="yonghubales xidan_conm">
		 				 	 <tr>
		 				 	 	<td>购买座位：<span>{$rows_info.buy_seats}</span></td>
		 				 	 	<td>流水券：<span>{$rows_info.buy_number}</span></td>
		 				 	 	<td>单价：<span>{$rows_info.buy_price}</span></td>
		 				 	 	<td>总价：<span>￥{$rows_info.buy_seats*$rows_info.buy_price}</span></td>
		 				 	 </tr> 
		 				 	 <tr>
		 				 	 	<td style="padding-top: 0px;padding-bottom: 30px;">付款时间：<span>{date("Y-m-d H:i:s", $rows_info.pay_time)}</span></td>
		 				 	 </tr> 
		 				 	 <tr class="xidan_foot">
		 				 	 	<td>在线支付：<span>￥{$rows_info.pay_amount}</span></td>
		 				 	 	<td>饭票抵扣：<span>￥{$rows_info.pay_meal_ticket}</span></td>
		 				 	 	<td></td>
		 				 	 	<td class="consosiji">实际总额：<span>￥{$rows_info.buy_seats*$rows_info.buy_price}</span></td>
		 				 	 </tr> 
		 				 </tbody>
		 			</table>
					{/foreach}
		 			<!--分页-->
					<div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/banquet/banquet/info','id'=>$data.order_id])}" method="get">
							<div class="fenye_conbox">
								<div class="fenye_titile">
									显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
									<a href="{\yii\helpers\Url::to(['/banquet/banquet/info','id'=>$data.order_id])}">首页</a><a href="{\yii\helpers\Url::to(['/banquet/banquet/info','id'=>$data.order_id,'page'=>$page.page-1])}">上一页</a><a href="{\yii\helpers\Url::to(['/banquet/banquet/info','id'=>$data.order_id,'page'=>$page.page+1])}">下一页</a><a href="{\yii\helpers\Url::to(['/banquet/banquet/info','id'=>$data.order_id,'page'=>10000])}">尾页</a>
									<input name="page" type="text" class="text" />
									<input type="submit" value="跳 转" class="tiaozhuan" />
								</div>
							</div>
						</form>
					</div>
		 		</div>  
		 		{/if}
		 		
		 	</div>
		 	
		 	
		 	
		 </div>
	</body>
</html>
