<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link rel="stylesheet" href="/css/base.css" />
		<link rel="stylesheet" href="/css/index.css" />
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
		<script type="text/javascript" src="/js/base.js" ></script>
	</head>
	<body>
		<div class="box">
			<!--左边内容部分-->
			<div class="leftconbox">
				<div class="logo"><img src="/img/logo.png"/></div>
				<!--功能导航部分-->
				<div class="leftbox">
                                    {*{foreach from=$data item=$val}*}
					{*<a href="#" {if $val.menu_id == 1}class="active_bg" {/if}>{$val.menu_name}</a>*}
                                    {*{/foreach}    *}
					<a href="#" class="active_bg">平台数据统计</a>
					<a href="#">商家管理</a>
					<a href="#">用户管理</a>
					<a href="#">席单管理</a>
					<a href="#">流水席管理</a>
					<a href="#">流水席类别设置</a>
					<a href="#">营销管理</a>
					<a href="#">财务管理</a>
					<a href="#">管理员管理</a>
					<a href="#">轮播图管理</a>
					<a href="#">专题设置</a>
				</div>
				
			</div>
			<!--右边内容部分-->
			<div class="rightconbox">
				<div class="right_nav">
					<span class="liushuixi_imgname"><img src="/img/liushuixiname.png"/></span>
					<div class="nav_name">
						<span class="name"><i><img src="/img/name_img.png"/></i>你好{$list.user_name}</span>
						<span class="name_bz">修改资料</span>
						<a href="{yii\helpers\Url::to(['/index/index/loginout'])}" class="name_tuichu"><i><img src="/img/tuichu.png"/></i>退出</a>
					</div>
				</div>
				<!--右边存放iframe部分-->
				<div class="right_iframe" style="overflow: auto;" >
					<iframe name="Info1"class="iframe"  src="{yii\helpers\Url::to(['/count/count/count'])}" height="100%" width="100%" >1</iframe>
				</div>
			</div>
			
		</div>
		<!--底部-->
			<div class="footbox">
				 2014-2017 重庆市贞观科技有限公司 版权所有    渝公网安备 50010902000225号   渝ICP备15006536号-3
			</div>
	</body>
</html>
