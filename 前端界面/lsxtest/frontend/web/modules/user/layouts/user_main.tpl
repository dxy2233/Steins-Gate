{$content}
<script type="text/javascript">
    $(function () {
        var aObj=$('.footbox').find('a');
        aObj.eq(0).attr('class','a1');
        aObj.eq(1).attr('class','a2');
        aObj.eq(2).attr('class','a3 a3_3');
    })
</script>
<!--底部-->
<div class="footbox">
    <a href="{homeurl('index')}" class="a1 a1_1">首页</a>
    <a href="{homeurl('/order/order/order-list')}" class="a2">订单</a>
    <a href="{homeurl('/user')}" class="a3">我</a>
</div>

