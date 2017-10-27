<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>商家资料</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="/js/DateTimePicker.js" ></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<script type="text/javascript" src="/js/regular.js"></script>
		<link rel="stylesheet" href="/css/DateTimePicker.css" />
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<div class="box">
			<form  id='shop_msg'  action='' method='post' >
				 <div class="shagnjaiziliao">
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">商家名称</span>
					 	 	<label class="btn_yonghu"><input type="text" maxlength='16' readonly="true" value='{$shop_msg.shop_name}' placeholder="请输入商家名称"></label>
					 	 	<!--<i class="right_btn"><img src="img/right_icon.png"/></i>-->
					   </a>
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">固定电话</span>
					 	 	<label class="btn_yonghu"><input name='merchant_telphone' type="text" value='{$shop_msg.merchant_telphone}' maxlength='16' placeholder="请输入固定电话"></label>
					 	 	<!-- <i class="right_btn"><img src="/img/right_icon.png"/></i> -->
					   </a>
					   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">区域</span>
					 	 	<label class="btn_yonghu">{$shop_msg.region_code}</label> 
					   </a>
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">详细地址</span>
					 	 	<label class="btn_yonghu"> {$shop_msg.address}</label> 
					   </a>
				 	
				 </div>
				 <div class="shagnjaiziliao">
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">商家面积</span>
					 	 	<label class="btn_yonghu"><input name='merchant_area' maxlength='10'  type="text" value='{$shop_msg.merchant_area}'  placeholder="请输入面积/m"></label>
					 	 	<!--<i class="right_btn"><img src="img/right_icon.png"/></i>-->
					   </a>
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">座位总数</span>
					 	 	<label class="btn_yonghu"><input name='merchant_seats' maxlength='8'  type="text" value='{$shop_msg.merchant_seats}'  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="请输入座位数"></label>
					 	 	<!-- <i class="right_btn"><img src="/img/right_icon.png"/></i> -->
					   </a> 
					   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">店主姓名</span>
					 	 	<label class="btn_yonghu"><input name='merchant_name' maxlength='16'  type="text" value='{$shop_msg.merchant_name}'  placeholder="请输入店主姓名"></label>
					 	 	<!-- <i class="right_btn"><img src="/img/right_icon.png"/></i> -->
					   </a>
				 	   <a href="#" class="yonghuname">
					 	 	<span class="icon_name">店主手机</span>
					 	 	<label class="btn_yonghu"><input name='merchant_mobile' maxlength='11'  value='{$shop_msg.merchant_mobile}'  type="text" placeholder="请输入店主手机号"></label>
					 	 	<!-- <i class="right_btn"><img src="/img/right_icon.png"/></i> -->
					   </a> 
				 </div>

				  <div class="kaiqishijian" style="margin-top: 0rem;">
					<span style="font-size: 0.32rem;">营业时间</span>
					<label>
					  <input type="text" style="font-size:12px;text-align: right;color: #999999;width:40%" class="kaiqiiput" data-field="time" name='opening_hour' value='{$shop_msg.opening_hour}'  readonly placeholder="开始时间段">-<input type="text" style="font-size:12px;text-align: right;color: #999999;width:40%" class="kaiqiiput" data-field="time" name='closing_hour' value='{$shop_msg.closing_hour}'  readonly placeholder="结束时间段">
		              </label>
					<div id="dtBox"></div>
				</div>
				 
				 <div class="sublebtn">
						<input type="submit" value="保存" />
				</div>
			</form>
		</div>
	</body>
   <script>
   $(document).ready(function() {
			$("#dtBox").DateTimePicker({
				dateFormat: "dd-MMM-yyyy"
			});
		});
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
		 	// 开始时间
		 	var opening_hour = $("input[name='opening_hour']").val();
		 	// 结束时间
		 	var closing_hour = $("input[name='closing_hour']").val();
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
		 	if (merchant_seats<1) {
	 			alert('座位总数要大于0');
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
	 			alert('开始时间不能为空');
	 			return false;
		 	}
		 	if (closing_hour==''||closing_hour==null) {
	 			alert('结束时间不能为空');
	 			return false;
		 	}
		});
   	  })
   </script>
</html>