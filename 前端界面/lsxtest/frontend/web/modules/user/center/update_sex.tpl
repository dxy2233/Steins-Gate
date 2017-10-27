<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>性别</title>
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
            <span class="icon_name">男</span>
            <i class="right_btn5 {if $sex eq 1}age{/if}" id="man"><img src="/img/danxuankuang.png"/></i>
        </a>
        <a href="#" class="yonghuname yonghuname2">
            <span class="icon_name">女</span>
            <i class="right_btn5 {if $sex eq 2}age{/if}" id="women"><img src="/img/danxuankuang.png"/></i>
        </a>
        <div class="tijiao">
            <input type="submit" value="完 成" class="wancheng" />
        </div>


    </div>

</div>
<script type="text/javascript">

    $(function () {
        $('.wancheng').click(function(){
            var man = $('#man');
            var women =$('#women');
            var data = {};
            data.user_id = {$user_id};
            data.type = 'sex';
            if(man.hasClass('age')){
                data.sex = 1;
            }else if(women.hasClass('age')){
                data.sex = 2;
            }else{
                data.sex = 0;
            }
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