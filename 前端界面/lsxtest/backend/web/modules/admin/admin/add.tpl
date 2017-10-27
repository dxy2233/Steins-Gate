<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
                <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
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
				<span>你的位置：</span><a href="{\yii\helpers\Url::to(['admin/index'])}" class="label">管理员管理</a>><label>编辑</label>
			</div>
			<!--编辑-->
		 	<div class="guanlibianji">
                            <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['admin/add'])}" enctype="multipart/form-data" onsubmit = "return checkUser();" >
		 		    <div class="input_bainji input_bainji2">
		 				<span>管理名称：</span>
                                                <input type="text" placeholder="登录名" name="user_name" id="user_name" value="{if $data.user_name}{$data.user_name}{/if}" onblur="inputOnBlur();"/>
		 				<label><img src="/img/xinhao_icon.png"/></label>
		 			</div>
                                        {if $data.user_id}  
		 			 <div class="input_bainji input_bainji2">
		 				<span>密码：</span>
                                                <em class="congzhipwd" onclick="btn_export()">重置密码</em>
		 			</div>
                                        {/if}       
		 			 <div class="input_bainji input_bainji2">
		 				<span>姓名：</span>
                                                <input type="text" placeholder="不超过12字符" name="real_name" id="real_name" value="{if $data.real_name}{$data.real_name}{/if}"/>
		 				<label><img src="/img/xinhao_icon.png"/></label>
		 			</div>
		 			 <div class="input_bainji input_bainji2">
		 				<span>手机号：</span>
                                                <input type="text" placeholder="11位数字" name="mobile" id="mobile" value="{if $data.mobile}{$data.mobile}{/if}"/>
		 				<label><img src="/img/xinhao_icon.png"/></label>
		 			</div>
		 			<div class="input_bainji input_bainji2">
		 				<span>账号状态：</span>
		 				<select class="zhaugntai" name="status">
                                                    <option value="1" {if $data.status == 1}selected{/if}>启用</option>
                                                    <option value="0" {if $data.status == 0}selected{/if}>禁用</option>
                                                </select>
		 				<label><img src="/img/xinhao_icon.png"/></label>
		 			</div>
		 			<div class="input_bainji input_bainji2">
		 				<span>拥有权限：</span>
                                                {foreach from=$list item=$val}
                                                    <label class="quanxintiti">
                                                        <input type="radio" class="cheboxinpu" id="role_id" name="role_id" value="{$val.role_id}" {if $data.role_id}{if $val.role_id == $data.role_id}checked{/if}{/if}>{$val.role_name}
                                                    </label>
                                                {/foreach}
		 			</div>
		 			<div class="input_bainji input_bainji2">
		 				 <input type="submit" class="queren queren2" style=" margin-left: 155px;margin-right: 20px;" value="保 存">
{*		 				 <input type="" class="queren queren2" style="background: #ff7bac; margin-left: 20px;margin-right: 20px;" value="取 消">*}
		 			 
		 			</div>
                                        <input type="hidden" value="{$data.user_id}" name="user_id" id="user_id"/>
                                        <input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}">
		 		</form>	
		 		
		 		
		 	</div>
		 	
		 </div>
	</body>
        	<script>
    function checkUser(){
       var user_name = document.getElementById("user_name").value;
       var real_name = document.getElementById("real_name").value;
       var mobile = document.getElementById("mobile").value;
       if(user_name == ""  ){
         alert("名称不能为空");
         return false;
       }
       if(real_name == ""  ){
         alert("姓名不能为空");
         return false;
       }
       if(real_name.length >12  ){
         alert("姓名不能大于12个字符");
         return false;
       }
       if(mobile == ""){
        alert("手机不能为空");
         return false;
       }
        
       document.getElementById("formid").submit();
       
      
    }
    function inputOnBlur(){
        var data={};
            var user_name = document.getElementById("user_name").value;
            data.user_name=user_name;
             $.ajax({
                url:'/admin/admin/list',
                type:'POST',
                data:data,
                jsonType:'json',
                success:function(data){
                    if(data.success == 1){
                        return true;
                    }
                     if(data.success == 0){
                        alert('管理员账号已存在');
                        $('#user_name').val('');
                        return false;
                    }
                } 
            });
    }
    function btn_export() {
        if(!confirm("确认要重新设置密码吗？")){ 
            return false; 
        }
        var data={};
            var user_id = document.getElementById("user_id").value;
            data.user_id=user_id;
             $.ajax({
                url:'/admin/admin/newpassword',
                type:'POST',
                data:data,
                jsonType:'json',
                success:function(data){
                    if(data.success == 1){
                        alert(data.data);
                        return true;
                    }
                     if(data.success == 0){
                        alert(data.data);
                        return false;
                    }
                } 
            });
    }
	</script>
</html>
