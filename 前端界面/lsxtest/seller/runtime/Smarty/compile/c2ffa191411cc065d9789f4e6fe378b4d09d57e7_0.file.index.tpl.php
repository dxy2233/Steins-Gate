<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-20 01:43:01
  from "E:\lsxtest\seller\web\modules\shop\flowingverification\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c1c7a54b4f64_49500645',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c2ffa191411cc065d9789f4e6fe378b4d09d57e7' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\shop\\flowingverification\\index.tpl',
      1 => 1505871762,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c1c7a54b4f64_49500645 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>流水码验证</title>
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

	<body>
		<div class="box"> 
			<form class="mui-input-group" action='result' method='post'>
				<div class="mui-input-row">
					<label>流水码</label>
					<input type="text" name='buy_number' class="mui-input-clear" placeholder="请输入流水码">
				</div> 
			<div class="btn2"><input type="submit" value="点击验证"></div>
			</form> 
			<div class="chakanklishi"><a href="history">查看历史</a></div>
			 
		</div>
	</body>

</html><?php }
}
