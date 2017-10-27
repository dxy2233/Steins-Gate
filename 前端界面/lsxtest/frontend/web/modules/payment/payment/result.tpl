<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>支付成功</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/style.js"></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js"></script>

    <link href="/css/mui.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/index.css" />
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
</head>

<style type="text/css">
    /*分享遮罩层*/
    .bdshare-popup-box {
        background-color: #000;
        opacity: 0.9;
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 10000;
        display: none;
    }

    .bdshare-popup-box .bdshare-popup-top img {
        position: fixed;
        top: 0;
        right: 5%;
        z-index: 224;
    }

    .bdshare-popup-box .bdshare-popup-bottom img {
        position: fixed;
        top: 192px;
        left: 50%;
        margin-left: -150px;
        z-index: 224;
    }

    /*分享后打开页面*/
    .share-open {
        width: 100%;
        height: 100%;
        position: relative;
        background: url(../images/share_open_bg.png) no-repeat;
        background-size: cover;
    }

    a.share-open-btn {
        position: absolute;
        bottom: 1.5rem;
        left: 50%;
        margin-left: -100px;
        display: block;
        height: 40px;
        line-height: 40px;
        text-align: center;
        width: 200px;
        background: #EAEA24;
        color: #652E23;
        border-radius: 3px;
        font-size: 16px;
    }
</style>

<body>
<div class="box">
    <div class="zhifidoimgbo"><img src="/img/zhifucglogo.png"/></div>
    <div class="zhifucg">
        <div class="zhifucg_titile">席单号：<label>{$banquet_order.banquet_sn}</label></div>
        <div class="zhifucg_titile">订单号：<label>{$user_order.record_sn}</label></div>
        <div class="zhifucg_titile">商家名：<label>{$shop_info.shop_name}</label></div>
        <div class="zhifucg_titile">流水席：<label>{$shop_banquet.banquet_name}</label></div>
        <div class="zhifucg_titile">开席时间：<label>{$banquet_order.banquet_time}</label></div>
        <div class="zhifucg_titile">价格：<label>¥ {$banquet_order.order_price}</label></div>
        <div class="zhifucg_titile">数量：<label>{$user_order.buy_seats}</label></div>
        <div class="zhifucg_titile">流水码：<label class="liushuimatiti">{$user_order.buy_number}</label></div>
        <div class="liushuimaage"></div>
        <div class="tiaozhuandliushn"><a href="/order/order/order-list">跳转到订单页面</a></div>
    </div>
    <div class="zhifu_shenyuer">
        <div class="zhifu_shenyuer_shuliagn">本席剩余座位：<span>{$banquet_order.total_peoples-$banquet_order.joined_peoples}</span></div>
        <div class="yaoqi_box"><a href="javascript:void(0);" onClick="bdshare_popup()">邀请好友入席 获饭票奖励</a></div>

    </div>

    <!--分享弹出层-->
    <div class="bdshare-popup-box" onclick="colse_bdshare_popup()">
        <div class="bdshare-popup-top">
            <img src="/img/share_popup_top.png">
        </div>
        <div class="bdshare-popup-bottom">
            <img src="/img/share_popup_bottom.png">
        </div>
    </div>
</div>
<script type="text/javascript">
    function bdshare_popup() {
        $(".bdshare-popup-box").show();
        $(".bdshare-popup-box").height($(document).height());
        scrollheight = $(document).scrollTop();
        $("body").css("top", "-" + scrollheight + "px");
        $("body").addClass("visibly");
    }
    function colse_bdshare_popup() {
        $(".bdshare-popup-box").hide();
        $("body").css("top", "auto");
        $("body").removeClass("visibly");
        $(window).scrollTop(scrollheight);
    }
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '{$signPackage.appId}',
        timestamp: {$signPackage.timestamp},
        nonceStr: '{$signPackage.nonceStr}',
        signature: '{$signPackage.signature}',
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone',
        ]
    });
    window.share_config = {
        "share": {
            "imgUrl": "{imageurl($shop_banquet.banquet_url)}",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
            "desc" : "{$banquet_order.banquet_title}",//摘要,如果分享到朋友圈的话，不显示摘要。
            "title" : '{$shop_banquet.banquet_name}',//分享卡片标题
            "link": '{$share}',//分享出去后的链接，这里可以将链接设置为另一个页面。
            "success":function(){
                //分享成功后的回调函数
                var data = {
                    record_id : {$user_order.record_id}
                };
                $.getJSON('/order/order/set-is-share',data,function (result) {
                    mui.toast('分享成功',{ duration:'short', type:'div' });return false;
                });
            },
            'cancel': function () {
                // 用户取消分享后执行的回调函数
//                alert('取消');
            }
        }
    };
    wx.ready(function () {
        wx.onMenuShareAppMessage(share_config.share);//分享给好友
        wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
        wx.onMenuShareQQ(share_config.share);//分享给手机QQ
        wx.onMenuShareWeibo(share_config.share);//分享微博
        wx.onMenuShareQZone(share_config.share);//分享qq空间
    });
</script>
</body>
</html>