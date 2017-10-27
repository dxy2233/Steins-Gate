<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-19 07:14:01
  from "E:\lsxtest\seller\web\modules\user\login\login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c0c3b98c0d17_42796808',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a6f48bdc0588077925ecacf4c794ae560bf3de0d' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\user\\login\\login.tpl',
      1 => 1505805234,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c0c3b98c0d17_42796808 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title></title>
		<?php echo '<script'; ?>
 type="text/javascript" src="/js/jquery-1.8.3.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="/js/mui.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="/js/style.js"><?php echo '</script'; ?>
>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<?php echo '<script'; ?>
 type="text/javascript" charset="utf-8">
			mui.init();
		<?php echo '</script'; ?>
>
	</head>

	<body style="width: 100%;height: 100%;background: white;">
		<div class="box">
			<div class="loogbanner"><img src="/img/degnlu_banner.png" /></div>
			<form class="mui-input-group" id='shop_login'  action='' method='post' >
				<div class="mui-input-row">
					<label>用户名</label>
					<input type="text" name='shop_name' class="mui-input-clear" placeholder="请输入用户名">
				</div>
				<div class="mui-input-row">
					<label>密码</label>
					<input type="password" name='shop_password'  class="mui-input-password" placeholder="请输入密码">
				</div> 
				<div class="wagnjimima"><a href="#">忘记密码>></a></div>
				<div class="btn"><input type="button" id='btn_submit' value="登 录"></div>
			</form>
		</div>
	</body>
	<?php echo '<script'; ?>
 type="text/javascript" charset="utf-8">
	$().ready(function() {
		$("#btn_submit").click(function() {
			// console.log($("#shop_login").serialize());
			// console.log($("#shop_login").serializeArray());
			// return;
			$.ajax({
				cache: false,
				type: "POST",
				url: "/user/login/index",
				data: $("#user_login").serialize(),
				success: function(result) {
					if (result.status == 1) {
						alert('登录成功');
						window.location.href='/shop/center/index';
					} else {
						alert('登录失败');
					}
				},
				error: function(result) {
					alert("异常", {
						icon: 2
					});
				}
			});
		});

	});
	<?php echo '</script'; ?>
>

</html><?php }
}
