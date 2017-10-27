<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>出生日期</title>
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
    <!--内容区-->
    <div class="combox">

        <!--用户名-->
        <a href="#" class="yonghuname yonghuname2">
            <span class="icon_name">出生日期</span>
            <input type="date" class="data" value="{$birthday}"/>
        </a>

        <div class="tijiao">
            <input type="submit" value="完 成" class="wancheng" />
        </div>


    </div>
</div>
<script type="text/javascript">

    $(function () {
        $('.wancheng').click(function(){
            var data = {};
            data.user_id = {$user_id};
            data.type = 'birthday';
            data.birthday = $('.data').val();
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
        });
    })
</script>
</body>
</html>