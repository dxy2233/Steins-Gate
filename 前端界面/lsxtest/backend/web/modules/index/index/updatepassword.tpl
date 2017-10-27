<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>修改密码</title>
		<link rel="stylesheet" href="/css/index.css" />
		<script type="text/javascript" src="js/jquery-1.8.3.min.js" ></script>
	</head>
	<body>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><a href="javascript:window.history.back(-1)" class="label">修改资料</a>><label>修改密码</label>
			</div>
		 	<!--修改资料-->
		 	<div class="xiugaibox xiugaibox1">
				<div class="xiugai_name"><span>原密码：</span><label><input type="password" class="input_xiugai pwd1" id="password"/></label></div>
				<div class="xiugai_name"><span>新密码：</span><label><input type="password" class="input_xiugai pwd2" id="newpassword"/></label></div>
				<div class="xiugai_name"><span>确认密码：</span><label><input type="password" class="input_xiugai pwd3" id="newpasswordtwo"/></label></div>
				<div class="xiugai_name"><span></span><label><button class="querenbaocun" onclick="updatepassword()">确认修改</button></label></div>
		 	</div>
		 </div>
	</body>
	<script>
        function updatepassword(){
            var data={};
            var password = $('#password').val();
            var newpassword = $('#newpassword').val();
            var newpasswordtwo = $('#newpasswordtwo').val();
            if(password == ''){
                alert('原始密码不能为空');
                return false;
            }
            if(newpassword == ''){
                alert('密码不能为空');
                return false;
            }
            if(newpasswordtwo == ''){
                alert('二次密码不能为空');
                return false;
            }
            if(newpasswordtwo !== newpassword){
                alert('二次密码不一致');
                return false;
            }
            data.password=password;
            data.newpassword=newpassword;
            data.newpasswordtwo=newpasswordtwo;
            $.ajax({
                url:'/index/index/updatepassword',
                type:'POST',
                data:data,
                jsonType:'json',
                success:function(data){
                    if(data.success == 0){
                        alert(data.list);
                    }
                    if(data.success == 1){
                        alert(data.list);
                        window.history.back(-1);
                    }
                }
            });
        }
	</script>
</html>
