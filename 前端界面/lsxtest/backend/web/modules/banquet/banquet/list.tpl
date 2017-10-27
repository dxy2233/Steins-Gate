<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
		<link rel="stylesheet" href="/css/jcDate.css" />
	</head>
	<body>
		  <div class="combox">
		  	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><label>席单管理</label>
			</div>
		  	<!--席单管理-->
		  	<div class="xidanguali">
				<form  enctype="multipart/form-data" action="{yii\helpers\Url::to(['/banquet/banquet/list'])}" method="post">
					<input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}"/>
		  		<div class="shagnjianname">
					<span>　席单号：<input type="text" class="shagn_name_ipu" name="banquet_sn" value="{$post.banquet_sn}" placeholder="请输入席单号"></span>
					<span>
						开席日期：
						<input class="jcDate" name="banquet_time_start" value="{$post.banquet_time_start}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
						<label>-</label>
						<input class="jcDate" name="banquet_time_end" value="{$post.banquet_time_end}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
					</span>
					<span>所属商家：<input type="text" class="shagn_name_ipu" name="shop_name" value="{$post.shop_name}" placeholder="请输入商家名字"></span>

				</div>
		  		<div class="shagnjianname">
					<span>　订单号：<input type="text" class="shagn_name_ipu" placeholder="请输入订单号" name="record_sn" value="{$post.record_sn}"></span>
					<span>
						创建日期：
						<input class="jcDate"  name="create_time_start" value="{$post.create_time_start}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
						<label>-</label>
						<input class="jcDate"  name="create_time_end" value="{$post.create_time_end}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
					</span>
					<span style="margin-right: 0px;">类　　型：<select class="zhaugntai" name="order_status">
							<option value="">全部类型</option>
							<option value="">全部类型</option>
							<option value="1" {if $post.order_status eq 1}selected{/if}>拼席中</option>
							<option value="2" {if $post.order_status eq 2}selected{/if}>拼席成功</option>
							<option value="3" {if $post.order_status eq 3}selected{/if}>已退款</option>
							<option value="4" {if $post.order_status eq 4}selected{/if}>已完成</option>
						</select></span>
					<button class="xinzen_dianpu" style="background: #1c93e6;margin-right: 0px;">搜　索</button> 
					 
				</div>
				</form>
		  		<!--用户全部订单-->
		  		<div class="suoshoubiaosdan">
					<div class="gongshi">
						<label class="btn_anniu {if $post.order_status eq null}btn_anniubg{/if} ">全部订单</label>
						<label class="btn_anniu {if $post.order_status eq 1}btn_anniubg{/if}" >拼席中</label>
						<label class="btn_anniu {if $post.order_status eq 2}btn_anniubg{/if}">拼席成功</label>
						<label class="btn_anniu {if $post.order_status eq 4}btn_anniubg{/if}">已完成</label>
						<label class="btn_anniu {if $post.order_status eq 3}btn_anniubg{/if}">已退款</label>
						共搜索到<span>{$page.count}</span>条数据</div>
					{if $data neq ""}
					<table class="gongsuou" cellpadding="0" cellspacing="0">
						  <tr class="gong_nav">
						  	  <td class="lefttalbe">席单号</td>
						  	  <td>流水席名称</td>
						  	  <td>类型</td>
						  	  <td>人数</td>
						  	  <td>价格￥</td>
						  	  <td>所属商家 </td>
						  	  <td>状态 </td>
						  	  <td>开席日期 </td>
						  	  <td>创建日期 </td> 
						  	  <td class="righttalble">操作</td> 
						  </tr>
						  <tbody>
                          {foreach from=$data item=data_info key=data_info_key}
						  	 <tr>
						  	 	<td class="taibcloor">{$data_info.banquet_sn}</td>
						  	 	<td>{$data_info.banquet_name}</td>
						  	 	<td>{$data_info.type_name}</td>
						  	 	<td>{$data_info.joined_peoples}/{$data_info.total_peoples}</td>
						  	 	<td>{$data_info.order_price*$data_info.joined_peoples}</td>
						  	 	<td>{$data_info.shop_name}</td>
						  	 	<td>
									{if $data_info.order_status eq 0}拼席中{/if}
                                    {if $data_info.order_status eq 1}拼席成功{/if}
                                    {if $data_info.order_status eq 2}已退款{/if}
                                    {if $data_info.order_status eq 3}已完成{/if}
								</td>
						  	 	<td>{date("Y-m-d H:i:s", $data_info.banquet_time)}</td>
						  	 	<td>{date("Y-m-d H:i:s", $data_info.create_time)}</td>
						  	 	<td><a href="/banquet/banquet/info?id={$data_info.order_id}">查看</a></td>
						  	 </tr>
						  {/foreach}
						  	 
						  	 
						  </tbody> 
					</table>
					 <!--分页-->
			 	    <div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/banquet/banquet/list'])}" method="get">
                            {foreach from=$post item=post_info key=post_info_key}
								<input type="hidden" name="post[{$post_info_key}]" value="{$post_info}"/>
                            {/foreach}
			 	    	<div class="fenye_conbox">
			 	    		<div class="fenye_titile">
			 	    			显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
			 	    			<a href="{\yii\helpers\Url::to(['/banquet/banquet/list','post'=>$post])}">首页</a><a href="{\yii\helpers\Url::to(['/banquet/banquet/list','post'=>$post,'page'=>$page.page-1])}">上一页</a><a href="{\yii\helpers\Url::to(['/banquet/banquet/list','post'=>$post,'page'=>$page.page+1])}">下一页</a><a href="{\yii\helpers\Url::to(['/banquet/banquet/list','post'=>$post,'page'=>10000])}">尾页</a>
								<input name="page" type="text" class="text" />
			 	    		    <input type="submit" value="跳 转" class="tiaozhuan" />
			 	    		</div>
			 	    	</div>
						</form>
			 	    </div>
					{/if}
				</div>
		  		
		  		
		  		
		  		
		  	</div>
		  	
		  	
		  	
		  	
		  </div>
	</body>
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
	<script type="text/javascript" src="/js/jQuery-jcDate.js" ></script>
	<script>
		$(function(){
			$(".jcDate").jcDate({
				IcoClass: "jcDateIco",
				Event: "click",
				Speed: 100,
				Left: 0,
				Top: 28,
				format: "-",
				Timeout: 100
			});
			
		})
		
	</script>
</html>
