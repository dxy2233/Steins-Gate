<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>我的饭票</title>
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
        <!--饭票余额-->
        <div class="fanpiaoyue">
            <div class="fnapiaonam">饭票余额</div>
            <div class="fanpiao_morey">{$user_info.meal_balance}</div>
        </div>
        <!--饭票明细-->

        <div class="fanpiao_mingxi">
            <div class="fp_mingxi"><span class="fpnatiti">饭票明细</span></div>
            {if empty($ticket)}
                <!--没有明细时-->
                <div class="wudingdanimg" style="height: 4rem">没有符合条件的记录
                </div>
            {else}
                {foreach from=$ticket item=list}
                    <div class="fp_mingxi">
                        {if $list.ticket_status eq 0}
                            <span class="fanpiodikoiu">饭票抵扣</span>
                        {elseif $list.ticket_status eq 1}
                            <span class="fanpiodikoiu">感谢你邀请好友入席！</span>
                            <span class="fanpiodikoiu fanpiodikoiu2">恭喜你获得平台曾送的饭票奖励</span>
                        {elseif $list.ticket_status eq 2}
                            <span class="fanpiodikoiu">退款退还饭票</span>
                        {/if}
                        <span class="dikoujia {if $list.ticket_amount gt 0}dikoujia2{/if}">￥<label>{$list.ticket_amount}</label></span>
                        <span class="shijian">{$list.caeate_time}</span>
                    </div>

                    {*<div class="fp_mingxi">*}
                    {*<span class="fanpiodikoiu">感谢你邀请好友入席！</span>*}
                    {*<span class="fanpiodikoiu fanpiodikoiu2">恭喜你获得平台曾送的饭票奖励</span>*}
                    {*<span class="dikoujia dikoujia2">-￥<label>10.40</label></span>*}
                    {*<span class="shijian">8-25 18:21</span>*}
                    {*</div>*}
                {/foreach}
            {/if}


        </div>


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