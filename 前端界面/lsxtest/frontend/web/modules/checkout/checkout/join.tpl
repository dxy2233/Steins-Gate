<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>入席</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/style.js"></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js"></script>
    <script type="text/javascript" src="/js/layer_mobile/layer.js" ></script>

    <link rel="stylesheet" href="/js/layer_mobile/need/layer.css" />
    <link href="/css/mui.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/index.css" />
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
</head>

<body>
<div class="box">
    <div class="ruxibox">
        <div class="ruxinavbox">
            <i><img src="{imageurl($lsx_info.banquet_url)}"/></i>
            <div class="ruxititile">
                <div class="ruxititile_name">{$lsx_info.banquet_name}</div>
                <div class="ruxititile_dianming">{$lsx_info.shop_name}</div>
                <div class="ruxititile_morey">￥<label>{$lsx_info.price}</label></div>

            </div>
        </div>
        <div class="ruxishuliangruxi">
            <span class="shuliangruxi">数量</span>
            <span class="ruxi_shengyu">剩<label>{$order_info.total_peoples - $order_info.joined_peoples}</label>位</span>
            <span class="jiajianruxirenshu">
			 			<div class="mui-numbox" data-numbox-step='1' data-numbox-min='1' data-numbox-max='100'>
						  <button class="mui-btn mui-numbox-btn-minus" type="button">-</button>
						  <input class="mui-numbox-input" type="number" disabled/>
						  <button class="mui-btn mui-numbox-btn-plus" type="button">+</button>
						</div>
			 		</span>
        </div>
        <div class="fanpiaodikoiu">
            <span class="fanpiaodikoutiti">饭票抵扣</span>
            <span class="dikoumorey">
			 			<span class="dikoumorey_moery">
			 				<label>可用￥</label>
			 				<label>{$meal_balance}</label>
			 			</span>
					<span class="ruxijinepinut"><input type="text" id="meal_ticket"></span>
					</span>
        </div>
        <div class="xiaoji_ruxi">
            <span>小计</span>
            <span class="xiaojijinebox">￥<label id="xiaoji">{$lsx_info.price}</label></span>
        </div>

    </div>
    <div class="xq_renshu">
        <div class="xq_age1">
            <span class="dinshi">{$order_info.eat_today}{$order_info.eat_time}<label> 开席</label></span>
            <span class="xq_ren_name">{$order_info.banquet_name} </span>
            <span class="renhsugershu">
			 	 		<i class="renshuicon"><img src="/img/renshuimg_03.png"/></i>
			 	 		<span><label>{$order_info.joined_peoples}</label>/<label>{$order_info.total_peoples}</label> </span>
					</span>
        </div>
        <div class="renshutoux">
					<span class="iconrsu">
                        {foreach from=$order_info.user_info item=user_info key=key}
                            {if $key lte 4}
                                <i class="renshutou"><img src="{$user_info.image_path}"/></i>
                            {/if}
                        {/foreach}
			 	 	</span>
            <span class="xsyc"><i class="chkangend"><img src="/img/chakanquanbuicon.png"/></i></span>
        </div>
        <div class="gengduotoux">
					<span class="iconrsu">
			 	 		{foreach from=$order_info.user_info item=user_info key=key}
                            {if $key gt 4}
                                <i class="renshutou"><img src="{$user_info.image_path}"/></i>
                            {/if}
                        {/foreach}
			 	 	</span>
        </div>
        <div class="xq_lijiruxi">
            <span class="zuohoa">桌号：<label>{$order_info.banquet_number}</label></span>
            {*<a href="#" class="lijiruxixq"><img src="/img/yipinman.png" /></a>*}
        </div>
    </div>
    <!--确认支付-->
    <div class="qierenzhifubtn">
        <div class="zhifu_zongji">总计：<span>￥<label id="total">{$lsx_info.price}</label></span></div>
        <div class="zhifu_quer4nebnt"><a href="#" id="pay">确认付款</a></div>
    </div>


</div>
</body>
<script>
    $(function() {
        $(".chkangend").click(function() {
            var Obj = $(this).parents('.xq_renshu').children(".gengduotoux");
            if(Obj.css('display') == 'none') {
                $(this).children().attr("src", "/img/shouqiicon.png");
                $(this).parent().parent().siblings(".gengduotoux").slideDown();
            } else if(Obj.css('display') == 'block') {
                $(this).children().attr("src", "/img/chakanquanbuicon.png");
                $(this).parent().parent().siblings(".gengduotoux").slideUp();
            }
        });

        $('.mui-numbox-btn-plus').click(function(){
            var number = $('.mui-numbox-input').val();
            var max = {$order_info.total_peoples - $order_info.joined_peoples};
            var ticket = $('#meal_ticket').val();
            if(number > max)
                {
                    layer.open({
                        content: '最多只能选择'+max+'个座位'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    $('.mui-numbox-input').val(number-1);
                }
            var paymoney = $('.mui-numbox-input').val()*{$lsx_info.price} - ticket;
            paymoney = Math.round(paymoney*100)/100;
            $('#total').html(paymoney);
            $('#xiaoji').html(paymoney);

        })
        $('.mui-numbox-btn-minus').click(function(){
            var ticket = $('#meal_ticket').val();
            var number = $('.mui-numbox-input').val();
            var paymoney = $('.mui-numbox-input').val()*{$lsx_info.price} - ticket;
            paymoney = Math.round(paymoney*100)/100;
            $('#total').html(paymoney);
            $('#xiaoji').html(paymoney);
        })

        $('.mui-numbox-input').change(function(){
            var ticket = $('#meal_ticket').val();
            var number = $('.mui-numbox-input').val();
            var paymoney = $('.mui-numbox-input').val()*{$lsx_info.price} - ticket;
            paymoney = Math.round(paymoney*100)/100;
            $('#total').html(paymoney);
            $('#xiaoji').html(paymoney);
        })

        $('#meal_ticket').blur(function(){
            var ticket = $('#meal_ticket').val();
            if(!/^\d+(?:\.(\d\d))?$/.test(ticket) && !/^\d+(?:\.(\d))?$/.test(ticket) && !/^\+?[1-9][0-9]*$/.test(ticket)){
                layer.open({
                    content: '输入饭票格式不对'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                $('#meal_ticket').val(0);
                return false;
            }
            if(ticket > {$meal_balance}){
                layer.open({
                    content: '饭票余额不足'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                $('#meal_ticket').val(0);
//                return false;
            }
            if(ticket > $('.mui-numbox-input').val()*{$lsx_info.price})
                {
                    layer.open({
                        content: '饭票最多可使用'+$('.mui-numbox-input').val()*{$lsx_info.price}+'元'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    $('#meal_ticket').val(0);
//                    return false;
                }
            var number = $('.mui-numbox-input').val();
            var paymoney = $('.mui-numbox-input').val()*{$lsx_info.price} - $('#meal_ticket').val();
            paymoney = Math.round(paymoney*100)/100;
            $('#total').html(paymoney);
            $('#xiaoji').html(paymoney);
        })

        $('#pay').on('click',function(){
            //loading带文字

            var start = layer.open({
                type: 2
                ,content: '加载中...'
            });
            var data = {};
            data.order_id = {$order_info.order_id};
            data.banquet_id = {$order_info.banquet_id};
            data.price = {$lsx_info.price};
            data.number =  $('.mui-numbox-input').val();
            data.surplus = $('#meal_ticket').val();
            $.post('/checkout/checkout/submit',data,function(result){
                 console.log(result);
                 if(result.code == 1)
                     {
                         layer.close(start);
                         window.location=result.url;
                     }
            },'json');

        });

    });
</script>

</html>