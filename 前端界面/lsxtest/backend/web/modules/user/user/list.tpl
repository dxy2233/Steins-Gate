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
				<span>你的位置：</span><label>平台数据统计</label>
			</div>
			<!--用户管理-->
			<div class="yonghuaguali">
				<form  enctype="multipart/form-data" action="{yii\helpers\Url::to(['user/list'])}" method="post">
				<input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}"/>
				<div class="shagnjianname">
					<span>　账号名：<input type="text" class="shagn_name_ipu" name="user_name" value="{$post.user_name}" placeholder="请输入用户名称"></span>
					<span>　手机号：<input type="text" class="shagn_name_ipu" name="mobile" value="{$post.mobile}" placeholder="请输入手机号"></span>
					<span>状态：<select class="zhaugntai" name="user_status">
							<option value="">全部状态</option>
							<option value="1"  {if $post.user_status eq 1}selected{/if}>停用</option>
							<option value="2" {if $post.user_status eq 2}selected{/if}>启用</option>
						       </select>
					</span>
				</div>
				<div class="shagnjianname">
					<span>
						创建日期：
						<input class="jcDate" name="create_time_start" value="{$post.create_time_start}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
						<label>-</label>
						<input class="jcDate" name="create_time_end" value="{$post.create_time_end}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
					</span>
					{*<span style="margin-right: 0px;">地区筛选：*}
                               {*<span class="info">*}
                                       {*<label>*}
                                               {*<select id="s_province" name="s_province" onchange="gradeChange()">*}
                                                   {*{foreach from=$city.level item=$val}*}
													   {*<option value="{$val.region_code}" {if $post.s_province}{if $val.region_code == $post.s_province } selected {/if}{/if}>{$val.region_name}</option>*}
                                                   {*{/foreach}*}
												   {*<select>*}

                                               {*<select id="s_city" name="s_city" onchange="gradeChangetwo()">*}
                                                   {*{foreach from=$city.parent_code_one item=$val}*}
													   {*<option value="{$val.region_code}" {if $val.region_code == $post.s_city } selected {/if}>{$val.region_name}</option>*}
                                                   {*{/foreach}*}
												   {*<select>*}
                                               {*<select id="s_county" name="s_county">*}
                                                   {*{foreach from=$city.parent_code_two item=$val}*}
													   {*<option value="{$val.region_code}" {if $val.region_code == $post.s_county } selected {/if}>{$val.region_name}</option>*}
                                                   {*{/foreach}*}
												   {*<select>*}
                                       {*</label>*}
                                       {*<label id="show"></label>*}
                               {*</span>*}
                       {*</span>*}
					<button type="submit" class="xinzen_dianpu" style="background: #1c93e6;">搜　索</button>
				</div>
				</form>
				<!--统计-->
				<div class="yonghutongji">
					<div class="gongshi">共搜索到<span>{$page.count}</span>条数据</div>
                    {if $data neq ""}
					<table class="gongsuou" cellpadding="0" cellspacing="0">
						  <tr class="gong_nav">
						  	  <td class="lefttalbe">账户名</td>
						  	  <td>用户头像</td>
						  	  <td>姓名</td>
						  	  <td>手机号</td>
						  	  <td>地区</td>
						  	  <td>状态 </td>
						  	  <td>注册日期 </td>
						  	  <td class="righttalble">操作</td> 
						  </tr>
						  <tbody>
                          {foreach from=$data item=data_info key=data_info_key}
						  	 <tr>
						  	 	<td class="taibcloor">{$data_info.user_id}</td>
						  	 	<td class="img_icon"><img src="{$data_info.image_path}"/></td>
						  	 	<td>{$data_info.user_name}</td>
						  	 	<td>{$data_info.mobile}</td>
						  	 	<td>{$data_info.address_now}</td>
						  	 	<td>
									{if $data_info.user_status eq 0}停用{/if}
                                    {if $data_info.user_status eq 1}启用{/if}
								</td>
						  	 	<td>{date("Y-m-d H:i:s", $data_info.reg_time)}</td>
						  	 	<td><a href="/user/user/info?id={$data_info.user_id}">查看</a></td>
						  	 </tr>
                          {/foreach}
						  </tbody> 
					</table>
					{/if}
					<!--分页-->
					<div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/user/user/list'])}" method="get">
                            {foreach from=$post item=post_info key=post_info_key}
								<input type="hidden" name="post[{$post_info_key}]" value="{$post_info}"/>
                            {/foreach}
							<div class="fenye_conbox">
								<div class="fenye_titile">
									显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
									<a href="{\yii\helpers\Url::to(['/user/user/list','post'=>$post])}">首页</a><a href="{\yii\helpers\Url::to(['/user/user/list','post'=>$post,'page'=>$page.page-1])}">上一页</a><a href="{\yii\helpers\Url::to(['/user/user/list','post'=>$post,'page'=>$page.page+1])}">下一页</a><a href="{\yii\helpers\Url::to(['/user/user/list','post'=>$post,'page'=>10000])}">尾页</a>
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
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
	<script type="text/javascript" src="/js/jQuery-jcDate.js" ></script>
	<script  type="text/javascript" src="/js/gradeChange.js"></script>
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
