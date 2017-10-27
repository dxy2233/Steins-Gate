<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>添加银行卡</title>
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

	<body style="width: 100%;height: 100%;background: white;">
		<div class="box">
			<form  id='bond_card'  action='' method='post' >
			 <div class="tija_yhkaage"><span>姓名</span><label><input  maxlength='16' name='withdraw_name' type="text" placeholder="请输入姓名"></label></div>
			 <div class="tija_yhkaage"><span>卡号</span><label><input minlength='6' maxlength='20' name='bank_account'  type="text"  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="请输入卡号"></label></div>
			 <div class="tija_yhkaage"><span>开户行</span><label><input minlength='6' maxlength='20' name='withdraw_bank' type="text" placeholder="请输入开户行"></label></div>
			 <div class="tijia_btnqueren"><a id='sure_bond'>确认绑定</a></div>
			</form>
		</div>
	</body>
	<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		$("#sure_bond").click(function() {
			var withdraw_name = $("input[name='withdraw_name']").val();
			var bank_account = $("input[name='bank_account']").val();
			var withdraw_bank = $("input[name='withdraw_bank']").val();
			if (withdraw_name=='') {
				alert('请输入姓名');
				return false;
			};
			if (bank_account=='') {
				alert('请输入卡号');
				return false;
			};
			if(!CheckBankNo(bank_account)){
				return false;
			} 
			if (withdraw_bank=='') {
				alert('请输入开户行');
				return false;
			};
			$('#bond_card').submit();
		});

	});
	</script>
</html>