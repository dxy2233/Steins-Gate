<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>我的饭友</title>
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
    <input type="hidden" id="page" value="{$page}">
    <input type="hidden" id="pagemore" value="1">
    <!--内容区-->
    <div class="combox">
        {if empty($friend_list)}
            <div class="wudingdanimg">没有符合条件的记录
            </div>
        {else}
            {foreach from=$friend_list item=$friend}
                <div class="wodefanyou">
                    <i class="wofanimg_icon"><img src="{$friend.image_path}"/></i>
                    <div class="fanyou_name">
                        <span>{$friend.user_name}</span>
                        <label>与你一起吃过{$friend.times}次</label>
                    </div>
                </div>
            {/foreach}
        {/if}
    </div>

</div>
<script type="text/javascript">
        $(function () {
            var aObj=$('.footbox').find('a');
            aObj.eq(0).attr('class','a1');
            aObj.eq(1).attr('class','a2');
            aObj.eq(2).attr('class','a3 a3_3');
        })

    $(window).on('scroll', function() {
        if ($(document).scrollTop() + $(window).height() > $(document).height() - 10) {
//             $('.box_order').append();
            var data = {};
            data.page = $('#page').val();
            $.post('/user/friend/list',data,function(result){
                if($('#pagemore').val() == 0){
                    return false;
                }
                if(result.list.length == 0){
                    var html = '没有更多内容了';
                }else{
                    var html = '';
                    for(var i = 0;i < result.list.length ;i++)
                    {
                        html+='<div class="wodefanyou">';
                        html+='<i class="wofanimg_icon"><img src="/img/wodefanyou_icon-1.png"/></i>';
                        html+='<div class="fanyou_name">';
                        html+='<span>'+result.list[i].user_name+'</span>';
                        html+='<label>与你一起吃过'+result.list[i].times+'次</label>';
                        html+='</div>';
                        html+='</div>';
                    }

                }
                $('#page').val(parseInt($('#page').val())+1);
                $('.combox').append(html);
                if(result.list.length == 0){
                    $('#pagemore').val(0);
                }
            },'json');

        }
    });
</script>
</body>
</html>