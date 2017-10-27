<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
		
	</head>
	<body>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><a href="{yii\helpers\Url::to(['marketing/index'])}" class="label">营销管理</a>><label>饭票金额设置</label>
			</div>
		 	<div class="fanpiao_jine">
		 		<div class="yaoqing">邀请获饭票金额</div>
		 		<div class="guize">发放规则：用户入席后分享该席，该席在定席时刻若拼满，且用户依旧在此席中，则用户获得饭票奖励。</div>
		 		<div class="guize">使用规则：可在下次下单时当做现金抵扣。（无门槛）</div>
		 		<div class="guize">
		 			每张饭票金额：<span class="fanpiao_jineshu">{$reset.ticket_price}</span><label class="xiugaijinebox">修改金额</label>
		 		</div>
		 		<!--饭票修改历史-->
		 		<div class="fanpiao_xiugailishi">
		 		  <div class="lishi">饭票修改历史</div>
		 		  <table class="table_xiugai" cellpadding="0" cellspacing="0">
		 		  	   <tr class="xiugai_tr">
		 		  	   	   <td class="actif_xiug">饭票金额￥</td>
		 		  	   	   <td>操作者</td>
		 		  	   	   <td class="actif_xiug2">修改时间</td> 
		 		  	   </tr>
		 		  	   <tbody>
                                               {foreach from=$data item=$val}
		 		  	   	  <tr>
			 		  	   	   <td>{$val.ticket_price}</td>
			 		  	   	   <td>{$val.user_name}</td>
			 		  	   	   <td>{date('Y-m-d H:i:s',$val.caeate_time)}</td> 
		 		  	   	   </tr>
                                                {/foreach}   
		 		  	   </tbody> 
		 		  	   
		 		  </table>
			 		<div class="taobo_fenye">
			 			<!--分页-->
				 	    <div class="fenye">
							<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/marketing/marketing/fanpiaojine'])}" method="get">
							{if !empty(post)}
                                {foreach from=$post item=post_info key=post_info_key}
									<input type="hidden" name="post[{$post_info_key}]" value="{$post_info}"/>
                                {/foreach}
							{/if}
							<div class="fenye_conbox">
				 	    		<div class="fenye_titile">
				 	    			显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
				 	    			<a href="{\yii\helpers\Url::to(['/marketing/marketing/fanpiaojine','post'=>$post])}">首页</a>
									<a href="{\yii\helpers\Url::to(['/marketing/marketing/fanpiaojine','post'=>$post,'page'=>$page.page-1])}">上一页</a>
									<a href="{\yii\helpers\Url::to(['/marketing/marketing/fanpiaojine','post'=>$post,'page'=>$page.page+1])}">下一页</a>
									<a href="{\yii\helpers\Url::to(['/marketing/marketing/fanpiaojine','post'=>$post,'page'=>10000])}">尾页</a>
				 	    		    <input name="page" type="text" class="text" />
				 	    		    <input type="submit" value="跳 转" class="tiaozhuan" />
				 	    		</div>
				 	    	</div>
							</form>
				 	    </div>
			 		</div> 
		 		</div> 
		 	</div> 
		 </div>
		 <!--弹框-->
                 <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['marketing/fanpiaojine'])}" >
		 <div class="tankuang_xiugai">
		 	<div class="tiank_name">饭票金额修改</div>
		 	<div class="tiank_xiugai_jine">每张饭票金额:<input type="text" id='in_jine' class="in_jine" name="ticket_price" value='{$reset.ticket_price}'></div>
		 	<div class="lijishenx">饭票金额修改后将会立即生效</div>
		 	<div class="tankuagn_btn">
		 		<input type="submit" value="确认" class="tan_queren" />
		 		<input type="" value="取消" class="tan_quxiao" />
		 	</div> 
		 </div>
                 <input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}">
                </form> 
	</body>
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
	<script>
		$(function(){
			$(".xiugaijinebox").click(function(){
				$(".tankuang_xiugai").show(); 
			});
			$(".tan_quxiao").click(function(){
				$(".tankuang_xiugai").hide(); 
			});
			$(".tan_queren").click(function(){
                                var re = /^[0-9]+.?[0-9]*$/;
				var is=$(".in_jine").val(); 
                                if (!re.test(is)) {
                                        alert("请输入数字");
                                        return false;
                                }
				if(is==""){
					alert("您输入的金额不能为空");
					return false;  
				}else{
				  $(".tankuang_xiugai").hide();  
				}
				
			});
		})
		
	</script>
	
	
</html>
