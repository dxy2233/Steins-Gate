<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>login</title>
<link rel="stylesheet" type="text/css" href="/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="/css/demo.css" />
<!--必要样式-->
<link rel="stylesheet" type="text/css" href="/css/component.css" />
<!--[if IE]>
<script src="js/html5.js"></script>
<![endif]-->
</head>
<body>
		<div class="container demo-1">
			<div class="content">
				<div id="large-header" class="large-header">
					<canvas id="demo-canvas"></canvas>
					<div class="logo_box">
						<h2 style="text-align: center;">欢迎登录流水席运维后台</h2>
						<form  enctype="multipart/form-data" action="{yii\helpers\Url::to(['login/login'])}" method="post">
							<input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}"/>
							<div class="input_outer">
								<span class="u_user"></span>
								<input name="user_name" class="text name" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">
							</div>
							<div class="input_outer">
								<span class="us_uer"></span>
								<input name="password" class="text pwd" style="color: #FFFFFF !important; position:relative; z-index:10000;"value="" type="password" placeholder="请输入密码">
							</div>
							<div class="mb2"><button class="act-but submit" href="#" style="color: #FFFFFF;width: 330px;">登录</button></div>
						</form>
					</div>
				</div>
			</div>
		</div><!-- /container -->
		<script src="/js/TweenLite.min.js"></script>
		<script src="/js/EasePack.min.js"></script>
		<script src="/js/rAF.js"></script>
		<script src="/js/demo-1.js"></script>
		 
	</body>
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
	<script>
	</script>
</html>