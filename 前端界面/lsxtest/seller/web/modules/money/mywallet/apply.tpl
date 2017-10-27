<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>申请提现</title>
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
			<form  id='get_money'  action='' method='post' >
		    <div class="bd_yhka">
		    	<a href="selectcard" class="xuanzheyikhagka">
		    	<input name='bank_id' type="hidden" value='{$bank_list.bank_id}'></div>
		    	<p><label class="bd_nameage">{$bank_list.withdraw_name}</label></p>
		    	<p><label class="bd_nameageoutput">{$bank_list.withdraw_bank}</label></p>
		    	<p class="bd_kahoaoynage">{$bank_list.bank_account}</p>
		    	<i class="lefig"><img src="/img/leftimg.png"/></i>
		    	</a>
		    </div>
		    
		    <div class="bd_yhka">
		    	 <div class="tixinjineageout">提现金额</div>
		    	 <div class="shurutixinajineage"><input style='font-size:16px'  maxlength='10' onkeyup="clearNoNum(this)" name='request_amount' type="text" placeholder="请输入提现金额"></div>
		    	 <div class="ketixinajineage">可用提现余额<label>{$total_balnce}</label>元</div>
		    </div>
			 <div class="tijia_btnqueren"><a id='sure_submit'>确认提现</a></div>
		    <form>
		    
		  
		</div>
	</body>
   	<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		$("#sure_submit").click(function() {
			var request_amount = $("input[name='request_amount']").val();
			var bank_id = $("input[name='bank_id']").val();
			var total_balnce = {$total_balnce|default:0};
			if (request_amount=='') {
				alert('请填写提现金额');
				return false;
			};
			if (request_amount<=0) {
				alert('请填写有效的提现金额');
				return false;
			};
			if (total_balnce-request_amount<0) {
				alert('请填写有效的提现金额');
				return false;
			};
			if (bank_id=='') {
				alert('请选择有效的银行');
				return false;
			};
			if (confirm('确认申请提现吗？')==false) {
				return false;
			};
			$('#get_money').submit();
		});

	});
	</script>
</html>