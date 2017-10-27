<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>修改资料</title>
		<link rel="stylesheet" href="/css/index.css" />
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
	</head>
	<body>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><label>修改资料</ label>
			</div>
		 	<!--修改资料-->
                       
		 	<div class="xiugaibox xiugaibox1">
                             <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['index/updteadmin'])}" enctype="multipart/form-data">
		 		<div class="xiugai_name"><span>管理员账号：</span><label>{$list.user_name}</label></div>
		 		<div class="xiugai_name"><span>登录密码：</span><a href="{yii\helpers\Url::to(['index/updatepasswords'])}" class="xiugaimiam">修改密码</a></div>
		 		<div class="xiugai_name"><span>姓名：</span><label><input type="text" class="input_xiugai" name="real_name" {if $list.real_name}{$list.real_name}{/if} value="{if $list.real_name}{$list.real_name}{/if}"/></label></div>
		 		<div class="xiugai_name"><span>手机号：</span><label><input type="text" class="input_xiugai" name="mobile" {if $list.mobile}{$list.mobile}{/if} value="{if $list.mobile}{$list.mobile}{/if}"/></label></div>
		 		<div class="xiugai_name"><span>拥有权限：</span><label class="yonghua">{$role}</label></div>
		 		<div class="xiugai_name"><span></span><label><button class="querenbaocun">确认保存</button></label></div>
                                <input type="hidden" value="{$list.user_id}" name="user_id"/>
                                <input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}">
                              </form>  
		 	</div>
		 	

                        
		 </div>
	</body>
	<script>
	</script>
</html>
