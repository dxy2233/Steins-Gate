<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>设置</title>
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
        <a href="javascript:void(0);" class="yonghuname yonghuname3 mobile">
            <span class="icon_name">手机</span>
            <label class="btn_yonghu btn_yonghu3">{if empty($mobile)}未绑定{else}{$mobile}{/if}</label>
            <!--<i class="right_btn"><img src="img/right_icon.png"/></i>-->
        </a>
        {if empty($mobile)}
            <script type="text/javascript">
                $(function () {
                    $('.mobile').click(function () {
                        $.get('/user/center/check-mobile',function (result) {
                            if (result.code == 0) {
                                mui.toast(result.message,{ duration:'short', type:'div' });return false;
                            }else if(result.code == 1){
                                window.location.href = result.data;
                            }
                        },'json');
                    });
                });
            </script>
        {/if}
        <a href="#" class="yonghuname yonghuname3">
            <span class="icon_name">帮助中心</span>
            <i class="right_btn"><img src="/img/right_icon.png"/></i>
        </a>
        <a href="tel:400-8888-8888" class="yonghuname yonghuname3"style="margin-top: 0rem;">
            <span class="icon_name">客服电话</span>
            <label class="btn_yonghu btn_yonghu3 phoneOpne">400-8888-8888</label>
            <!--<i class="right_btn"><img src="img/right_icon.png"/></i>-->
        </a>
    </div>

</div>
</body>
</html>