<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>感谢评价</title>
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
    <div class="ganxiepinlu">
        <div class="tupfanx"><img src="/img/ganxieimg.png"/></div>
        <div class="shijain"><label class="shidata">3</label> 秒后返回订单页面</div>
    </div>
</div>
</body>
<script>
    var data=$(".shidata").text();
    $(function(){
        setInterval(function(){
            data--;
            $(".shidata").text(data);
            if(data==0){
                window.location.href="/order/order/order-list";
            }
        },1000);

    })

</script>
</html>