<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>退款原因</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
    <script type="text/javascript" src="/js/style.js" ></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js" ></script>
    <script type="text/javascript" src="/js/layer_mobile/layer.js" ></script>

    <link rel="stylesheet" href="/js/layer_mobile/need/layer.css" />
    <link href="/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/index.css" />
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
</head>
<body>
<div class="box">
    <div class="tuikuanyuanyi">
        <h3 class="tuikyuayin">退款原因</h3>
        <div class="page1age">拼席时间太长了<i class="right_btn5 age" data="1"><img src="/img/danxuankuang.png"></i></div>
        <div class="page1age">临时有事，不能去吃了。<i class="right_btn5" data="2"><img src="/img/danxuankuang.png"></i></div>
        <div class="page1age">不想跟陌生人一起吃<i class="right_btn5" data="3"><img src="/img/danxuankuang.png"></i></div>
        <div class="page1age">软件出现错误<i class="right_btn5" data="4"><img src="/img/danxuankuang.png"></i></div>
        <input type="hidden" value="1" id="reason"/>

    </div>
    <div class="yaoqinhaoyou"><a href="javascript:void(0);" id="btn">确认提交</a></div>
</div>
</body>
<script>
    $(function(){
        $(".page1age").click(function(){
            $(this).children("i").addClass("age").parent().siblings().children("i").removeClass("age");
            var reason = $(this).children("i").attr('data');
            $('#reason').val(reason);
        })

        $('#btn').click(function(){
            var reason = $('#reason').val();
            var data = {};
            data.reason  = reason;
            data.record_id = {$record_id};
            $.post('/user/back/index',data,function(result){
                if(result.code == 0)
                    {
                        layer.open({
                            content: result.message
                            , btn: '我知道了'
                        });
                    }else if(result.code == 1)
                    {
                        layer.open({
                            content:  result.message
                            ,skin: 'msg'
                            ,time: 2
                        });
                        window.setTimeout("window.location='/order/order/order-list'",2000);
                    }

            },'json');
        })

    })
</script>
</html>