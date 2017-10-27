<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>拼席完成详情</title>
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
    <a href="/goods/goods/info?id={$userOrderInfo.banquet_id}&shop_id={$userOrderInfo.shop_id}" class="pxzhogn">
        <i class="ddimglogo"><img src="{if !empty($userOrderInfo.banquet_url)}{imageurl($userOrderInfo.banquet_url)}{else}/img/dindanxqimg.png{/if}"/></i>
        <div class="ddxname">
            <div class="dd_namepage">{$userOrderInfo.banquet_name}</div>
            <span class="pingxi_name_dianpu">{$userOrderInfo.shop_name}</span>
            <div class="dd_morey">￥<label>{$userOrderInfo.order_price}</label></div>
            <i class="dd_rigibtn"><img src="/img/right_icon.png"/></i>
        </div>
    </a>
    {if $userOrderInfo.order_status neq 2}
        <div class="liushuima">流水码<label>{$userOrderInfo.buy_number}</label></div>
    {/if}
    <div class="dindanxinxi">
        <div class="din_nammepage">订单信息</div>
        <div class="xidnxii">
            <div class="dainpage">席桌号 <label>{$userOrderInfo.banquet_number}</label></div>
            <div class="dainpage">订单号 <label>{$userOrderInfo.record_sn}</label></div>
            <div class="dainpage">付款时间 <label>{getTimeBytimestamp($userOrderInfo.pay_time)}</label></div>
            <div class="dainpage">数量 <label>{intval($userOrderInfo.buy_seats)}</label></div>
            <div class="dainpage">实付 <label>¥ {$userOrderInfo.pay_amount}</label></div>
            {if $userOrderInfo.order_status eq 0}
                <a href="/user/back/index?record_id={$userOrderInfo.record_id}" class="tuikuand"><img src="/img/tuikuanimg.png"/></a>
            {/if}
        </div>
    </div>
    <div class="dindanxinxi">
        <div class="din_nammepage">流水席信息</div>
        <div class="xidnxii">
            <div class="dainpage">席单号 <label>{$userOrderInfo.banquet_sn}</label></div>
            <div class="dainpage">席标题 <label>{$userOrderInfo.banquet_title}</label></div>
            <div class="dainpage">开席时间 <label>{getTimeBytimestamp($userOrderInfo.banquet_time)}</label></div>
            <div class="dainpage">是否公开 <label class="gongkaiguan">{if $userOrderInfo.is_display eq 0}私密{elseif $userOrderInfo.is_display eq 1}公开{/if}</label>
                {if $userOrderInfo.bo_status neq 3}
                    {if $is_show_display eq 1}
                        <!-- 蓝色开关打开状态 -->
                        <span class="mui-switch mui-switch-blue mui-active" id="mySwitch">
					        <label class="mui-switch-handle" id="yuanquan"></label>
				        </span>
                    {/if}
                {/if}
            </div>

        </div>

    </div>
    <!--共同用户-->
    <div class="dindanxinxi">
        <div class="din_nammepage">同席用户</div>
        <div class="gongtongyonghu">
            {foreach from=$UserAggregate item=user}
                {if $user.buy_seats >1}
                    {section name=number loop=$user.buy_seats}
                        <a href="javascript:void(0);"><i><img src="{if empty($user.image_path)}/img/xiyonghutouxiangimg.png{else}{$user.image_path}{/if}"/></i><label>{$user.user_name}</label></a>
                    {/section}
                {else}
                    <a href="javascript:void(0);"><i><img src="{if empty($user.image_path)}/img/xiyonghutouxiangimg.png{else}{$user.image_path}{/if}"/></i><label>{$user.user_name}</label></a>
                {/if}
            {/foreach}
        </div>
        <!--剩余多少座位-->
        {if $userOrderInfo.bo_status eq 1 && $userOrderInfo.order_status neq 2}
            <div class="jiucanxq">恭喜您拼席成功！请准时到餐厅就餐!</div>
        {elseif $userOrderInfo.bo_status eq 0}
            <div class="shenyuzuowei">本席剩余座位：<span>{$userOrderInfo.total_peoples-$userOrderInfo.joined_peoples}</span></div>
            <!--购买剩余席位-->
            {if $userOrderInfo.total_peoples-$userOrderInfo.joined_peoples > 0 && $userOrderInfo.joined_peoples > 0}
                <div class="goumaixiwei"><a href="/checkout/checkout/join?order_id={$userOrderInfo.order_id}&banquet_id={$userOrderInfo.banquet_id}{if $userOrderInfo.is_display == 0}&sign={$sign}{/if}">购买剩余席位</a></div>
            {/if}
            <div class="yaoqinhaoyou"><a href="javascript:void(0);" onClick="bdshare_popup()">邀请好友入席 获饭票奖励</a></div>
        {/if}
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
</body>
<script>
    $(function () {
        if ({$userOrderInfo.is_display} == 0) {
            $("#mySwitch").removeClass('mui-active');
            $("#mySwitch").children('.yuanquan').attr('style','transition-duration: 0.2s; transform: translate(0px, 0px);');
        }else if ({$userOrderInfo.is_display} == 1){
            $("#mySwitch").addClass('mui-active');
            $("#mySwitch").children('.yuanquan').attr('style','transition-duration: 0.2s; transform: translate(30px, 0px);');
        }
    })
    document.getElementById("mySwitch").addEventListener("toggle",function(event){
        if(event.detail.isActive){
            var data ={
                order_id : {$userOrderInfo.order_id},
                is_display : 1
            };
            $.get('/order/order/set-isdisplay',data,function (result) {
                if (result.code == 0) {
                    mui.toast(result.message,{ duration:'short', type:'div' });return false;
                }else if (result.code == 1) {
                    mui.toast(result.message,{ duration:'short', type:'div' });
                    $(".gongkaiguan").text("公开");
                }
            },'json');
        }else{
            var data ={
                order_id : {$userOrderInfo.order_id},
                is_display : 0
            };
            $.get('/order/order/set-isdisplay',data,function (result) {
                if (result.code == 0) {
                    mui.toast(result.message,{ duration:'short', type:'div' });return false;
                }else if (result.code == 1) {
                    mui.toast(result.message,{ duration:'short', type:'div' });
                    $(".gongkaiguan").text("私密");
                }
            },'json');
        }
    })
</script>
<script type="text/javascript">
    $(function () {
        var aObj=$('.footbox').find('a');
        aObj.eq(0).attr('class','a1');
        aObj.eq(1).attr('class','a2 a2_2');
        aObj.eq(2).attr('class','a3');
    })
</script>
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
                'getLocation',
            ]
        });
        window.share_config = {
            "share": {
                "imgUrl": "{imageurl($userOrderInfo.banquet_url)}",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
                "desc": "{$userOrderInfo.banquet_title}",//摘要,如果分享到朋友圈的话，不显示摘要。
                "title": '{$userOrderInfo.banquet_name}',//分享卡片标题
                "link": '{$share}',//分享出去后的链接，这里可以将链接设置为另一个页面。
                "success": function () {
                    //分享成功后的回调函数
                    var data = {
                        record_id : {$userOrderInfo.record_id}
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
        }
        wx.ready(function () {
            wx.onMenuShareAppMessage(share_config.share);//分享给好友
            wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
            wx.onMenuShareQQ(share_config.share);//分享给手机QQ
            wx.onMenuShareWeibo(share_config.share);//分享微博
            wx.onMenuShareQZone(share_config.share);//分享qq空间
        });
</script>
</html>