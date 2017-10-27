<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>评价</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
    <script type="text/javascript" src="/js/style.js" ></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js" ></script>
    <script type="text/javascript" src="/js/layer_mobile/layer.js"></script>
    <link href="/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/index.css" />

    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
</head>
<body>
<div class="box">
    <input type="hidden" name="record_id" value="{$record_id}">
    <input type="hidden" id="_csrf" name="{Yii::$app->request->csrfParam}" value="{yii::$app->request->csrfToken}">
    <div class="pingjaiage">
        <div class="xinji"><span class="pinfennam">总分</span>
            <span class="xiji stars">
		 			<label></label>
		 			<label></label>
		 			<label></label>
		 			<label></label>
		 			<label></label>
		 			<input type="hidden" name="service_score" value=""/>
		 		</span>
        </div>
        <div class="titext">
            <textarea placeholder="菜味道如何，服务是否周到，环境怎么样？" name="message_detail" class="message_detail"></textarea>
        </div>
    </div>
    <div class="tupian">
        <!--<input type="submit" class="tijiaopin" value="提交评论" />-->
        <a href="javascript:void(0);" class="sub-comment">提交评论</a>
    </div>
</div>
</body>
<script type="text/javascript">
    $(function () {
        var aObj=$('.footbox').find('a');
        aObj.eq(0).attr('class','a1');
        aObj.eq(1).attr('class','a2 a2_2');
        aObj.eq(2).attr('class','a3');
        $('.sub-comment').click(function () {
            var message_detail=$('.message_detail').val();
            var record_id=$('input[name="record_id"]').val();
            var service_score=$('input[name="service_score"]').val();
            if(record_id == null || record_id ==''){
                layer.open({
                    content: '⾮常抱歉~⽹络出故障了，请稍后再试'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });return false;
            }
            if(service_score == null || service_score ==''){
                layer.open({
                    content: '请给商品打分后再提交'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });return false;
            }
            if(message_detail ==null || message_detail==''){
                layer.open({
                    content: '请填写内容后再提交'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });return false;
            }
            var _csrf=$('#_csrf').val();
            var data={
                service_score:service_score,
                message_detail:message_detail,
                record_id:record_id,
                _csrf:_csrf
            }
            //loading层
            var loadingStart=layer.open({
                type: 2
                ,content: '加载中'
                ,shadeClose: false
            });
            $.post("/order/order/order-comment",data,function(result){
                if (result.code == -1) {
                    layer.open({
                        content: result.message
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    setTimeout(function () {
                        layer.close(loadingStart);
                    },3000);
                }else if (result.code == 1) {
                    window.location.href = "/order/order/comment-success";
                }
            },'json');
        });
    })
</script>
<script>
    $(function(){

        /*
        * 鼠标点击，该元素包括该元素之前的元素获得样式,并给隐藏域input赋值
        * 鼠标移入，样式随鼠标移动
        * 鼠标移出，样式移除但被鼠标点击的该元素和之前的元素样式不变
        * 每次触发事件，移除所有样式，并重新获得样式
        * */
        var stars = $('.stars');
        var Len = stars.length;
        //遍历每个评分的容器
        for(i=0;i<Len;i++){
            //每次触发事件，清除该项父容器下所有子元素的样式所有样式
            function clearAll(obj){
                obj.parent().children('label').removeClass('on');
            }
            stars.eq(i).find('label').click(function(){
                var num = $(this).index();
                clearAll($(this));
                //当前包括前面的元素都加上样式
                $(this).addClass('on').prevAll('label').addClass('on');
                //给隐藏域input赋值
                $(this).siblings('input').val(num+1);
            });
            stars.eq(i).find('label').mouseover(function(){
                var num = $(this).index();
                clearAll($(this));
                //当前包括前面的元素都加上样式
                $(this).addClass('on').prevAll('label').addClass('on');
            });
            stars.eq(i).find('label').mouseout(function(){
                clearAll($(this));
                //触发点击事件后input有值
                var score = $(this).siblings('input').val();
                for(i=0;i<score;i++){
                    $(this).parent().find('label').eq(i).addClass('on');
                }
            });
        }
    })


</script>
</html>