<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>流水席管理类别</title>
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

			<form  id='update_type'  action='' method='post' >
			<input  value='{$banquet_id}' type="hidden" name="banquet_id">
			<div class="lebibox">
		        <div class="leibiegaun">选择类别</div>
		        <!-- {if $type_list} -->
				<!-- {foreach from=$type_list item=item} -->
		        <div class="leibbtn">{$item.type_name}<input  {if $item.type_id==$type_msg} checked='checked'  {/if}  value='{$item.type_id}' type="radio" name="type"></div>
			 	<!-- {/foreach} -->
			 	<!--{/if} -->
		    </div>
		     <div class="tinleib"> <input style='font-size:32px;' type="submit"  class="queren" value="确认"></div>
			</form>
		</div>
	</body>
	<script>

   	  $(function(){
   	  	$("#update_type").submit(function() {
			var type = $("input[name='type']:checked").val(); 
			if(type==''){
				alert('请先选择类别');
				return false;
			}
			// return false;
		});
   	  })

	</script>

</html>