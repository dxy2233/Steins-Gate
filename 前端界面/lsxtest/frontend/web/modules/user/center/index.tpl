<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>用户中心</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
    <script type="text/javascript" src="/js/style.js" ></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js" ></script>

    <link href="/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/index.css" />
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
</head>
<body>
<div class="box">
    <!--内容区-->
    <div class="combox">
        <!--头像-->
        <div class="top_name">
            <div class="name_wod">
                <span class="wod_name">{$user_info.user_name}</span>
                <a href="user_info?id={$user_info.user_id}"><img src="/img/xiugai_btn.png"/></a>
            </div>
            <div class="touxiang"><img src="{$user_info.image_path}"/></div>
        </div>
        <!--我的饭票-->
        <a href="user/ticket/index" class="wode_fanpiao">
            <i class="nav_touxiang"><img src="/img/wodefanpiao_icon.png"/></i>
            <span class="icon_name">我的饭票</span>
            <label class="btn_morey">￥{$user_info.meal_balance}</label>
            <i class="right_btn"><img src="/img/right_icon.png"/></i>
        </a>
        <!--我的饭友-->
        <a href="user/friend/list" class="wode_fanyou">
            <i class="fanyou_icon"><img src="/img/wodefanyou_icon.png"/></i>
            <span class="wode_fanyouname">
		 	 	 	<label>我的饭友</label>
		 	 	    <i class="right_btn"><img src="/img/right_icon.png"/></i>
		 	 	 </span>
        </a>
        <!--设置-->
        <a href="user/center/setting" class="wode_fanyou" style="margin-top: 0rem;">
            <i class="fanyou_icon2"><img src="/img/shezhi_icon.png"/></i>
            <span class="wode_fanyouname">
		 	 	 	<label>设置</label>
		 	 	    <i class="right_btn"><img src="/img/right_icon.png"/></i>
		 	 	 </span>
        </a>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var aObj=$('.footbox').find('a');
        aObj.eq(0).attr('class','a1');
        aObj.eq(1).attr('class','a2');
        aObj.eq(2).attr('class','a3 a3_3');
    })
</script>
</body>
</html>