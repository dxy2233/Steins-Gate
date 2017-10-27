<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title></title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body style="width: 100%;height: 100%;background: white;">
		<div class="box">
			<div class="loogbanner"><img src="/img/degnlu_banner.png" /></div>
			<form class="mui-input-group" id='shop_login'  action='' method='post' >
				<div class="mui-input-row">
					<label>用户名</label>
					<input type="text" name='shop_name'  onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"   minlength='6' maxlength='16'    onkeyup="value=value.replace(/[^/w/.//]/ig,'')" class="mui-input-clear" placeholder="请输入用户名">
				</div>
				<div class="mui-input-row">
					<label>密码</label>
					<input type="password"  minlength='6' maxlength='16'     onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"  name='shop_password'  class="mui-input-password" placeholder="请输入密码">
				</div> 
				<div class="wagnjimima"><a class='show_tips'>忘记密码>></a></div>
				<div class="btn"><input type="button" class='btn_submit' value="登 录"></div>
			</form>
		</div>
	</body>
	<script type="text/javascript" charset="utf-8">
	var status_like=1;
	$().ready(function() {
		$('.show_tips').click(function() {
			alert('请联系客服帮您找密码：400-8888-8888');
		});
		$(".btn_submit").click(function() {
			if (status_like==0) {
				return false;
			};
			status_like=0;
			// console.log($("#shop_login").serialize());
			// console.log($("#shop_login").serializeArray());
			// return;
			if ($("input[name='shop_name']").val()=='') {
				alert('请输入用户名');
				return false;
			};
			if ($("input[name='shop_password']").val()=='') {
				alert('请输入密码');
				return false;
			};
			$.ajax({
				cache: false,
				type: "POST",
				url: "/user/login/index",
				data: $("#shop_login").serialize(),
				success: function(result) {
					if (result.status == 1) {
						alert('登录成功');
						if (result.msg==1) {
							window.location.href='/shop/sellermsg/index';
						}else{
							window.location.href='/shop/center/index';
						};
					} else {
						alert(result.msg);
					}
					status_like=1;
				},
				error: function(result) {
					alert("异常", {
						icon: 2
					});
				status_like=1;
				}
			});
		});

	});
	</script>

</html>