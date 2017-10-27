<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-21 01:59:55
  from "E:\lsxtest\seller\web\modules\shop\flowingseat\update.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c31d1b832ee5_00266981',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d7340ff775adfb974643c91f766905c2c0bbe71' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\shop\\flowingseat\\update.tpl',
      1 => 1505959174,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c31d1b832ee5_00266981 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>编辑流水席</title>
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
					 			 	<!-- <?php }?> --></label>
					<button class="kaixil">开席</button>
				</div>
				<div class="fenmian">
					<span>封面图</span>
					<label><img src="<?php echo (($tmp = @imageurl($_smarty_tpl->tpl_vars['list_msg']->value['banquet_url']))===null||$tmp==='' ? '/img/haixian_icon.png' : $tmp);?>
"/></label>
				</div>
				<div class="chapage1">
					<span>名称</span>
					<label><input type="text" class="jidian" name='banquet_name' value="<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['banquet_name'];?>
"></label>
				</div>
				<a href="class?type_id=<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['type_id'];?>
&banquet_id=<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['banquet_id'];?>
" class="chapage1">
					<span>类别</span>
					<label class="leibir2"><?php echo $_smarty_tpl->tpl_vars['list_msg']->value['type_name'];?>
</label>
					<i class="lefig"><img src="/img/leftimg.png"/></i>
				</a>
				<div class="tishi">
					<span>菜品</span>
					<label>* 菜品的价格不会作为实际价格结算，只作展示用</label>
				</div>
				<div class="caipinbox">
					<div class="chapage1">
						<span class="inpuname"><input  type="text" placeholder="请输入名称"></span>
						<label class="jiagexiugai">￥<input type="text"value=""></label>
						<!--<i class="jianhaoimg"><img src="/img/bianjian.png"/></i>-->
					</div>
				</div>
				<div class="jiajianbtn">
					<i class="jaiimg"><img src="/img/bianjijia.png"/></i>
				</div>
				<div class="chapage1">
					<span>每位价格</span>
					<label class="jiagexiugai">￥<input type="text"value="<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['price'];?>
"></label>
				</div>
				<div class="chapage1">
					<span>开席人数</span>
					<div class="mui-numbox jainbtnan" data-numbox-step='1' data-numbox-min='0' data-numbox-max='100'>
						<button class="mui-btn mui-numbox-btn-minus" type="button">-</button>
						<input class="mui-numbox-input" type="number" value='<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['total_peoples'];?>
' />
						<button class="mui-btn mui-numbox-btn-plus" type="button">+</button>
					</div>

				</div>
				<div class="chapage1">
					<span>每席总价</span>
					<label class="jiagexiugai">￥<input type="text"value="<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['banquet_amount'];?>
"></label>
				</div>
				<div class="chapage1">
					<span>每日最多开席数</span>
					<div class="mui-numbox jainbtnan" data-numbox-step='1' data-numbox-min='0' data-numbox-max='100'>
						<button class="mui-btn mui-numbox-btn-minus" type="button">-</button>
						<input class="mui-numbox-input" type="number" value='<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['banquet_number'];?>
' />
						<button class="mui-btn mui-numbox-btn-plus" type="button">+</button>
					</div>

				</div>
				<div class="shijian">
					<span>开启时间</span>
					<input type="date" value='<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['begin_time'];?>
' />
				</div>
				<div class="shijian" style="margin-top: 0rem;">
					<span>关闭时间</span>
					<input type="date" value='<?php echo $_smarty_tpl->tpl_vars['list_msg']->value['end_time'];?>
' />
				</div>
				
				
			</div>
            <div class="bianjitijia"> 
            	<button class="btn1">确认保存</button>
            	<button class="btnsc">删除</button>
            </div>
		</div>
	</body>
	<?php echo '<script'; ?>
>
		
		$(function() {
			$(".jaiimg").click(function() {
				$(".caipinbox").append("<div class='chapage1'><span class='inpuname'><input  type='text' placeholder='请输入名称'></span><label class='jiagexiugai'>￥<input type='text'value=''></label> <i class='jianhaoimg'><img src='/img/bianjian.png'/></i> </div>");
			});
			$('.caipinbox').on('click', '.jianhaoimg', function() {
				$(this).parents('.chapage1').eq(0).remove();
			});
			 

		})
	<?php echo '</script'; ?>
>

</html><?php }
}
