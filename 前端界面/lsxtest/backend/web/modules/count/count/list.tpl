<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>平台数据统计</title> 
		<link rel="stylesheet" href="/css/index.css" />
		<link rel="stylesheet" href="/css/jcDate.css" />
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		
	</head>

	<body>
		<div class="combox">
			<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><label>平台数据统计</label>
			</div>
			<!--提示-->
			<div class="tishibox">
				<span>您好,<label class="corlr_ziti">{$cook.admin_name}</label>,欢迎使用<label class="corlr_ziti">流水席运维后台</label>　　您上次登录的时间：<label>{date("Y-m-d H:i:s", $cook.last_time)}</label>,　　登录IP:<label>{$cook.ip}</label></span>
			</div>
			<!--平台数据统计-->
			<div class="page_tongji">
				<!--标题-->
				<div class="biaoti_tongji">平台数据统计</div>
				<!--图表-->
				<div class="tubiao_box">
					<div class="tuxingtongji">
						<div class="tuxingtongji_bg1">

							<p class="tuxinboxtongji">
								<span>
		       	   	    			<label class="tupianimg"><img src="/img/zongjiaoyie.png"/></label>
		       	   	    		    <label class="tongjiname">
		       	   	    		    	 <a class="tongjinames">平台总销售额</a>
		       	   	    		    	 <a class="tongjimoery">{$arr.sales_amount}</a>
		       	   	    		    </label> 
		       	   	    		</span>

							</p>
						</div>
						<div class="tuxingtongji_bg2">
							<p class="tuxinboxtongji">
								<span>
		       	   	    			<label class="tupianimg"><img src="/img/2_2.png"/></label>
		       	   	    		    <label class="tongjiname">
		       	   	    		    	 <a class="tongjinames">佣金总收入(元)</a>
		       	   	    		    	 <a class="tongjimoery">{$arr.commission_amount}</a>
		       	   	    		    </label> 
		       	   	    		</span>

							</p>
						</div>

						<div class="tuxingtongji_bg3">
							<p class="tuxinboxtongji">
								<span>
		       	   	    			<label class="tupianimg"><img src="/img/icon_yonghu.png"/></label>
		       	   	    		    <label class="tongjiname">
		       	   	    		    	 <a class="tongjinames">用户总数</a>
		       	   	    		    	 <a class="tongjimoery">{$arr.user_amount}</a>
		       	   	    		    </label> 
		       	   	    		</span>

							</p>
						</div>

						<div style="margin-right: 0px;" class="tuxingtongji_bg5">
							<p class="tuxinboxtongji">
								<span>
		       	   	    			<label class="tupianimg"><img src="/img/icon_ruzhu.png"/></label>
		       	   	    		    <label class="tongjiname">
		       	   	    		    	 <a class="tongjinames">商家总数</a>
		       	   	    		    	 <a class="tongjimoery">{$arr.shop_amount}</a>
		       	   	    		    </label> 
		       	   	    		</span>

							</p>
						</div> 
						 
					</div>

				</div>
				<!--日期搜索-->
				<form  enctype="multipart/form-data" action="{yii\helpers\Url::to(['/count/count/count'])}" method="post">
				<div class="riqisousuo_box">
					<div class="biaoti_tongji">日期搜索</div>
					<div class="inputbox">
						<input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}"/>
						<input class="jcDate" name="begin_time" value="{$list.begin_time}" style="width:156px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
						<span>-</span>
						<input class="jcDate" name="end_time" value="{$list.end_time}" style="width:156px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
						<button class="sousuo_btn">搜　索</button>
					</div> 
				</div>
				</form>
				<!--搜索结果-->
				{if $list.is neq null}
				<div class="biaoti_tongji">搜索结果<span class="shijian"></span></div>
				<div class="shuju_page">
					<div class="page_age1">
						<span>
							<label class="name_yongjin">佣金（元）</label>
							<label class="name_morey">{$data.commission_amount}</label>
						</span>
						<span>
							<label class="name_yongjin">销售额</label>
							<label class="name_morey">{$data.sales_amount}</label>
						</span> 
					</div>
					<div class="page_age2">
						<span>
							<label class="name_yongjin">成交席单数</label>
							<label class="name_morey">{$data.order_amount}</label>
						</span>
						<span>
							<label class="name_yongjin">新增用户数</label>
							<label class="name_morey">{$data.user_amount}</label>
						</span> 
						<span>
							<label class="name_yongjin">新增商家数</label>
							<label class="name_morey">{$data.shop_amount}</label>
						</span> 
					</div>
				</div>
				{/if}
				
				
				
			</div>

		</div>
	</body>
	<script src="http://www.lanrenzhijia.com/ajaxjs/1.7.2/jquery-1.7.2.min.js"></script>
<script src="/js/jQuery-jcDate.js"></script>
<script>
$(function (){
	$(".jcDate").jcDate({					       
			IcoClass : "jcDateIco",
			Event : "click",
			Speed : 100,
			Left : 0,
			Top : 28,
			format : "-",
			Timeout : 100
	});
});
</script>
</html>