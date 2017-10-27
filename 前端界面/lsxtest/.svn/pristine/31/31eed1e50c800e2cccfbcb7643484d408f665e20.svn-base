<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>开席</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/style.js"></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js"></script>
    <script type="text/javascript" src="/js/layer_mobile/layer.js" ></script>
    <script type="text/javascript" src="/js/DateTimePicker.js" ></script>

    <link rel="stylesheet" href="/js/layer_mobile/need/layer.css" />
    <link rel="stylesheet" href="/css/DateTimePicker.css" />
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
            <span class="ruxi_shengyu">剩<label>{$lsx_info.total_peoples}</label>位</span>
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

    <div class="kaixi_biaotishi">
        <div class="kaixi_biaotishi_nage">席标题<span><input type="text" placeholder="请输入席标题" id="title"></span></div>
        <div class="kaixi_biaotishi_nage">开席日期<span>
{if $is_today eq 0 || $is_today eq 2}
			 	 	<label class="gongkaibtn">今天<i id="today" class="gongskai gongskaibtnage"><img src="/img/danxuankuang.png"/></i></label>
{/if}
                {if $is_today eq 0 || $is_today eq 1}
			 	 	<label class="gongkaibtn">明天<i id="tomo" class="gongskai {if $is_today eq 1}gongskaibtnage{/if}"><img src="/img/danxuankuang.png"/></i></label>
                {/if}
			 	 </span></div>
        <div class="kaixi_biaotishi_nage">开席时间
            <span class="databtnbox">
						 <input type="text" data-field="time" readonly placeholder="请选择时间段" id="time">
		                 <div id="dtBox"></div>
					</span>
        </div>
        <div class="kaixi_biaotishi_nage">营业时间<span><label>{$lsx_info.opening_hour}-{$lsx_info.closing_hour}</label></span></div>
        <div class="kaixi_biaotishi_nage">是否公开<span>
			 	 	<label class="gongkaibtn">公开<i class="gongskai gongskaibtnage" id="gongkai"><img src="/img/danxuankuang.png"/></i></label>
			 	 	<label class="gongkaibtn">私密<i class="gongskai" id="simi"><img src="/img/danxuankuang.png"/></i></label>
			 	 </span></div>

    </div>


    <!--确认支付-->
    <div class="qierenzhifubtn">
        <div class="zhifu_zongji">总计：<span>￥<label id="total">{$lsx_info.price}</label></span></div>
        <div class="zhifu_quer4nebnt"><a href="#" id="pay">确认付款</a></div>
    </div>


</div>
</body>
<script>
   function getlength(str) {
        var realLength = 0, len = str.length, charCode = -1;
        for (var i = 0; i < len; i++) {
            charCode = str.charCodeAt(i);
            if (charCode >= 0 && charCode <= 128) realLength += 1;
            else realLength += 2;
        }
        return realLength;
    };


    $(document).ready(function()
    {
        $("#dtBox").DateTimePicker(
            {
                dateFormat: "dd-MMM-yyyy"
            });
    });

    $(function() {
        $(".gongkaibtn").click(function(){
            $(this).children(".gongskai").addClass("gongskaibtnage").parent().siblings().children(".gongskai").removeClass("gongskaibtnage");
        });

        $("#today").click(function(){
            if({$is_today} == 1){
                $(this).removeClass("gongskaibtnage");
                $('#tomo').addClass("gongskaibtnage");
            }
        })

        $(".chkangend").click(function() {
            var Obj = $(this).parents('.xq_renshu').children(".gengduotoux");
            if(Obj.css('display') == 'none') {
                $(this).children().attr("src", "img/shouqiicon.png");
                $(this).parent().parent().siblings(".gengduotoux").slideDown();
            } else if(Obj.css('display') == 'block') {
                $(this).children().attr("src", "img/chakanquanbuicon.png");
                $(this).parent().parent().siblings(".gengduotoux").slideUp();
            }
        });
        $('.mui-numbox-btn-plus').click(function(){
            var number = $('.mui-numbox-input').val();
            var max = {$lsx_info.total_peoples};
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

        $('#title').blur(function(){
            var title = $(this).val();
//            var reg =/[@#\$%\^&\*]+/g;
            var reg =/[@/'\"#$%&^*]+/g;
            if (reg.test(title)) {
                layer.open({
                    content: '席标题不能包含非法字符！'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                $('#title').val('');
            }
            if(getlength(title) > 16)
                {
                    $('#title').val(null);
                    layer.open({
                        content: '席标题过长！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                }
        })

        $('#pay').on('click',function(){
            var ok = 1;
            var start = layer.open({
                type: 2
                ,content: '加载中...'
            });
            var data = {};
            data.price = {$lsx_info.price};
            data.number =  $('.mui-numbox-input').val();
            data.surplus = $('#meal_ticket').val();
            //席单信息先写死
            if($('#title').val() == '' || $('#title').val()== null){

                layer.open({
                    content: '席标题不能为空！'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                layer.close(start);
                return false;
            }
            var reg =/[@/'\"#$%&^*]+/g;
            if (reg.test($('#title').val())) {
                layer.open({
                    content: '席标题不能包含非法字符！'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                $('#title').val('');
                layer.close(start);
                return false;

            }
            if($('#time').val() == '' || $('#time').val()== null)
                {
                    layer.open({
                        content: '开席时间不能为空！'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    layer.close(start);
                    return false;
                }
            {*{$lsx_info.opening_hour}-{$lsx_info.closing_hour}*}
            {*var dd = {};*}
            data.time1 = '{$lsx_info.opening_hour}';
            data.time2 = '{$lsx_info.closing_hour}';
            data.time3 = $('#time').val();
//            $.post('/checkout/checkout/checktime',dd,function(res){
//                if(res.code==0)
//                    {
//                        layer.open({
//                            content: res.message
//                            ,skin: 'msg'
//                            ,time: 2 //2秒后自动关闭
//                        });
//                        layer.close(start);
//                        return false;
//                        ok = 0;
//                    }
//            },'json');
//            return false;
            data.banquet_title = $('#title').val();
            if($('#today').hasClass('gongskaibtnage')){
                data.today = 0;
            }else if($('#tomo').hasClass('gongskaibtnage')){
                data.today = 1;
            }
            data.banquet_time = $('#time').val();
            data.banquet_id = {$lsx_info.banquet_id};
            if($('#gongkai').hasClass('gongskaibtnage'))
                {
                    data.is_display = '1';
                }else if($('#simi').hasClass('gongskaibtnage')){
                data.is_display = '0';
            }

            $.post('/checkout/checkout/submit2',data,function(result){
                console.log(result);
                if(result.code == 1)
                {
                    layer.close(start);
                    window.location=result.url;
                }else if(result.code == 0)
                    {
                        layer.close(start);
                        layer.open({
                            content: result.message
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                    }
            },'json');

        });


    });
</script>

</html>