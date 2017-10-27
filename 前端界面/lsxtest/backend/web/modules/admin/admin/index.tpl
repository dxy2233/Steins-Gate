<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
	</head>
	<body>
		<!--所在位置显示-->
		<div class="weizhixianshi">
			<span>你的位置：</span><label>管理员管理</label>
		</div>
		<!--管理员管理-->
		<div class="guanliyuanguanli">
			<div class="shagnjianname">
                            <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['admin/index'])}" enctype="multipart/form-data">
                                <span>管理员账号：
                                <input type="text" class="shagn_name_ipu" placeholder="请输入管理员账号" name="user_name">
                                </span> 
                                <input type="submit" class="xinzen_dianpu1" style="background: #1c93e6; margin-right: 20px; float: right;" value="搜 索">
                                <a href="{\yii\helpers\Url::to(['admin/add'])}" class="xinzen_dianpu2" style="margin-right: 20px;">添加管理员</a>
								<a href="{\yii\helpers\Url::to(['admin/addrole'])}" class="xinzen_dianpu2" style="margin-right: 20px;">添加角色</a>
                            <input type="hidden" name="_csrf" id="csrf" value="{Yii::$app->request->csrfToken}">
                            </form>
			</div>
			<!--搜索表单-->
			<div class="suoshoubiaosdan">
			      <table class="gongsuou" cellpadding="0" cellspacing="0"> 
						  <tr class="gong_nav">
						  	  <td class="lefttalbe">管理员账号</td>
						  	  <td>姓名</td>
						  	  <td>手机号</td>
						  	  <td>管理员权限</td>
						  	  <td>状态</td>
						  	  <td>创建日期 </td>
						  	  <td>操作</td>
						  	   
						  </tr>
						  <tbody>
                          {if $data}
                                                    {foreach from=$data item=$val}
						  	 <tr>
						  	 	<td>{$val.user_name}</td>
						  	 	<td>{$val.real_name}</td>
						  	 	<td>{$val.mobile}</td>
						  	 	<td style="width: 356px;" class="guanliquanxian">{$val.role_name}</td>
						  	 	<td>{if $val.status == 0}禁用{else}启用{/if}</td>
						  	 	<td>{date('Y-m-d H:i:s',$val.create_time)}</td>
						  	 	<td><a href="{yii\helpers\Url::to(['admin/add'])}?id={$val.user_id}">编辑</a></td> 
						  	 </tr> 
                                                    {/foreach}
						  {/if}
						  </tbody> 
					</table>
					 <!--分页-->
			 	      	    <div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/admin/admin/index'])}" method="get">
                            {foreach from=$post item=post_info key=post_info_key}
								<input type="hidden" name="post[{$post_info_key}]" value="{$post_info}"/>
                            {/foreach}
							<div class="fenye_conbox">
								<div class="fenye_titile">
									显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
									<a href="{\yii\helpers\Url::to(['/admin/admin/index','post'=>$post])}">首页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/admin/admin/index','post'=>$post,'page'=>$page.page-1])}">上一页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/admin/admin/index','post'=>$post,'page'=>$page.page+1])}">下一页</a>
                                                                        <a href="{\yii\helpers\Url::to(['/admin/admin/index','post'=>$post,'page'=>10000])}">尾页</a>
									<input name="page" type="text" class="text" />
									<input type="submit" value="跳 转" class="tiaozhuan" />
								</div>
							</div>
						</form>
			 	    </div>
			   
			   
			   
			</div>
			
			 
		</div>
		 
		 
		 
	</body>
</html>
