<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>删除菜品</title>
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
			<form class="mui-input-group" id='banquetmenu'  action='' method='post' >
			<div class="tianjaicaipinbox">
				<div class="caipinliebiaoage">
					<span class="spancaipin">菜品列表(共<label>38</label>项)</span>
					<a class="aagecaipin" ><img src="/img/shanchubtnimg.png" /></a>
				</div>
			<input name="banquet_id" value="{$banquet_id}" type="hidden" >
				 <!-- {if $list} -->
				<!-- {foreach from=$list item=item} -->
				<div class="caipinagebox">
					<div class="mui-input-row mui-checkbox mui-left"> 
						<input name="menu_id[]" value="{$item.menu_id}" type="checkbox" style="top: 10px;z-index: 999;">
						<span class="cai_namge">{$item.menu_name}</span>
						<p class="cai_moeryjiage">￥<span>{$item.menu_price}</span></p>
					</div> 
				</div>

			 	<!-- {/foreach} -->
			 	<!--{/if} -->
			</div>

		</div>

			</form>
	</body>
<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		$(".aagecaipin").click(function() {
			if(!$('[name="menu_id[]"]').is(':checked')) {
				alert('请先选择至少一项');
				return false;
			}
			$('#banquetmenu').submit();
		});

	});
</script>
</html>