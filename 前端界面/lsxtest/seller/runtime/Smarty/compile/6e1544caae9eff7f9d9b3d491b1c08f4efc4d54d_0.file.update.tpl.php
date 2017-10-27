<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-20 05:53:05
  from "E:\lsxtest\seller\web\modules\shop\variety\update.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c202419d62b1_45272448',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6e1544caae9eff7f9d9b3d491b1c08f4efc4d54d' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\shop\\variety\\update.tpl',
      1 => 1505886732,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c202419d62b1_45272448 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>菜品修改</title>
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
			<form  id='update_menu'  action='' method='post' >
			  <div class="tianjaicaipin">
			  	<div class="menuBox">
			  		<div class="remcov">删除</div>
			  		<div class="tianjiapage">
			  	    	<input type="text" class="tianname" name='menu_name' value='<?php echo $_smarty_tpl->tpl_vars['variety_one']->value['menu_name'];?>
' placeholder="请输入菜品名称" />
			  	    	￥<input type="text" class="tianjaige"  name='menu_price' value="<?php echo $_smarty_tpl->tpl_vars['variety_one']->value['menu_price'];?>
" /> 
			  	    	<input type="hidden" name='menu_id' value="<?php echo $_smarty_tpl->tpl_vars['variety_one']->value['menu_id'];?>
" /> 
			  	   </div> 
			  	</div>
			  	   
			  	<div class="sublebtn">
					<input type="submit" value="确认修改" />
			    </div>
			
			  </div>
			</form>
			  
		</div>
	</body>
   <?php echo '<script'; ?>
>
         $(function(){
         	$(".remcov").click(function(){
         		if(window.confirm('是否删除？')){
         			var menu_id = $("input[name='menu_id']").val();
         			if (menu_id) {
	         			$.ajax({
							cache: false,
							type: "POST",
							url: "/shop/variety/delete",
							data: $("#update_menu").serialize(),
							success: function(result) {
								if (result.status == 1) {
									alert('删除成功');
									window.location.href='/shop/variety/index';
								} else {
									alert('删除失败');
								}
							},
							error: function(result) {
								alert("异常", {
									icon: 2
								});
							}
						});
         			}
	            }
         	});
         	
	        $("#update_menu").submit(function() {
				if($('.tianname').val()==null){
					alert('菜名不能为空');
					return false;
				}
				if($('.tianjaige').val()<0){
					alert('菜品价格不能为空');
					return false;
				}
			});
         })
   <?php echo '</script'; ?>
>
</html><?php }
}
