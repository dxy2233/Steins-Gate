<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-20 07:26:21
  from "E:\lsxtest\seller\web\modules\shop\flowingseat\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c2181dac8591_02646306',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf4184aec52ff0e5aa19060bed960a1470d75434' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\shop\\flowingseat\\index.tpl',
      1 => 1505892289,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c2181dac8591_02646306 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>流水席管理</title>
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
			 <div class="quanbuliushuixi">
			 	<span>全部流水席　共 <label><?php echo count($_smarty_tpl->tpl_vars['list']->value);?>
</label> 席</span>
			 </div>
			 <!-- <?php if ($_smarty_tpl->tpl_vars['list']->value) {?> -->
				<!-- <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?> -->
					<div class="quanbu_guanli">
					 	<div class="guanlixiagnqi">
					 		<div class="logoimg"><img src="<?php echo (($tmp = @imageurl($_smarty_tpl->tpl_vars['item']->value['banquet_url']))===null||$tmp==='' ? '/img/haixian_icon.png' : $tmp);?>
"/></div>
					 		<div class="xia_qin">
					 			 <span class="jindain"><?php echo $_smarty_tpl->tpl_vars['item']->value['banquet_name'];?>
</span>
					 			 <span class="kaixi">开席人数：<label><?php echo $_smarty_tpl->tpl_vars['item']->value['total_peoples'];?>
</label>人</span>
					 			 <span class="menshijia">门市价：<label>￥<?php echo $_smarty_tpl->tpl_vars['item']->value['banquet_amount'];?>
</label></span> 
					 		</div>
					 		<div class="zhuagntai">
					 			 <span class="zhuagntai_kaixk">
					 			 	
					 			 	<!-- <?php if ($_smarty_tpl->tpl_vars['item']->value['banquet_status'] < 1) {?> -->
					 			 	已停止
					 			 	<!-- <?php } else { ?> -->
					 			 	开席中
					 			 	<!-- <?php }?> -->
					 			 </span>
					 			 <span class="kaixi">席桌上线：<label><?php echo $_smarty_tpl->tpl_vars['item']->value['banquet_number'];?>
</label>桌/天</span>
					 			 <span class="menshijia">每人价格：<label>￥<?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
</label></span>  
					 		</div> 
					 	</div>
					    <div class="chakan_bianji"> 
				 	 		 	<a href="update?banquet_id=<?php echo $_smarty_tpl->tpl_vars['item']->value['banquet_id'];?>
" class="chakankbox">编辑</a>
				 	 		 	<a href="detail?banquet_id=<?php echo $_smarty_tpl->tpl_vars['item']->value['banquet_id'];?>
" class="chakankbox">查看</a> 
					    </div> 
					 </div>
			 	<!-- <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 -->
			 <!--<?php }?> -->
			 <div class="tianjiaicon">
				<a href="#"><img src="/img/tianjaiinco.png"/></a>
			</div>
		</div>
	</body>

</html><?php }
}
