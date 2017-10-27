<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-19 07:53:53
  from "E:\lsxtest\seller\web\modules\shop\variety\add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c0cd112fc8d0_62753789',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fde1050416ad011b36fcffa3b4b88a27e07ad413' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\shop\\variety\\add.tpl',
      1 => 1505807562,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c0cd112fc8d0_62753789 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>菜品管理</title>
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
			<form  id='add_menu'  action='' method='post' >
			  <div class="tianjaicaipin">
			  	<div class="menuBox">
			  		<div class="tianjiapage">
			  	    	<input type="text" class="tianname" name='menu_name[]' value='' placeholder="请输入菜品名称" />
			  	    	￥<input type="text" class="tianjaige" name='menu_price[]' value="" /> 
			  	    	<!--<i class="guabi"><img src="img/jianbtn.png"/></i>-->
			  	    </div>
			  	    
			  	</div>
			  	    
			  	    <div class="tianjaibtn">
			  	    	<span><img src="/img/jiabtn.png" class="jia"/></span> 
			  	    </div>
			  	    <div class="sublebtn">
					    <input type="submit" value="确认" />
					</div>

			  </div>
			</form>
		</div>
	</body>
   <?php echo '<script'; ?>
>
   	  $(function(){
   	  	 $(".jia").click(function(){
   	  	 	$(".menuBox").append("<div class='tianjiapage'><input name='menu_name[]'  type='text' class='tianname' placeholder='请输入菜品名称' />￥<input type='text' name='menu_price[]'  class='tianjaige' value='' /><i class='guabi'><img src='/img/jianbtn.png'/></i></div>");
   	  	 });
   	  	 $('.menuBox').on('click','.guabi',function(){
   	   		$(this).parents('.tianjiapage').eq(0).remove();   	  	 	
   	  	 })
   	  	 $("#add_menu").submit(function() {
   // 	  	 	var list=document.getElementsByClassName("tianname");//少敲了一个name
			// for(var i=0;i<list.length;i++){
   // 	  	 		console.log(list[i].value());
			// }
			// if($('.tianname').val()==null){
			// 	alert('菜名不能为空');
			// 	return false;
			// }
			// if($('.tianjaige').val()<0){
			// 	alert('菜品价格不能为空');
			// 	return false;
			// }
			// return false;
		});
   	  })
   	
   <?php echo '</script'; ?>
>
</html><?php }
}
