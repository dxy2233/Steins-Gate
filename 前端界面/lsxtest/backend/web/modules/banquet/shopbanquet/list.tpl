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
				<span>你的位置：</span><label>流水席管理</label>
			</div>
       	    <!--流水席管理-->
       	    <div class="liushuixiguanli">
				<form  enctype="multipart/form-data" action="{yii\helpers\Url::to(['shopbanquet/list'])}" method="post">
				<input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}"/>
       	    	<div class="shagnjianname">
					<span>流水席名称：<input type="text" class="shagn_name_ipu" placeholder="请输入流水席名称" name="banquet_name" value="{$post.banquet_name}"></span>
					<span>所属商家：<input type="text" class="shagn_name_ipu" placeholder="请输入商家名称" name="shop_name" value="{$post.shop_name}"></span>
					
				</div>
       	    	<div class="shagnjianname">
					<span>流水席编号：<input type="text" class="shagn_name_ipu" placeholder="请输入流水席编号" name="banquet_id" value="{$post.banquet_id}" ></span>
					<span style="margin-right: 0px;">类　　别：<select class="zhaugntai" name="type_id">
							<option value="">全部类别</option>
                            {foreach from=$type item=type_info}
								<option value="{$type_info.type_id}"  {if $post.type_id eq $type_info.type_id}selected{/if}>{$type_info.type_name}</option>
                            {/foreach}
						</select></span>
					<input type="submit" class="xinzen_dianpu" style="background: #1c93e6;margin-right: 0px;" value="搜索"> 
					
				</div>
				</form>
       	    	<!--搜索表单-->
				<div class="suoshoubiaosdan">
					<div class="gongshi">共搜索到<span>{$page.count}</span>条数据</div>
					<table class="gongsuou index5_cente" cellpadding="0" cellspacing="0">
						  <tr class="gong_nav">
						  	  <td class="lefttalbe">流水席编号</td>
						  	  <td>流水席名称</td>
						  	  <td>类别</td>
						  	  <td>创建日期</td>
						  	  <td>所属商家</td>
						  	  <td>每日席数上限 </td>
						  	  <td>成席人数 </td>
						  	  <td>每席总价 </td>
						  	  <td>状态 </td>
						  	  <td class="righttalble">操作</td> 
						  </tr>
                        {if $data neq ""}
						  <tbody>
                          {foreach from=$data item=data_info key=data_info_key}
						  	 <tr>
						  	 	<td class="taibcloor">{$data_info.banquet_id}</td>
						  	 	<td>{$data_info.banquet_name}</td>
						  	 	<td>{$data_info.type_name}</td>
						  	 	<td>{date("Y-m-d H:i:s", $data_info.create_time)}</td>
						  	 	<td>{$data_info.shop_name}</td>
						  	 	<td>{$data_info.banquet_number}</td>
						  	 	<td>{$data_info.total_peoples}</td>
						  	 	<td>￥{$data_info.price}</td>
						  	 	<td>
                                 {if $data_info.banquet_status eq 0}停用{/if}
                                 {if $data_info.banquet_status eq 1}启用{/if}
								</td>
						  	 	<td><a href="/banquet/shopbanquet/info?id={$data_info.banquet_id}">查看</a></td>
						  	 </tr>
                          {/foreach}
						  	 
						  </tbody>
						{/if}
					</table>
					 <!--分页-->
					<div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['shopbanquet/list'])}" method="get">
                            {foreach from=$post item=post_info key=post_info_key}
								<input type="hidden" name="post[{$post_info_key}]" value="{$post_info}"/>
                            {/foreach}
							<div class="fenye_conbox">
								<div class="fenye_titile">
									显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
									<a href="{\yii\helpers\Url::to(['shopbanquet/list','post'=>$post])}">首页</a><a href="{\yii\helpers\Url::to(['shopbanquet/list','post'=>$post,'page'=>$page.page-1])}">上一页</a><a href="{\yii\helpers\Url::to(['shopbanquet/list','post'=>$post,'page'=>$page.page+1])}">下一页</a><a href="{\yii\helpers\Url::to(['shopbanquet/list','post'=>$post,'page'=>10000])}">尾页</a>
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
