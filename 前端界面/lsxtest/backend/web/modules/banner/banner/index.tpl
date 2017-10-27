<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
	</head>
	<style>
		input[type="file"] {
		  color: transparent;
		}
	</style>
	<body>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><label>轮播图管理</ label>
			</div>
		 	<!--添加轮播图-->
		 	<div class="shagnjiachakan">
		 		 <div class="chakntongji" style="border-bottom: none;">
		 			<div class="shagnjiaqiben" style="margin-bottom: 20px;"><a href="{yii\helpers\Url::to(['banner/add'])}" class="xinzen_dianpu" style="float: right;background: #1c93e6;">添加轮播图</a></div>
		 			<table class="gongsuou" cellpadding="0" cellspacing="0" >
						  <tr class="gong_nav">
						  	  <td class="lefttalbe">轮播图图片</td>
						  	  <td>说明</td> 
						  	  <td>链接</td> 
						  	  <td>操作者</td> 
						  	  <td class="righttalble">操作</td> 
						  </tr>
						  <tbody> 
                                                        {foreach from=$data item=$val}
						  	 <tr>
						  	 	<td class="lunboicon">
                                                                    {if $val.carousel_path}
                                                                        <img src="{imageurl($val.carousel_path)}"/>
                                                                    {else}
                                                                        <img src="/img/lunbotu_icon.png"/>
                                                                    {/if}
                                                                </td>
						  	 	<td>{$val.carousel_descprtion}</td> 
						  	 	<td>{$val.carousel_url}</td> 
						  	 	<td>{$val.user_name}</td> 
						  	 	<td class="taibcloor" style="cursor: pointer;">
                                                                    <a href="{yii\helpers\Url::to(['banner/add'])}?id={$val.carousel_id}">编辑</a>
                                                                    <a onClick="return confirm('确认要删除？')" href="{yii\helpers\Url::to(['banner/del'])}?id={$val.carousel_id}">删除</a>
                                                                </td>
						  	 </tr>  
						  	{/foreach}
						  </tbody> 
					</table>
					 <!--分页-->
			 	      	    <div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/banner/banner/index'])}" method="get">
                         
							<div class="fenye_conbox">
								<div class="fenye_titile">
									显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
									<a href="{\yii\helpers\Url::to(['/banner/banner/index'])}">首页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/banner/banner/index','page'=>$page.page-1])}">上一页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/banner/banner/index','page'=>$page.page+1])}">下一页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/banner/banner/index','page'=>10000])}">尾页</a>
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
