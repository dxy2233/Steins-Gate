{*<!DOCTYPE html>*}
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>分类</title>
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
    <div class="navfenlei">
        <button class="btn1"><span>{if $type eq 'zhineng'}智能排序{else if $type eq 'distance'}离我最近{else if $type eq 'pinglun'}好评优先{else if $type eq 'sell'}销量最高{/if}</span><i><img src="/img/xiapaixuicon.png" class="btn1img"/><img src="/img/shangpaixuicon.png" class="btn1img2"></i></button>
        <button class="btn2"><span>{if $time eq 'moring'}09:00 - 12:00{else if $time eq 'noon'}12:00 - 15:00{else if $time eq 'afternoon'}15:00 - 18:00{else}用餐时段{/if}</span><i><img src="/img/xiapaixuicon.png" class="btn2img"/><img src="/img/shangpaixuicon.png" class="btn2img2"></i></button>
    </div>
    <!--类别框-->
    <div class="leibiexuanzekuagn">
        <div class="btn1div">
            <a href="#"><span>智能排序</span><i class="leibie {if $type eq 'zhineng'}leibiexianshi{/if}" data="zhineng"><img src="/img/danxuankuang.png"/></i></a>
            <a href="#"><span>离我最近</span><i class="leibie {if $type eq 'distance'}leibiexianshi{/if}" data="distance"><img src="/img/danxuankuang.png"/></i></a>
            <a href="#"><span>好评优先</span><i class="leibie {if $type eq 'pinglun'}leibiexianshi{/if}" data="pinglun"><img src="/img/danxuankuang.png"/></i></a>
            <a href="#"><span>销量最高</span><i class="leibie {if $type eq 'sell'}leibiexianshi{/if}" data="sell"><img src="/img/danxuankuang.png"/></i></a>
            <input type="hidden" id="type" value="{if $type eq 'zhineng'}zhineng{else if $type eq 'distance'}distance{else if $type eq 'pinglun'}pinglun{else if $type eq 'sell'}sell{/if}">
        </div>
        <div class="btn1div2">
            <a href="#"><span>09:00 - 12:00</span><i class="leibie {if $time eq 'moring'}leibiexianshi{/if}" data="moring"><img src="/img/danxuankuang.png"/></i></a>
            <a href="#"><span>12:00 - 15:00</span><i class="leibie {if $time eq 'noon'}leibiexianshi{/if}" data="noon"><img src="/img/danxuankuang.png"/></i></a>
            <a href="#"><span>15:00 - 18:00</span><i class="leibie {if $time eq 'afternoon'}leibiexianshi{/if}" data="afternoon"><img src="/img/danxuankuang.png"/></i></a>
            <input type="hidden" id="time" value="{if $time eq 'moring'}moring{else if $time eq 'noon'}noon{else if $time eq 'afternoon'}afternoon{/if}">
        </div>
    </div>
    <!--产品展示-->
    <div class="zhanshibox">
        <!--产品展示-->
        {foreach from=$lsx_info item=lsx}
        <a href="goods-{$lsx.shop_id}-{$lsx.banquet_id}" class="remai_chanpin">
            <i class="remaichanpin_icon"><img src="{imageurl($lsx.banquet_url)}"/></i>
            <div class="remai_nribox">
                <p class="remai_name_box">{$lsx.banquet_name}</p>
                <p class="remai_dian_name">{$lsx.shop_name}</p>
                <p class="icon_xinxin">
		 					<span class="xinxin">
		 						{if $lsx.score eq 1}
                                    <label><img src="/img/manfen.png"/></label>
                                {else if $lsx.score eq 2}
                                <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                {else if $lsx.score eq 3}
                                <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                {else if $lsx.score eq 4}
                                <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                {else if $lsx.score eq 5}
                                <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                    <label><img src="/img/manfen.png"/></label>
                                {else}
                                {/if}
                                {if $lsx.banfen gt 0.4}
                                    <label><img src="/img/banfen.png"/></label>
                                {/if}
		 					</span>
                    <span class="fenshu"><label>{$lsx.service_score}</label> 分</span>
                </p>
                <p class="diqu">
                    <span class="diqu_weizhi"><label>渝北区</label><label class="juli">{$lsx.distance}m</label></span>
                    <span class="morey"><label>￥</label>{$lsx.price}</span>
                </p>
            </div>
        </a>
        {/foreach}

    </div>

</div>
</body>
<script>
    $(function(){
        $(".btn1").click(function(){
            $(this).css("color","#007AFF").siblings().css("color","#666666");
            $(".btn1img2").show();
            $(".btn1img").hide();
            $(".btn2img2").hide();
            $(".btn2img").show();
            $(".btn1div").slideDown(1);
            $(".btn1div2").hide();
            $(".leibiexuanzekuagn").slideDown(1);
        });

        $(".btn2").click(function(){
            $(this).css("color","#007AFF").siblings().css("color","#666666");
            $(".btn2img2").show();
            $(".btn2img").hide();
            $(".btn1img2").hide();
            $(".btn1img").show();
            $(".leibiexuanzekuagn").slideDown();
            $(".btn1div").hide();
            $(".btn1div2").slideDown();

        });
        $(".btn1div a").click(function(){
            var feileishi=$(this).children("span").text();
            $(".btn1").children("span").text(feileishi);
            $(this).css("color","#0084ff").siblings().css("color","#666666");
            $(this).children("i").addClass("leibiexianshi").parent().siblings().children().removeClass("leibiexianshi");
            $(".leibiexuanzekuagn").hide();
            $(".btn1div").hide();
            $(this).parent().parent().siblings().children("button").css("color","#666666");
            $(".btn1img2").hide();
            $(".btn1img").show();
            var type = $(this).children("i").attr('data');
            var time = $("#time").val();
            console.log(time);
            var data = {};
            data.type = type;
            data.time = time;
            $.post('goods_list-{$cat_id}',data,function(result){
//                console.log(result);
                $('body').html(result.data);
            },'json');
        });
        $(".btn1div2 a").click(function(){
            var feileishi=$(this).children("span").text();
            $(".btn2").children("span").text(feileishi);
            $(this).css("color","#0084ff").siblings().css("color","#666666");
            $(this).children("i").addClass("leibiexianshi").parent().siblings().children().removeClass("leibiexianshi");
            $(".leibiexuanzekuagn").hide();
            $(".btn1div2").hide();
            $(this).parent().parent().siblings().children("button").css("color","#666666");
            $(".btn2img2").hide();
            $(".btn2img").show();
            var time = $(this).children("i").attr('data');
//            var type = $(this).parent(".leibiexuanzekuagn").children(".btn1div").children('i').hasClass('leibiexianshi').attr('data');
            var type = $('#type').val();
            var data = {};
            data.time = time;
            data.type = type;
            $.post('goods_list-{$cat_id}',data,function(result){
//                console.log(result);
                $('body').html(result.data);
            },'json');
        });




    })


</script>
</html>