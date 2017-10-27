<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>用户名</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
    <script type="text/javascript" src="/js/style.js" ></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js" ></script>
    <script type="text/javascript" src="/js/layer_mobile/layer.js" ></script>

    <link href="/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/js/layer_mobile/need/layer.css" />
    <link rel="stylesheet" href="/css/index.css" />
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
</head>
<body>
<div class="box">
    <!--内容区-->
    <div class="combox">

        <!--用户名-->
        <a href="#" class="yonghuname yonghuname2">
            <!--<span class="icon_name">用户名</span>-->
            <input type="text" class="input_name" placeholder="请输入用户名" value="{$user_name}" />
            <i class="right_btn2"><img src="/img/shanchu_icon.png"/></i>
        </a>
        <div class="tijiao">
            <input type="submit" value="完 成" class="wancheng" />
        </div>


    </div>

</div>
<script type="text/javascript">
    $(function () {
        $('.wancheng').click(function () {
            var username = $('.input_name').val();
            if(username.length >= 32)
                {
                    layer.open({
                        content: '用户名太长了'
                        , btn: '我知道了'
                    });
                    return false;
                }
            if(username == '')
            {
                layer.open({
                    content: '用户名不能为空'
                    , btn: '我知道了'
                });
                return false;
            }
            var data = {};
            data.user_name = username;
            data.user_id = {$user_id};
            data.type = 'user_name';
            $.post('/user/center/update',data,function(result){
                if(result.code == 0){
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
                        window.setTimeout("window.location='/user/center/info?id={$user_id}'",2000);
                    }
            },'json');
        })
    })
</script>
</body>
</html>