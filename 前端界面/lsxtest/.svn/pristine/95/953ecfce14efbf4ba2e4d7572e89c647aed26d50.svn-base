<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-20 01:49:43
  from "E:\lsxtest\seller\web\modules\user\user\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c1c9379163c3_06651763',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1b046f07e5170a185b7e9cc98a912910270d01e0' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\user\\user\\index.tpl',
      1 => 1505872180,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c1c9379163c3_06651763 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>会员中心</title>
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
			 <div class="vip">
			 	<div class="vippage1">会员列表 (共<span><?php echo count($_smarty_tpl->tpl_vars['user_msg']->value);?>
</span>个)</div>
			 	<!-- /img/touxiangicon.png -->
			 	<!-- <?php if ($_smarty_tpl->tpl_vars['user_msg']->value) {?> -->
				<!-- <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_msg']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?> -->
			 	<div class="vippage2">
			 		<div class="vipage1">
			 			<i><img src="<?php echo imageurl($_smarty_tpl->tpl_vars['item']->value['image_path']);?>
"/></i>
			 			<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['nickname'])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['item']->value['user_name'] : $tmp);?>
</span>
			 		</div>
			 		<div class="vipage2">
			 			<span>注册时间：<label><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['item']->value['reg_time']);?>
</label></span>
			 			<span>共在你店里消费过<label><?php echo $_smarty_tpl->tpl_vars['item']->value['total_once'];?>
</label>次</span>
			 			<span>合计<label><?php echo $_smarty_tpl->tpl_vars['item']->value['total_money'];?>
</label>元</span>
			 			
			 		</div> 
			 	</div>
			 	<!-- <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 -->
			 	<!--<?php }?> -->
			 </div>
			 
			 
		</div>
	</body>

</html><?php }
}
