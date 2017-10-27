<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>修改密码</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<div class="box">
			<form  id='update_pwd'  action='' method='post' >
			 <div class="xiugai_pwd">
			 	  <div class="xiugaipwd_input">
			 	  	  <span>旧密码</span>
			 	  	  <label><input type="text" name='old_password' minlength='6' maxlength='16'  onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" placeholder="请输入旧密码"></label>
			 	  </div>
			 	  <div class="xiugaipwd_input">
			 	  	  <span>新密码</span>
			 	  	  <label><input type="text" name='new_password1'  onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"  minlength='6' maxlength='16'   placeholder="请输入新密码"></label>
			 	  </div>
			 	  <div class="xiugaipwd_input">
			 	  	  <span>确认新密码</span>
			 	  	  <label><input type="text" name='new_password2'  onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"  minlength='6' maxlength='16'   placeholder="请再次输入新密码"></label>
			 	  </div>
			 </div>
			 <div class="sublebtn">
					<input type="submit" value="确定" />
			</div>
		</form>
		</div>
	</body>
	<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		$("#update_pwd").submit(function() {
			var old_password = $("input[name='old_password']").val();
			var new_password1 = $("input[name='new_password1']").val();
			var new_password2 = $("input[name='new_password2']").val();
			if (old_password=='') {
				alert('请输入旧密码');
				return false;
			};
			if (new_password1=='') {
				alert('请输入新密码');
				return false;
			};
			if (new_password2=='') {
				alert('请再次输入新密码');
				return false;
			};
			if (new_password2!=new_password1) {
				alert('两次新密码不一致');
				return false;
			};
		});

	});
	</script>
</html>