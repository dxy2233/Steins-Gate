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
				<span>你的位置：</span><a href="{\yii\helpers\Url::to(['admin/index'])}" class="label">管理员管理</a>><label>添加角色</label>
			</div>
			<!--编辑-->
		 	<div class="guanlibianji">
                            <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['admin/addrole'])}" enctype="multipart/form-data" onsubmit = "return checkUser();" >
		 		    <div class="input_bainji input_bainji2">
		 				<span>角色名称：</span>
                                                <input type="text" placeholder="角色名称" name="role_name" id="user_name" value="" onblur="inputOnBlur();"/>
		 				<label><img src="/img/xinhao_icon.png"/></label>
		 			</div>
		 			 <div class="input_bainji input_bainji2">
		 				<span>角色描述：</span>
                                                <input type="text" placeholder="不超过12字符" name="role_desc" id="real_name" value=""/>
		 				<label><img src="/img/xinhao_icon.png"/></label>
		 			</div>
		 			<div class="input_bainji input_bainji2">
		 				<span>拥有权限：</span>
                        {foreach from=$list item=$val}
                         <label class="quanxintiti">
                             <input type="checkbox" class="cheboxinpu" id="menu_id" name="menu_id[]" value="{$val.menu_id}" >{$val.menu_name}
                         </label>
                        {/foreach}
		 			</div>
		 			<div class="input_bainji input_bainji2">
		 				 <input type="submit" class="queren queren2" style=" margin-left: 155px;margin-right: 20px;" value="保 存">
{*		 				 <input type="" class="queren queren2" style="background: #ff7bac; margin-left: 20px;margin-right: 20px;" value="取 消">*}
		 			 
		 			</div>

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
