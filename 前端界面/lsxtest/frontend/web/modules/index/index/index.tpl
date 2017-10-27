<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>流水席首页</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
    <script type="text/javascript" src="/js/layer_mobile/layer.js"></script>
    <script type="text/javascript" src="/js/style.js" ></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js" ></script>

    <link href="/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/index.css" />

    <link rel="stylesheet" type="text/css" href="/css/mui.picker.css" />
    <link rel="stylesheet" type="text/css" href="/css/mui.css" />
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
</head>
<body>
{if empty($smarty.session.location)}
    <script type="text/javascript" src="/js/layer_mobile/layer.js"></script>
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
                'getLocation',
            ]
        });
        wx.ready(function () {
            var loadingStart=layer.open({
                type: 2
                ,content: '地理位置获取中..'
                ,shadeClose: false
            });
            wx.getLocation({
                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res) {
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    var speed = res.speed; // 速度，以米/每秒计
                    var accuracy = res.accuracy; // 位置精度
                    var data = {
                        lng:longitude,
                        lat:latitude
                    }
                    $.get("site/set-location",data,function (result) {
                        if (result.code == 1) {
                            layer.open({
                                content: '获取地理位置成功!'
                                ,skin: 'msg'
                                ,time: 2 //2秒后自动关闭
                            });
                            layer.close(loadingStart);
                            window.location.reload();
                        }else if (result.code == -1){
                            layer.open({
                                content: '获取地理位置失败!'
                                ,skin: 'msg'
                                ,time: 2 //2秒后自动关闭
                            });
                            setTimeout(function () {
                                layer.close(loadingStart);
                            },3000);
                        }
                    },'json')
                },
                cancel: function (res) {
                    layer.open({
                        content: '用户拒绝授权获取地理位置!'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    setTimeout(function () {
                        layer.close(loadingStart);
                    },3000);
                }
            });
        });
    </script>
{/if}
<div class="box">
    <!--内容区-->
    <div class="combox">
        <!--轮播banner-->
        <div id="slider" class="mui-slider" >
            <!--地区筛选-->
            <div class="diqushaixuan">
                <p id="city_text2" class="r-tx-txt2 r-tx-txt2s fl">重庆市</p><i class="diquilaiixbtn"><img src="/img/diquicon.png"/></i>
            </div>
            <div class="mui-slider-group mui-slider-loop">
                <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
                <div class="mui-slider-item mui-slider-item-duplicate">
                    <a href="{$carousel[0]['carousel_url']}">
                        <img src="{imageurl($carousel[0]['carousel_path'])}">
                    </a>
                </div>
                {foreach from=$carousel item=banner}
                <!-- 第3张 -->
                <div class="mui-slider-item">
                    <a href="{$banner.carousel_url}">
                        <img src="{imageurl($banner.carousel_path)}">
                    </a>
                </div>
                {/foreach}
                <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
                <div class="mui-slider-item mui-slider-item-duplicate">
                    <a href="{$last.carousel_url}">
                        <img src="{imageurl($last.carousel_path)}">
                    </a>
                </div>
            </div>
            <div class="mui-slider-indicator">
                {foreach from=$carousel item=banner key=k}
                    {if $k eq 0}
                        <div class="mui-indicator mui-active"></div>
                    {else}
                        <div class="mui-indicator"></div>
                    {/if}
                {/foreach}
            </div>
        </div>
        <!--站位-->
        <div class="hight"></div>
        <!--标题图标栏-->
        <div id="slider" class="mui-slider" >
            <div class="mui-slider-group mui-slider-loop">
                <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
                <div class="mui-slider-item mui-slider-item-duplicate icon">
                    <!--小图标导航-->
                    {foreach from=$category item=cat}
                    <a href="{$cat.category_url}"><i><img src="{imageurl($cat.category_path)}"/></i> {$cat.category_name}</a>
                    {/foreach}
                </div>

            </div>
            <div class="mui-slider-indicator">
                <!--第二页的小圆点-->
                <div class="mui-indicator mui-active"></div>
                <!--<div class="mui-indicator"></div>-->
            </div>
        </div>
        <!--站位-->
        <div class="hight"></div>
        <!--热卖专题区-->
        <div class="remaibox">
            <div class="remai_name">
                <div class="name_nth1">热卖流水席</div>
                <div class="name_nth2">超值美味 饭票奖励拿不停</div>
            </div>
            <!--产品展示-->
            {foreach from=$hotlsx item=lsx}
                <a href="goods/goods/info?id={$lsx.banquet_id}&shop_id={$lsx.shop_id}" class="remai_chanpin">
                    <i class="remaichanpin_icon"><img src="{imageurl($lsx.banquet_url)}"/></i>
                    <div class="remai_nribox">
                        <p class="remai_name_box">{$lsx.banquet_name}</p>
                        <p class="remai_dian_name">{$lsx.shop_name}</p>
                        <p class="icon_xinxin">
		 					<span class="xinxin">
                                {if $lsx.score eq 1}
		 						<label><img src="/img/manfen.png"/></label>
                                {elseif $lsx.score eq 2}
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="/img/manfen.png"/></label>
                                {elseif $lsx.score eq 3}
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="img/manfen.png"/></label>
                                <label><img src="img/manfen.png"/></label>
                                {elseif $lsx.score eq 4}
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="/img/manfen.png"/></label>
                                {elseif $lsx.score eq 5}
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="/img/manfen.png"/></label>
                                <label><img src="/img/manfen.png"/></label>
                                {else}
                                {/if}
                                {if $lsx.banfen gt 4}
                                    <label><img src="/img/banfen.png"/></label>
                                {/if}
		 					</span>
                            <span class="fenshu"><label>{$lsx.service_score}</label> 分</span>
                        </p>
                        <p class="diqu">
                            <span class="diqu_weizhi"><label>{getregionnameBycode($lsx.region_code)}</label><label class="juli">{$lsx.tothere}m</label></span>
                            <span class="morey"><label>￥</label>{$lsx.price}</span>
                        </p>
                    </div>
                </a>
            {/foreach}




        </div>
    </div>

</div>
</body>
<script src="/js/mui.min.js"></script>
<script src="/js/mui.picker.min.js"></script>
<script src="/js/data.city.js"></script>
<script>
    //获得slider插件对象
    var gallery = mui('.mui-slider');
    gallery.slider({
        interval:5000//自动轮播周期，若为0则不自动播放，默认为0；
    });
    //选择省
    var city_picker2 = new mui.PopPicker({
        layer: 1
    });
    city_picker2.setData(init_city_picker);
    $("#city_text2").on("tap", function() {
        setTimeout(function() {
            city_picker2.show(function(items) {
                $("#city_id2").val((items[0] || {}).value);
                $("#city_text2").html((items[0] || {}).text);
            });
        }, 200);
    });
</script>
<script type="text/javascript">
    $(function () {
        var aObj=$('.footbox').find('a');
        aObj.eq(0).attr('class','a1 a1_1');
        aObj.eq(1).attr('class','a2');
        aObj.eq(2).attr('class','a3');
    })
</script>
</html>