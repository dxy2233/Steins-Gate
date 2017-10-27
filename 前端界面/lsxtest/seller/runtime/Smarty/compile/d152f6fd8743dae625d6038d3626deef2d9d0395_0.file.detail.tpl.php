<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-20 08:13:45
  from "E:\lsxtest\seller\web\modules\shop\flowingseat\detail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c22339a08182_44903239',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd152f6fd8743dae625d6038d3626deef2d9d0395' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\shop\\flowingseat\\detail.tpl',
      1 => 1505895222,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c22339a08182_44903239 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>查看流水席</title>
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
			 <div class="chakna">
			 	   <div class="chapage1">
			 	   	   <span>席状态</span>
			 	   	   <label><!-- <?php if ($_smarty_tpl->tpl_vars['list_msg']->value['banquet_status'] < 1) {?> -->
					 			 	已停止
					 			 	<!-- <?php } else { ?> -->
					 			 	开席中
					 			 	<!-- <?php }?> -->
					 	</label>
			 	   </div>
			 	   <div class="fenmian">
			 	   	    <span>封面图</span>
			 	   	    <label><img src="<?php echo (($tmp = @imageurl($_smarty_tpl->tpl_vars['list_msg']->value['banquet_url']))===null||$tmp==='' ? '/img/haixian_icon.png' : $tmp);?>
"/></label>
			 	   </div>
			 	   <div class="chapage1">
			 	   	   <span>名称</span>
			 	   	   <label><?php echo $_smarty_tpl->tpl_vars['list_msg']->value['banquet_name'];?>
</label>
			 	   </div>
			 	   <div class="chapage1">
			 	   	   <span>类别</span>
			 	   	   <label class="leibir"><?php echo $_smarty_tpl->tpl_vars['list_msg']->value['type_name'];?>
</label>
			 	   </div>
			 	   <div class="tishi">
			 	   	   <span>菜品</span>
			 	   	   <label>* 菜品的价格不会作为实际价格结算，只作展示用</label>
			 	   </div>
			 	   <div class="chapage1">
			 	   	   <span>特色北京烤鸭</span>
			 	   	   <label class="chakanshul">1</label>
			 	   	   <label class="leibir">￥198</label>
			 	   </div>
			 	    <div class="chapage1">
			 	   	   <span>鱼香肉丝</span>
			 	   	   <label class="chakanshul">1</label>
			 	   	   <label class="leibir">￥198</label>
			 	   </div>
			 	   <div class="qita">其他参数</div>
			 	   <div class="chapage1">
			 	   	   <span>每位价格</span> 
			 	   	   <label class="leibir">￥<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['price'];?>
</label>
			 	   </div>
			 	    <div class="chapage1">
			 	   	   <span>开席人数</span> 
			 	   	   <label class="leibir"><?php echo $_smarty_tpl->tpl_vars['list_msg']->value['total_peoples'];?>
</label>
			 	   </div>
			 	   <div class="chapage1">
			 	   	   <span>每席总价</span> 
			 	   	   <label class="leibir">￥<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['banquet_amount'];?>
</label>
			 	   </div>
			 	   <div class="chapage1" style="margin-top: 0.2rem;">
			 	   	   <span>每日最多开席数</span> 
			 	   	   <label class="leibir"><?php echo $_smarty_tpl->tpl_vars['list_msg']->value['banquet_number'];?>
</label>
			 	   </div>
			 	    <div class="chapage1" style="margin-top: 0.2rem;">
			 	   	   <span>开启时间</span> 
			 	   	   <label class="leibir"><?php echo $_smarty_tpl->tpl_vars['list_msg']->value['begin_time'];?>
</label>
			 	   </div>
			 	    <div class="chapage1">
			 	   	   <span>关闭时间</span> 
			 	   	   <label class="leibir"><?php echo $_smarty_tpl->tpl_vars['list_msg']->value['end_time'];?>
</label>
			 	   </div>
			 	   
			 	   
			 </div>
			 
			 
		</div>
	</body>

</html><?php }
}
