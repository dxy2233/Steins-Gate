<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>菜品修改</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<div class="box"> 
			<form  id='update_menu'  action='' method='post' >
			  <div class="tianjaicaipin">
			  	<div class="menuBox">
			  		<div class="remcov">删除</div>
			  		<div class="tianjiapage">
			  	    	<input type="text" class="tianname"  style='width:50%'  maxlength='32'  name='dish_name' value='{$variety_one.dish_name}'  onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\@\.]/g,'')"  placeholder="请输入菜品名称" />
			  	    	<div style='float: left;'>￥</div><input type="text"  onkeyup='clearNoNum(this)'  class="tianjaige"  maxlength='7'   name='dish_price' value="{$variety_one.dish_price}" /> 
			  	    	<input type="hidden" name='dish_id' value="{$variety_one.dish_id}" /> 
			  	   </div> 
			  	</div>
			  	   
			  	<div class="sublebtn">
					<input type="submit" value="确认修改" />
			    </div>
			
			  </div>
			</form>
			  
		</div>
	</body>
   <script>

	var status_like=1;
	var status_submit=1;
         $(function(){
         	$(".remcov").click(function(){
         		if (status_like==0) {
				return false;
			};
			status_like=0;
         		if(window.confirm('是否删除？相关流水席的菜品也会一并删除，不影响已下单的流水席！')){
         			var menu_id = $("input[name='dish_id']").val();
         			if (menu_id) {
	         			$.ajax({
							cache: false,
							type: "POST",
							url: "/shop/variety/delete",
							data: $("#update_menu").serialize(),
							success: function(result) {
								if (result.status == 1) {
									alert(result.msg);
									window.location.href='/shop/variety/index';
								} else {
									alert(result.msg);
								}
					status_like=1;
							},
							error: function(result) {
								alert("异常", {
									icon: 2
								});
					status_like=1;
							}
						});
         			}
	            }
         	});
         	
	        $("#update_menu").submit(function() {
	        if (status_submit==0) {
				return false;
			};
			status_submit=0;
				if($('.tianname').val()==null){
					alert('菜名不能为空');
					return false;
				}
				if($('.tianjaige').val()<0){
					alert('菜品价格不能为空');
					return false;
				}
				if (parseFloat($('.tianjaige').val()>10000)) {
   	  	 			alert('菜品价格不能大于10000');
   	  	 			return false;
   	  	 		};
			});
         })
   </script>
</html>