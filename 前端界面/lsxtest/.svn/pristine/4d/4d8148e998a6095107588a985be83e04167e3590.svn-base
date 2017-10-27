<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>绑定银行卡</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<script type="text/javascript" src="/js/delete_bond.js"></script>
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<div class="box">
			<!-- {if $bank_list} -->
			<!-- {foreach from=$bank_list item=item} -->
				<div class="bd_yhka">
			    	<p><label class="bd_nameage">{$item.withdraw_bank}</label><i><img onclick='delete_bond(this,{$item.bank_id})' src="/img/guanbiiconimg.png"/></i></p>
			    	<p><label class="bd_nameageoutput">{$item.withdraw_name}</label></p>
			    	<p class="bd_kahoao">{$item.bank_account}</p>
			    </div>
			<!-- {/foreach} -->
			<!-- {/if} -->
		    
		    <!--添加银行卡-->
		    <div class="addyhkaboz"><i><img src="/img/yinhangimgcion.png"/></i><a href="addbond">添加银行卡</a></div>
		</div>
	</body>
</html>