<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>账户明细</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<script type="text/javascript" src="/js/load_order_detail.js"></script>

		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<input type="hidden" class='down_msg' value='1'>
		<div class="box">
			
			 
		</div>
	</body>
<script type="text/javascript" charset="utf-8">
$().ready(function() {
		if ($(".box>div").html()==''||$(".box>div").html()==null) {
				load_msg_detail();
			};
	});
$(window).scroll(function(){
	if ($('.down_msg').val()==1) {
		var scrollTop = $(this).scrollTop();
	　　var scrollHeight = $(document).height();
	　　var windowHeight = $(this).height();
	　　if(scrollTop + windowHeight == scrollHeight){
			load_msg_detail();
	　　}	
	};
　　
});

	
	</script>
</html>