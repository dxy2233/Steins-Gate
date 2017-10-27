<?php
/* Smarty version {Smarty::SMARTY_VERSION}, created on 2017-09-20 06:49:17
  from "E:\lsxtest\seller\web\modules\shop\sellermsg\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-22',
  'unifunc' => 'content_59c20f6dd38cc3_25916971',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd03526313c5fd50649c003940b501276d2536433' => 
    array (
      0 => 'E:\\lsxtest\\seller\\web\\modules\\shop\\sellermsg\\index.tpl',
      1 => 1505890154,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59c20f6dd38cc3_25916971 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>商家资料</title>
		<?php echo '<script'; ?>
 type="text/javascript" src="/js/jquery-1.8.3.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="/js/mui.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="/js/style.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="/js/regular.js"><?php echo '</script'; ?>
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
			<form  id='shop_msg'  action='' method='post' >
				 <div class="shagnjaiziliao">
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">商家名称</span>
					 	 	<label class="btn_yonghu"><input type="text" readonly="true" value='<?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['shop_name'];?>
' placeholder="请输入商家名称"></label>
					 	 	<!--<i class="right_btn"><img src="img/right_icon.png"/></i>-->
					   </a>
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">固定电话</span>
					 	 	<label class="btn_yonghu"><input name='merchant_telphone' type="text" value='<?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['merchant_telphone'];?>
'  placeholder="请输入固定电话"></label>
					 	 	<i class="right_btn"><img src="/img/right_icon.png"/></i>
					   </a>
					   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">区域</span>
					 	 	<label class="btn_yonghu"><?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['region_code'];?>
</label> 
					   </a>
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">详细地址</span>
					 	 	<label class="btn_yonghu"> <?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['address'];?>
</label> 
					   </a>
				 	
				 </div>
				 <div class="shagnjaiziliao">
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">商家面积</span>
					 	 	<label class="btn_yonghu"><input name='merchant_area'  type="text" value='<?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['merchant_area'];?>
'  placeholder="请输入面积/m"></label>
					 	 	<!--<i class="right_btn"><img src="img/right_icon.png"/></i>-->
					   </a>
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">座位总数</span>
					 	 	<label class="btn_yonghu"><input name='merchant_seats'  type="text" value='<?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['merchant_seats'];?>
'  placeholder="请输入座位数"></label>
					 	 	<i class="right_btn"><img src="/img/right_icon.png"/></i>
					   </a>
					   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">店主姓名</span>
					 	 	<label class="btn_yonghu"><input name='merchant_name'  type="text" value='<?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['merchant_name'];?>
'  placeholder="请输入店主姓名"></label>
					 	 	<i class="right_btn"><img src="/img/right_icon.png"/></i>
					   </a>
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">店主手机</span>
					 	 	<label class="btn_yonghu"><input name='merchant_mobile'  value='<?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['merchant_mobile'];?>
'  type="text" placeholder="请输入店主手机号"></label>
					 	 	<i class="right_btn"><img src="/img/right_icon.png"/></i>
					   </a> 
				 </div>
				  <div class="shagnjaiziliao">
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">营业时间</span>
					 	 	<label class="btn_yonghu"><input name='opening_hour' readonly="true"   value='<?php echo $_smarty_tpl->tpl_vars['shop_msg']->value['opening_hour'];?>
'  type="date"></label>
					 	 	<i class="right_btn"><img src="/img/right_icon.png"/></i>
					   </a> 
				 </div>
				 
				 <div class="sublebtn">
						<input type="submit" value="保存" />
				</div>
			</form>
		</div>
	</body>
   <?php echo '<script'; ?>
>
   	  $(function(){
		 $("#shop_msg").submit(function() {
		 	// 固定电话
		 	var merchant_telphone = $("input[name='merchant_telphone']").val();
		 	// 商家面积
		 	var merchant_area = $("input[name='merchant_area']").val();
		 	// 座位总数
		 	var merchant_seats = $("input[name='merchant_seats']").val();
		 	// 店主姓名
		 	var merchant_name = $("input[name='merchant_name']").val();
		 	// 店主手机
		 	var merchant_mobile = $("input[name='merchant_mobile']").val();
		 	// 营业时间
		 	var opening_hour = $("input[name='opening_hour']").val();
		 	if (merchant_telphone!='') {
		 		if (!istell(merchant_telphone)) {
		 			alert('固定电话格式错误');
		 			return false;
		 		}
		 	}
		 	if (merchant_area<0) {
		 		alert('商家面积要大于0');
		 		return false;
		 	}
		 	if (merchant_seats==''||merchant_seats==null) {
	 			alert('座位总数不能为空');
	 			return false;
		 	}
		 	if (merchant_name==''||merchant_name==null) {
	 			alert('店主姓名不能为空');
	 			return false;
		 	}
		 	if (merchant_mobile!='') {
		 		if (!checkMobile(merchant_mobile)) {
		 			alert('店主手机格式错误');
		 			return false;
		 		}
		 	}
		 	if (opening_hour==''||opening_hour==null) {
	 			alert('营业时间不能为空');
	 			return false;
		 	}
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
