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
				<span>你的位置：</span><a href="javascript:window.history.back(-1)" class="label">用户管理</a>><label>用户信息</label>
			</div>
		 	<!--查看-->
		 	<div class="shagnjiachakan">
		 		<div class="chakntongji">
		 			<div class="shagnjiaqiben">用户基本信息</div>
		 			<table class="chakankshagjai" cellpadding="0" cellspacing="0">
		 				 <tr>
		 				 	<td>姓名：<span>{$data.nickname}</span></td>
		 				 	<td>账户号：<span>{$data.user_name}</span></td>
		 				 	<td>地址：<span>{$data.address_now}</span></td>
		 				 </tr>
		 				 <tr>
		 				 	<td>性别：<span>
									{if $data.sex eq 2}女{/if}
                                    {if $data.sex eq 1}男{/if}
                                    {if $data.sex eq 0}其他{/if}
								</span></td>
		 				 	<td>手机号：<span>{$data.mobile}</span></td>
		 				 	<td>注册时间：<span>{date('Y-m-d h:i:s',$data.reg_time)}</span></td>
		 				 </tr>
		 				  <tr>
		 				 	<td>年龄：<span>{$data.age}</span></td>
		 				 	<td>职业：<span>{$data.job}</span></td>
		 				 	<td>上次登录时间：<span>{date('Y-m-d h:i:s',$data.last_time)}</span></td>
		 				 </tr> 
		 			</table> 
		 		</div>
		 		
		 		<div class="chakntongji">
		 			<div class="shagnjiaqiben">流水席使用情况</div>
		 			<table class="chakankshagjai" cellpadding="0" cellspacing="0">
		 				 <tr>
		 				 	<td>成交订单：<span>{$data.total_orders}</span></td>
		 				 	<td>推荐用户数：<span>{$data.recommend_users}</span></td>
		 				 	<td>获得饭票总额：<span>￥{$data.meal_ticket}</span></td>
		 				 </tr>
		 				 <tr>
		 				 	<td>饭票余额：<span>￥{$data.meal_balance}</span></td>
		 				 	<td>消费总额：<span>￥{$data.total_amount}</span></td>
		 				 </tr> 
		 			</table> 
		 		</div> 
		 		<div class="yonghzhagntai">
					<form  enctype="multipart/form-data" action="{yii\helpers\Url::to(['user/edit'])}" method="get">
		 			<span>状态：</span>
						<input type="hidden" name="user_id" value="{$data.user_id}"/>
		 			<input type="radio" name="user_status" value="1" {if $data.user_status eq 1}checked="checked"{/if} /><label>启用　</label>
		 			<input type="radio" name="user_status" value="0" {if $data.user_status eq 0}checked="checked"{/if} /><label>禁用　　</label>
		 			<input type="submit" class="querenbaocun" value="保 存" />
					</form>
		 		</div>
		 		
		 		
		 	</div>
		 	
		 	
		 	
		 </div>
	</body>
</html>
