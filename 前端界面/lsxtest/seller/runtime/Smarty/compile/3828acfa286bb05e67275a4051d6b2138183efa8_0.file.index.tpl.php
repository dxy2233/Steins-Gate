<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-18 09:05:46
  from "E:\lsxtest\seller\web\modules\money\mywallet\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59bf8c6a4fff90_76503468',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3828acfa286bb05e67275a4051d6b2138183efa8' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\money\\mywallet\\index.tpl',
      1 => 1505725543,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59bf8c6a4fff90_76503468 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>我的钱包</title>
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
			 <div class="qianbao_box">
			 	<div class="title">账户余额(元)</div>
			 	<div class="qian_moery">9999.00</div>
			 </div>
			 <div class="qian_com">
			 	<a href="#" class="qian_nav">
			 		<i class="nav_img"><img src="/img/yinhangka.png"/></i>
			 		<span class="bangding">绑定银行卡<i><img src="/img/leftimg.png"/></i></span>
			 	</a>
			 	<a href="#" class="qian_nav">
			 		<i class="nav_img nav_img2"><img src="/img/shenqintixian.png"/></i>
			 		<span class="bangding">申请提现<i><img src="/img/leftimg.png"/></i></span>
			 	</a>
			 	<a href="#" class="qian_nav">
			 		<i class="nav_img nav_img3"><img src="/img/tixianjieguo.png"/></i>
			 		<span class="bangding">提现结果<i><img src="/img/leftimg.png"/></i></span>
			 	</a>
			 	<a href="#" class="qian_nav">
			 		<i class="nav_img nav_img4"><img src="/img/shourumignxi.png"/></i>
			 		<span class="bangding">账户明细<i><img src="/img/leftimg.png"/></i></span>
			 	</a>
			 	
			 </div>
			 
			 
			 
		</div>
	</body>

</html><?php }
}
