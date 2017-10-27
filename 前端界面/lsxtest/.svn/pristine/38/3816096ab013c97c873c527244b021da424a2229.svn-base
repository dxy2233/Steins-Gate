<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>流水席详情</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/style.js"></script><script type="text/javascript" src="/js/layer_mobile/layer.js" ></script>

    <link rel="stylesheet" href="/js/layer_mobile/need/layer.css" />
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
            'openLocation',
        ]
    });
</script>
<div class="box">
    <div class="imglogo"><img src="{imageurl($lsx_info.banquet_url)}"/></div>
    <div class="xiangqingbox">
        <h3 class="xq_name">{$lsx_info.banquet_name} </h3>
        <div class="xq_morey">
            <span class="xq_morey_page1">￥<label>{$lsx_info.price}</label></span>
            <s class="meshijai">门市价：￥<label>{$lsx_info.banquet_amount}</label></s>
        </div>
        <div class="xq_laodian">
            {$lsx_info.address}
        </div>
        <div class="xq_zhuangtai">
            <button class="xq_zt">拼席中</button>
            <span class="shengyu">每日限桌：<label>{$lsx_info.banquet_number}</label>桌</span>
            <span class="shengyu">今日剩余：<label>{$lsx_info.left_number}</label>桌</span>
        </div>
        <!--评价-->
        <a href="/goods/goods/comment?banquet_id={$lsx_info.banquet_id}" class="pingjai">
            <div class="fenzhi">{$lsx_info.service_score}</div>
            <div class="xiaoxinxin">
                {if $lsx_info.score eq 1}
                    <i><img src="/img/manfen.png"/></i>
                {else if $lsx_info.score eq 2}
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                {else if $lsx_info.score eq 3}
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                {else if $lsx_info.score eq 4}
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                {else if $lsx_info.score eq 5}
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                    <i><img src="/img/manfen.png"/></i>
                {else}
                {/if}
                {if $lsx_info.banfen gt 0.4}
                    <i><img src="/img/banfen.png"/></i>
                {/if}
            </div>
            <div class="fenshu_box"><label>{$lsx_info.score_peoples}</label>评价</div>
        </a>


    </div>
    <!--人数-->
    <!--已拼满-->
    {foreach from=$order_info item=order}
    <div class="xq_renshu">
        <div class="xq_age1">
            <span class="dinshi">{$order.eat_today}{$order.eat_time}<label> 开席</label></span>
            <span class="xq_ren_name">{$order.banquet_title} </span>
            {if $order.is_display eq 0}<span class="mui-icon mui-icon-locked" style="margin-left: 3%;font-weight: 500"></span>{/if}
            <span class="renhsugershu">
			 	 		<i class="renshuicon"><img src="/img/renshuimg_03.png"/></i>
			 	 		<span><label>{$order.joined_peoples}</label>/<label>{$order.total_peoples}</label> </span>
			 	 	</span>
        </div>
        <div class="renshutoux">
			 	 	<span class="iconrsu">
                        {foreach from=$order.user_info item=user_info key=key}
                            {if $key lte 4}
			 	 		<i class="renshutou"><img src="{$user_info.image_path}"/></i>
                            {/if}
                        {/foreach}
			 	 	</span>
            <span class="xsyc"><i class="chkangend"><img src="/img/chakanquanbuicon.png"/></i></span>
        </div>
        <div class="gengduotoux">
			 	 	<span class="iconrsu">
                         {foreach from=$order.user_info item=user_info key=key}
                            {if $key gt 4}
			 	 		<i class="renshutou"><img src="{$user_info.image_path}"/></i>
                            {/if}
                         {/foreach}
			 	 	</span>
        </div>
        <div class="xq_lijiruxi">
            <span class="zuohoa">桌号：<label>{$order.banquet_number}</label></span>
            {if $order.joined_peoples eq $order.total_peoples}
            <a href="javascript:void(0);" class="lijiruxixq"><img src="/img/yipinman.png"/></a>
            {/if}
            {if $order.joined_peoples neq $order.total_peoples}
                {if $order.is_display eq 1}
                    <a href="/checkout/checkout/join?order_id={$order.order_id}&banquet_id={$order.banquet_id}" class="lijiruxixq"><img src="/img/lijiruxi.png"/></a>
                {/if}
            {/if}

        </div>
    </div>
    {/foreach}

    <!--还剩多少么开-->
    {*{if $lsx_info.left_number gt 0}*}
    {*<div class="shenyuexishu">*}
        {*<div class="shenyu_xishu"><span>还剩<label>{$lsx_info.left_number}</label>席未开</span></div>*}
        {*<a href="/checkout/checkout/kaixi?banquet_id={$lsx_info.banquet_id}" class="maikaixi">我要开席</a>*}
    {*</div>*}
    {*{/if}*}
    <!--地址-->
    <div class="dizhiweizhi">
        <div class="dizhi_name">{$lsx_info.shop_name}</div>
        <div class="dizhi_weizhi openLocation"><i><img src="/img/dizhiicon.png"/></i>{$lsx_info.address}</div>
        <script type="text/javascript">
            $(function () {
                $('.openLocation').click(function () {
                    wx.ready(function () {
                        wx.openLocation({
                            latitude: {$lsx_info.shop_lat}, // 纬度，浮点数，范围为90 ~ -90
                            longitude: {$lsx_info.shop_lng}, // 经度，浮点数，范围为180 ~ -180。
                            name: "{$lsx_info.shop_name}", // 位置名
                            address: "{$lsx_info.address}", // 地址详情说明
//                    scale: 15, // 地图缩放级别,整形值,范围从1~28。默认为最大
                            infoUrl: '', // 在查看位置界面底部显示的超链接,可点击跳转
                        });
                    });
                });
            });
        </script>
        <div class="juli_dianha">
            <span>{$lsx_info.distance}m</span>
            <a href="tel:{$lsx_info.merchant_telphone}"><img src="/img/dianhuaimgicon.png"/></a>
        </div>
    </div>
    <!--流水席菜品-->
    <div class="liushuixicaipin">
        <div class="liucaipinname">流水席菜品</div>
        <div class="cai_dnahi">
            {foreach from=$banquet_menu item=menu}
            <div class="cai_navpagne1">
                <span class="cai_age1">{$menu.menu_name}</span>
                <span class="cai_age2">x{$menu.menu_quantity}</span>
                <span class="cai_age3">￥{$menu.menu_quantity*$menu.menu_price}</span>
            </div>
            {/foreach}
        </div>
    </div>
    <!--购买须知-->
    <div class="goumaixuzhi">
        <div class="xuzhiname">购买须知</div>
        <div class="shiyongshidata">使用时间</div>
        <div class="jizaizhe">仅在该席指定开席时间使用。</div>
        <div class="shiyongshidata">使用规则</div>
        <div class="guizhie">
            <ul>
                <li>入席或开席成功后，将获得一个流水码</li>
                <li>无需预约，在开席时间前到达餐厅，将流水码交给商家验证后，即可入席</li>
                <li>菜品座位均由商家提前安排，若要加菜则价格另算。</li>
                <li>指定时间准时开席，若迟到晚入席，结果自己承担。</li>
                <li>不提供打包服务。</li>
            </ul>
        </div>
        <div class="jizaizhe">祝您用餐愉快！</div>
    </div>
    <!--分享与开席-->
    <div class="fenxkaixi">
        <a href="javascript:void(0);" onClick="bdshare_popup()" class="fenx"><i><img src="/img/fenxiangicon.png"/></i>分享</a>
        {*<a href="/checkout/checkout/kaixi?banquet_id={$lsx_info.banquet_id}" class="kaixi">我要开席</a>*}
        <a href="javascript:void(0);" class="kaixi">我要开席</a>
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
    $(function(){
        $(".chkangend").click(function(){
            var Obj=$(this).parents('.xq_renshu').children(".gengduotoux");
            if(Obj.css('display')== 'none'){
                $(this).children().attr("src","/img/shouqiicon.png");
                $(this).parent().parent().siblings(".gengduotoux").slideDown();
            }else if(Obj.css('display')== 'block'){
                $(this).children().attr("src","/img/chakanquanbuicon.png");
                $(this).parent().parent().siblings(".gengduotoux").slideUp();
            }
        });

        $('.kaixi').click(function(){
            var data = {};
            data.banquet_id = {$lsx_info.banquet_id};
            data.shop_id = {$lsx_info.shop_id};
//            console.log(data);return false;
            $.post('/checkout/checkout/check',data,function(result){
//                console.log(result);return false;
                if(result.code == 101)
                    {
                        layer.open({
                            content: '该流水席已关闭！'
                            ,btn: '我知道了'
                        });
                        return false;
                    }
                else if(result.code == 102)
                     {
                         layer.open({
                             content: '只能开明天的了？'
                             ,btn: ['好的,我是猪','只想今天吃咋办']
                             ,yes: function(index){
//                        location.reload();
                                 window.location.href = '/checkout/checkout/kaixi?banquet_id={$lsx_info.banquet_id}&is_today=1';
                                 layer.close(index);
                             }
                         });
                         return false;
                     }
                else if(result.code == 103)
                        {
                            layer.open({
                                content: '流水席已开满，请选择一桌入席！'
                                ,btn: '我知道了'
                            });
                            return false;
                        }
                else if(result.code == 104)
                {
                    layer.open({
                        content: '明天的席已开满，只能开今天的咯？'
                        ,btn: ['要得嘛，现在就吃','算求老']
                        ,yes: function(index){
//                        location.reload();
                            window.location.href = '/checkout/checkout/kaixi?banquet_id={$lsx_info.banquet_id}&is_today=2';
                            layer.close(index);
                        }
                    });
                    return false;
                }
                else{
                    window.location.href = '/checkout/checkout/kaixi?banquet_id={$lsx_info.banquet_id}';
                }
            },'json');
        })
    });

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
<script>
    window.share_config = {
        "share": {
            "imgUrl": "{imageurl($lsx_info.banquet_url)}",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
            "desc" : "{$lsx_info.banquet_title}",//摘要,如果分享到朋友圈的话，不显示摘要。
            "title" : '{$lsx_info.banquet_name}',//分享卡片标题
            "link": "{$signPackage.url}",//分享出去后的链接，这里可以将链接设置为另一个页面。
            "success":function(){
                //分享成功后的回调函数
                alert('分享成功');
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
</html>