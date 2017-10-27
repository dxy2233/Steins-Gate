<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>选择银行卡</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
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
			    	<a href="/money/mywallet/apply?bank_id={$item.bank_id}" class="xuanzheyikhagka">
				    	<p><label class="bd_nameage">{$item.withdraw_bank}</label></p>
				    	<p><label class="bd_nameageoutput">{$item.withdraw_name}</label></p>
				    	<p class="bd_kahoaoynage">{$item.bank_account}</p>
			    	</a>
			    </div>
			<!-- {/foreach} -->
			<!-- {/if} -->
		</div>
	</body>
   
</html>