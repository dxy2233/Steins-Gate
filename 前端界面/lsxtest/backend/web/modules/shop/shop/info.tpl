<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
		<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
	</head>
	<body>
	<div id="divCenter" onclick="picClose()" align="center">
		<img src=""/>
	</div>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><a href="javascript:window.history.back(-1)" class="label">商家管理</a>><label>商家信息</label>
			</div>
		 	<!--查看-->
		 	<div class="shagnjiachakan">
		 		<div class="chakntongji">
		 			<div class="shagnjiaqiben">商家基本信息</div>
		 			<table class="chakankshagjai" cellpadding="0" cellspacing="0">
		 				 <tr>
		 				 	<td>商家名称：<span>{$data.shop_name}</span></td>
		 				 	<td>店主姓名：<span>{$data.merchant_name}</span></td>
		 				 	<td>手机号：<span>{$data.merchant_mobile}</span></td>
		 				 	<td>商家面积：<span>{$data.merchant_area}</span></td>
		 				 </tr>
		 				 <tr>
		 				 	<td>商家地址：<span>{$data.address}</span></td>
		 				 	<td>商家状态：<span>
									{if $data.shop_status eq 0}停用{/if}
                                    {if $data.shop_status eq 1}启用{/if}
								           </span></td>
		 				 	<td>商家电话：<span>{$data.merchant_telphone}</span></td>
		 				 	<td>商家座位：<span>{$data.merchant_seats}</span></td>
		 				 </tr>
						<tr>
							<td valign="top"><span>营业时间：{$data.opening_hour}~{$data.closing_hour}</span></td>
							<td class="spe-row"><span>营业执照：</span><a href="javascript:void(0)" onclick="picBig($(this).children('img').attr('src'))"><img src="{$data.business_license_path}" alt=""></a></td>
							<td class="spe-row"><span>卫生许可证：</span><a href="javascript:void(0)" onclick="picBig($(this).children('img').attr('src'))"><img src="{$data.food_license_path}" alt=""></a></td>
						</tr>
		 			</table> 
		 		</div>
		 		
		 		<div class="chakntongji">
		 			<div class="shagnjiaqiben">商家经营情况</div>
		 			<table class="chakankshagjai" cellpadding="0" cellspacing="0">
		 				 <tr>
		 				 	<td>菜品数量：<span>{$data.foods}</span></td>
		 				 	<td>流水席数：<span>{$data.banquets}</span></td>
		 				 	<td>成交订单：<span>{$data.banquet_orders}</span></td>
		 				 	<td>创建时间：<span>{date("Y-m-d H:i:s", $data.create_time)}</span></td>
		 				 </tr>
		 				 <tr>
		 				 	<td>销售总额：<span>￥{$data.sales_amount}</span></td>
		 				 	<td>账号余额：<span>￥{$data.total_balnce}</span></td>
		 				 	<td>佣金比例：<span>{$data.commission_rate}%</span></td>
		 				 	<td>上次登录时间：<span>{date("Y-m-d H:i:s",$data.last_time)}</span></td>
		 				 </tr>
		 				  <tr>
		 				 	<td>分佣总额：<span>￥{$data.platform_amount}</span></td>
		 				 	<td>已结算金额：<span>￥{$data.withdraw_amount}</span></td>
		 				 	<td>用户总数：<span>{$data.total_user}</span></td>
		 				 </tr> 
		 			</table> 
		 		</div>
		 		
		 		
		 	</div>
		 	
		 	
		 	
		 </div>
		 <script src="/js/check.js"></script>
	</body>

</html>
