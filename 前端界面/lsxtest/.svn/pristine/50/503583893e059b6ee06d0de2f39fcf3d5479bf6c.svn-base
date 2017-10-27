<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>评价</title>
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
<script type="text/javascript">
    (function($) {
        $.extend({
            myTime: {
                /**
                 * 当前时间戳
                 * @return <int>    unix时间戳(秒)
                 */
                CurTime: function(){
                    return Date.parse(new Date())/1000;
                },
                /**
                 * 日期 转换为 Unix时间戳
                 * @param <string> 2014-01-01 20:20:20 日期格式
                 * @return <int>    unix时间戳(秒)
                 */
                DateToUnix: function(string) {
                    var f = string.split(' ', 2);
                    var d = (f[0] ? f[0] : '').split('-', 3);
                    var t = (f[1] ? f[1] : '').split(':', 3);
                    return (new Date(
                        parseInt(d[0], 10) || null,
                        (parseInt(d[1], 10) || 1) - 1,
                        parseInt(d[2], 10) || null,
                        parseInt(t[0], 10) || null,
                        parseInt(t[1], 10) || null,
                        parseInt(t[2], 10) || null
                    )).getTime() / 1000;
                },
                /**
                 * 时间戳转换日期
                 * @param <int> unixTime  待时间戳(秒)
                 * @param <bool> isFull  返回完整时间(Y-m-d 或者 Y-m-d H:i:s)
                 * @param <int> timeZone  时区
                 */
                UnixToDate: function(unixTime, isFull, timeZone) {
                    if (typeof (timeZone) == 'number')
                    {
                        unixTime = parseInt(unixTime) + parseInt(timeZone) * 60 * 60;
                    }
                    var time = new Date(unixTime * 1000);
                    var ymdhis = "";
                    ymdhis += time.getUTCFullYear() + "-";
                    ymdhis += (time.getUTCMonth()+1) + "-";
                    ymdhis += time.getUTCDate();
                    if (isFull === true)
                    {
                        ymdhis += " " + time.getUTCHours() + ":";
                        ymdhis += time.getUTCMinutes() + ":";
                        ymdhis += time.getUTCSeconds();
                    }
                    return ymdhis;
                }
            }
        });
    })(jQuery);
</script>
<body>
<div class="box">
    {if empty($commentInfo)}
        <div class="navboxcom">
            <div class="wudingdanimg"><i style="width: 1.71rem;height: 2.35rem;"><img src="/img/pin.png"/></i></div>
        </div>
    {else}
        <div id="pullrefresh" class="mui-scroll-wrapper">
            <div class="table_list">
                <div class="mui-table-views">

                </div>
                {*{foreach from=$commentInfo item=e}*}
                    {*<div class="pingjaiboxtitle">*}
                        {*<div class="pingjaiboxtitle_nav">*}
                            {*<i class="pingjaiicon"><img src="{if empty($e.image_path)}/img/pingjaiicon.png{else}{$e.image_path}{/if}"/></i>*}
                            {*<div class="pingjai_name_fenzhi">*}
                                {*<div class="pingjai_name_fenzhi_titi">*}
                                    {*<span class="pingnamepagebox">{if empty($e.nickname)}{$e.user_name}{else}{$e.nickname}{/if}</span>*}
                                    {*<span class="pingnamepagebox_data">{getTime($e.message_time)}</span>*}
                                {*</div>*}
                                {*<div class="xinjidafen">*}
							{*<span class="xinjidafen_xinxin">*}
                                {*{section name=total loop=$e.service_score}*}
                                    {*<i><img src="/img/liangxin.png"/></i>*}
                                {*{/section}*}
		  	   	  	  	   {*</span>*}
                                    {*<span class="fenshizhibx"><label>{$e.service_score}</label>分</span>*}
                                {*</div>*}
                            {*</div>*}
                        {*</div>*}
                        {*<div class="pinglunnriong">*}
                            {*<span>{$e.message_detail}</span>*}
                            {*<div class="quanwentbtn">全文</div>*}
                        {*</div>*}
                    {*</div>*}
                {*{/foreach}*}
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                mui.init({
                    pullRefresh: {
                        container: '#pullrefresh',
                        down: {
                            callback: pulldownRefresh
                        },
                        up: {
                            contentrefresh: '正在加载...',
                            callback: pullupRefresh
                        }
                    }
                });
                /**
                 * 下拉刷新具体业务实现
                 */
                function pulldownRefresh() {
                    setTimeout(function() {
                        mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
                    }, 1500);
                }
                var count = 0;
                var Intotal ={$count};
                /**
                 * 上拉加载具体业务实现
                 */
                function pullupRefresh() {
                    setTimeout(function() {
                        mui('#pullrefresh').pullRefresh().endPullupToRefresh((++count > Intotal)); //参数为true代表没有更多数据了。
                        var table = document.body.querySelector('.mui-table-views');
                        var data ={
                            page : count-1,
                            banquet_id : {$banquet_id}
                        };
                        $.getJSON('/goods/goods/comment',data,function (result) {
                            if (result.code == 1) {
                                $.each(result.data ,function (i,v) {
                                    var div = document.createElement('div');
                                    div.className = 'pingjaiboxtitle mui-table-view-cell-append';
                                    var html='';
                                    html+='<div class="pingjaiboxtitle_nav">';
                                    if (v.image_path == '' || v.image_path ==null) {
                                        html+='<i class="pingjaiicon"><img src="/img/pingjaiicon.png"/></i>';
                                    }else{
                                        html+='<i class="pingjaiicon"><img src="'+v.image_path+'"/></i>';
                                    }
                                    html+='<div class="pingjai_name_fenzhi">';
                                    html+='<div class="pingjai_name_fenzhi_titi">';
                                    if (v.nickname == '' || v.nickname == null) {
                                        html+='<span class="pingnamepagebox">'+v.user_name+'</span>';
                                    }else{
                                        html+='<span class="pingnamepagebox">'+v.nickname+'</span>';
                                    }
                                    html+='<span class="pingnamepagebox_data">'+$.myTime.UnixToDate(v.message_time)+'</span>';
                                    html+='</div>';
                                    html+='<div class="xinjidafen">';
                                    html+='<span class="xinjidafen_xinxin">';
                                    for(var l=1;l<=v.service_score;l++){
                                        html+='<i><img src="/img/liangxin.png"/></i>';
                                    }
                                    html+='</span>';
                                    html+='<span class="fenshizhibx"><label>'+v.service_score+'</label>分</span>';
                                    html+='</div>';
                                    html+='</div>';
                                    html+='</div>';
                                    html+='<div class="pinglunnriong">';
                                    html+='<span>'+v.message_detail+'</span>';
                                    html+='<div class="quanwentbtn">全文</div>';
                                    html+='</div>';
                                    div.innerHTML = html;
                                    table.appendChild(div);
                                });
                            }else if (result.code == 0) {
                                mui.toast(result.message,{ duration:'short', type:'div' });return false;
                            }
                        });
                    }, 1500);
                }
                if (mui.os.plus) {
                    mui.plusReady(function() {
                        setTimeout(function() {
                            mui('#pullrefresh').pullRefresh().pullupLoading();
                        }, 1000);

                    });
                } else {
                    mui.ready(function() {
                        mui('#pullrefresh').pullRefresh().pullupLoading();
                    });
                }
            });
        </script>
    {/if}
</div>
<script type="text/javascript">
    $(function () {
        mui("#pullrefresh").on('tap','.quanwentbtn',function(){
            var Obj = $(this).siblings("span");
            if (Obj.css("-webkit-line-clamp") == '3') {
                Obj.css("-webkit-line-clamp", "inherit");
                $(this).html('收起');
            }else {
                Obj.css("-webkit-line-clamp", "3");
                $(this).html('全文');
            }
            //业务逻辑
        })
    });
</script>
</body>
</html>