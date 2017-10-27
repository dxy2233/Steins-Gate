<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
	</head>
	<body style="width: 100%;height: 100%;background: url(img/bg.png) no-repeat right;background-position-y: -60px;">
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><a href="javascript:window.history.back(-1)" class="label">流水席管理</a>><label>流水席详情</label>
			</div>
		 	<!--查看-->
		 	<div class="shagnjiachakan">
		 		<div class="chakntongji">
		 			<div class="shagnjiaqiben">流水席基本信息</div>
		 			<table class="chakankshagjai" cellpadding="0" cellspacing="0" style="width: 90%;">
		 				 <tr>
		 				 	<td rowspan="6" class="icoimg"><img src="{$data.banquet_url}"/></td>
		 				 </tr>
		 				 <tr>
		 				 	<td>流水席编号：<span>{$data.banquet_id}</span></td>
		 				 	<td>店铺电话：<span>{$data.merchant_telphone}</span></td>
		 				 	<td>菜品价格：<span>￥{$data.banquet_amount}</span></td>
		 				 </tr>
		 				  <tr>
		 				 	<td>席名称：<span>{$data.banquet_name}</span></td>
		 				 	<td>商家地址：<span>{$data.address}</span></td>
		 				 	<td>每席总价：<span>￥{$data.total_peoples*$data.price}</span></td>
		 				 	 
		 				 </tr> 
		 				 <tr>
		 				 	<td>类别：<span>{$data.type_name}</span></td>
		 				 	<td>创建时间：<span>{date("Y-m-d H:i:s", $data.create_time)}</span></td>
		 				 	<td>人数要求：<span>{$data.total_peoples}</span></td>
		 				 	
		 				 </tr> 
		 				 <tr>
		 				 	<td>所属商家：<span>{$data.shop_name}</span></td>
		 				 	<td>最后编辑时间：<span>{date("Y-m-d H:i:s", $data.update_time)}</span></td>
		 				 	<td>每人价格：<span>￥{$data.price}</span></td>
		 				 	
		 				 </tr> 
		 				  <tr> 
		 				 	<td>席状态：<span>
									{if $data.banquet_status eq 0}停用{/if}
                                    {if $data.banquet_status eq 1}启用{/if}
								        </span></td>
		 				 </tr> 
		 				 
		 			</table> 
		 		</div>
		 		
		 		<div class="chakntongji" style="width: 100%;border-bottom: none;">
		 			<div class="shagnjiaqiben" style="margin-bottom: 30px;">菜品信息<span class="gongshi">（共<label>{$page.count}</label>份）</span></div>
		 			<table class="gongsuou" cellpadding="0" cellspacing="0" >
						  <tr class="gong_nav">
						  	  <td class="lefttalbe">菜品名称</td>
						  	  <td>单价</td>
						  	  <td>数量</td>
						  	  <td class="righttalble">价格￥</td> 
						  </tr>
						  <tbody>
                          {foreach from=$rows item=rows_info key=rows_info_key}
						  	 <tr>
						  	 	<td class="taibcloor">{$rows_info.menu_name}</td>
						  	 	<td>{$rows_info.menu_price}</td>
						  	 	<td>{$rows_info.menu_quantity}</td>
						  	 	<td>{$rows_info.menu_quantity*$rows_info.menu_price}</td>
						  	 </tr>
                          {/foreach}
						  </tbody> 
					</table>
					 <!--分页-->
					<div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/banquet/shopbanquet/info','id'=>$data.banquet_id])}" method="get">
							<div class="fenye_conbox">
								<div class="fenye_titile">
									显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
									<a href="{\yii\helpers\Url::to(['/banquet/shopbanquet/info','id'=>$data.banquet_id])}">首页</a><a href="{\yii\helpers\Url::to(['/banquet/shopbanquet/info','id'=>$data.banquet_id,'page'=>$page.page-1])}">上一页</a><a href="{\yii\helpers\Url::to(['/banquet/shopbanquet/info','id'=>$data.banquet_id,'page'=>$page.page+1])}">下一页</a><a href="{\yii\helpers\Url::to(['/banquet/shopbanquet/info','id'=>$data.banquet_id,'page'=>10000])}">尾页</a>
									<input name="page" type="text" class="text" />
									<input type="submit" value="跳 转" class="tiaozhuan" />
								</div>
							</div>
						</form>
					</div>
		 		</div>
		 		
		 		
		 	</div>
		 	
		 	
		 	
		 </div>
	</body>
</html>
