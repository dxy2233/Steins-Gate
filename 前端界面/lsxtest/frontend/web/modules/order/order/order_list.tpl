<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>我的订单</title>
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
        <!--导航-->
        <div class="navbox">
            <a href="{homeurl('/order/order/order-list')}"><span {if $status eq ''}class="actiovanav"{/if}>全部</span></a>
            <a href="{homeurl('/order/order/order-list?status=seats')}"><span {if $status eq 'seats'}class="actiovanav"{/if}>拼席中</span></a>
            <a href="{homeurl('/order/order/order-list?status=success')}"><span {if $status eq 'success'}class="actiovanav"{/if}>拼成功</span></a>
            <a href="{homeurl('/order/order/order-list?status=completed')}"><span {if $status eq 'completed'}class="actiovanav"{/if}>已完成</span></a>
            <a href="{homeurl('/order/order/order-list?status=refunded')}"><span {if $status eq 'refunded'}class="actiovanav"{/if}>已退款</span></a>
        </div>
        <input type="hidden" id="page" value="{$page}">
        <input type="hidden" id="pagemore" value="1">
        <!--显示主要内容-->
        <div class="navboxcom">
            {if empty($list)}
                <div class="wudingdanimg"><i><img src="/img/wudingdan.png"/></i></div>
            {else}
                <!--占位-->
                <div class="hight"></div>
                <!--拼席中-->
                <div class="box_order">
                    {foreach from=$list item=order}
                        <div class="pingxizhogn">
                            <i><img src="{imageurl($order.banquet_url)}"/></i>
                            <div class="pingxinrong">
                                <div class="pingxi_name">
                                    <span class="pingxi_name_page">{$order.banquet_name}</span>
                                    {if $order.order_status eq 0}
                                        <span class="zhuagntai">拼席中</span>
                                    {else if $order.order_status eq 1}
                                        <span class="zhuagntai pinxichegngong">拼席成功</span>
                                    {else if $order.order_status eq 2}
                                        <span class="zhuagntai yituikuan">已退款</span>
                                    {else if $order.order_status eq 3}
                                        <span class="zhuagntai yiwanchegn">已完成</span>
                                    {/if}
                                </div>
                                <div class="pingxi_name pingxi_name_top">
                                    <span class="pingxi_name_dianpu">{$order.shop_name}</span>
                                    <span class="zhuagntai_morer">¥ {$order.buy_price}</span>
                                </div>
                                <div class="pingxi_name pingxi_name_top">
                                    <span class="pingxi_name_dianpu">开席时间:<label>{$order.banquet_time}</label></span>
                                    <span class="zhuagntai_morer_coro">x<label>{$order.buy_seats}</label></span>
                                </div>
                            </div>
                            <!---->
                            <div class="shifukan">
                                <span>实付款</span>
                                <span class="shifuk_morety"><label>￥</label>{$order.pay_amount}</span>
                                <a href="/order/order/order-info?rid={$order.record_id}&uid={$order.user_id}" class="chakank">查看</a>
                                {if $order.order_status eq 3}
                                    {if $order.is_comment eq 0}
                                        <a href="/order/order/order-comment?rid={$order.record_id}" class="pinjia">评价</a>
                                    {/if}
                                {/if}
                            </div>

                        </div>
                    {/foreach}

                    <!--已退款-->

                </div>
            {/if}

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var aObj=$('.footbox').find('a');
        aObj.eq(0).attr('class','a1');
        aObj.eq(1).attr('class','a2 a2_2');
        aObj.eq(2).attr('class','a3');
    })


    $(window).on('scroll', function() {
        if ($(document).scrollTop() + $(window).height() > $(document).height() - 10) {
//             $('.box_order').append();
            var data = {};
            data.page = $('#page').val();
            $.post('/order/order/order-list?status='.$status,data,function(result){
                if($('#pagemore').val() == 0){
                    return false;
                }
                if(result.list.length == 0){
                    var html = '没有更多内容了';
                }else{
                    var html = '';
                    for(var i = 0;i < result.list.length ;i++)
                        {
                            var status = '';
                            if(result.list[i].order_status == 0){
                                status = '<span class="zhuagntai">拼席中</span>';
                            }else if(result.list[i].order_status == 1){
                                status = '<span class="zhuagntai pinxichegngong">拼席成功</span>';
                            }else if(result.list[i].order_status == 2){
                                status = '<span class="zhuagntai yituikuan">已退款</span>';
                            }else if(result.list[i].order_status == 3){
                                status = '<span class="zhuagntai yiwanchegn">已完成</span>';
                            }
                            html+='<div class="pingxizhogn">';
                            html+='<i><img src="'+result.list[i].banquet_url+'"/></i>';
                            html+='<div class="pingxinrong">';
                            html+='<div class="pingxi_name">';
                            html+='<span class="pingxi_name_page">'+result.list[i].banquet_name+'</span>';
                            html+=status;
                            html+='</div>';
                            html+='<div class="pingxi_name pingxi_name_top">';
                            html+='<span class="pingxi_name_dianpu">'+result.list[i].shop_name+'</span>';
                            html+='<span class="zhuagntai_morer">¥ '+result.list[i].buy_price+'</span>';
                            html+='</div>';
                            html+='<div class="pingxi_name pingxi_name_top">';
                            html+='<span class="pingxi_name_dianpu">开席时间:<label>'+result.list[i].banquet_time+'</label></span>';
                            html+='<span class="zhuagntai_morer_coro">x<label>'+result.list[i].buy_seats+'</label></span>';
                            html+='</div>';
                            html+='</div>';

                            html+='<div class="shifukan">';
                            html+='<span>实付款</span>';
                            html+='<span class="shifuk_morety"><label>￥</label>'+result.list[i].pay_amount+'</span>';
                            html+='<a href="/order/order/order-info?rid='+result.list[i].record_id+'&uid='+result.list[i].user_id+'" class="chakank">查看</a>';
                            if(result.list[i].order_status == 3 && result.list[i].is_comment == 0){
                                html+='<a href="/order/order/order-comment?rid='+result.list[i].record_id+'" class="pinjia">评价</a>';
                            }
                            html+='</div>';
                            html+='</div>';
                        }

                }
                $('#page').val(parseInt($('#page').val())+1);
                $('.box_order').append(html);
                if(result.list.length == 0){
                    $('#pagemore').val(0);
                }
            },'json');

        }
    });
</script>
</body>
</html>