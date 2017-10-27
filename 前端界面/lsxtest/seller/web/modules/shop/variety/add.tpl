<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>菜品管理</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<script type="text/javascript" src="/js/regular.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<div class="box"> 
			<form  id='add_menu'  action='' method='post' >
			  <div class="tianjaicaipin">
			  	<div class="menuBox">
			  		<div class="tianjiapage">
			  	    	<input type="text" style='width:50%'  onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\@\.]/g,'')"   maxlength='32'  class="tianname" name='dish_name[]' value='' placeholder="请输入菜品名称" />
			  	    	<div style='float: left;'>￥</div><input maxlength='7' type="text" class="tianjaige" name='dish_price[]' onkeyup='clearNoNum(this)'  value="" /> 
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
   <script>
   	  $(function(){
   	  	 $(".jia").click(function(){
   	  	 	$(".menuBox").append("<div class='tianjiapage'><input style='width:50%'  maxlength='10'   name='dish_name[]'  type='text' class='tianname'  onkeyup='value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\@\.]/g,'')''  placeholder='请输入菜品名称' /><div style='float: left;'>￥</div><input type='text' name='dish_price[]'  maxlength='7'  onkeyup='clearNoNum(this)'  class='tianjaige' value='' /><i class='guabi'><img src='/img/jianbtn.png'/></i></div>");
   	  	 });
   	  	 $('.menuBox').on('click','.guabi',function(){
   	   		$(this).parents('.tianjiapage').eq(0).remove();   	  	 	
   	  	 })
   	  	 $("#add_menu").submit(function() {
   	  	 	var tianname=document.getElementsByClassName("tianname");
			for(var i=0;i<tianname.length;i++){
   	  	 		if ($(tianname[i]).val()=='') {
   	  	 			alert('菜名不能为空');
   	  	 			return false;
   	  	 		};
			}
			var tianjaige=document.getElementsByClassName("tianjaige");
			for(var i=0;i<tianjaige.length;i++){
   	  	 		if ($(tianjaige[i]).val()=='') {
   	  	 			alert('价格不能为空');
   	  	 			return false;
   	  	 		};
   	  	 		if (parseFloat($(tianjaige[i]).val()>10000)) {
   	  	 			alert('菜品价格不能大于10000');
   	  	 			return false;
   	  	 		};
			}
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
   	
   </script>
</html>