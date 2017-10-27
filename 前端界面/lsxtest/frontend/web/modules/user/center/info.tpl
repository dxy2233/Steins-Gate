<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>编辑个人资料</title>
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
    <!--内容区-->
    <div class="combox">
        <!--我的头像-->
        <a href="javascript:void(0);" id="uploadImage" class="wode_fanpiao wode_fanpiao_xiangqing ">
            <span class="icon_name icon_name2">头像</span>
            <label class="btn_morey_icon2"><img src="{$user_info.image_path}"/></label>
            <i class="right_btn2age"><img src="/img/right_icon.png"/></i>
        </a>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script type="text/javascript">
                //通过config接口注入权限验证配置
                wx.config({
                    debug: false,   //开启调试模式,调用的所有api的返回值会在客户端alert出来
                    appId: '{$signPackage.appId}',
                    timestamp: {$signPackage.timestamp},
                    nonceStr: '{$signPackage.nonceStr}',
                    signature: '{$signPackage.signature}',
                    jsApiList: ['chooseImage', 'uploadImage']   //需要使用的JS接口列表 这里我用了选择图片和上传图片接口
                });
                //通过ready接口处理成功验证，config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后
                wx.ready(function(){
                    //得到上传图片按钮
                    document.querySelector('#uploadImage').onclick = function() {
                        var images = {
                            localId:[],
                            serverId:[]
                        };
                        //调用 拍照或从手机相册中选图接口
                        wx.chooseImage({
                            success: function(res) {
                                if (res.localIds.length != 1) {
                                    alert('只能上传一张图片');
                                    return;
                                }
                                //返回选定照片的本地ID列表
                                images.localId = res.localIds;
                                images.serverId = [];
                                //上传图片函数
                                function upload() {
                                    //调用上传图片接口
                                    wx.uploadImage({
                                        localId: images.localId[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                                        isShowProcess: 1,   // 默认为1，显示进度提示
                                        success: function(res) {
                                            //返回图片的服务器端ID res.serverId,然后调用wxImgCallback函数进行下载图片操作
                                            wxImgCallback(res.serverId);
                                        },
                                        fail: function(res) {
                                            alert('上传失败');
                                        }
                                    });
                                }
                                upload();
                            }
                        });
                    }
                });
            function wxImgCallback(serverId) {
                //将serverId传给wx_upload.php的upload方法
                var url = '/user/center/wx-down-img';
                var data ={
                    media_id : serverId
                };
                $.getJSON(url,data, function(data){
                    if (data.code == 0) {
                        alert(data.message);
                    } else if (data.code == 1) {
                        //存储到服务器成功后的处理
                        alert(data.message);
                        window.location.reload();
                        //
                    }
                });
            }
        </script>
        <!--用户名-->
        <a href="/user/center/update?id={$user_info.user_id}&type=user_name" class="yonghuname">
            <span class="icon_name">用户名</span>
            <label class="btn_yonghu">{$user_info.user_name}</label>
            <i class="right_btn"><img src="/img/right_icon.png"/></i>
        </a>
        <a href="/user/center/update?id={$user_info.user_id}&type=sex" class="yonghuname">
            <span class="icon_name">性别</span>
            {if $user_info.sex eq 2}
            <label class="btn_yonghu">女</label>
            {elseif $user_info.sex eq 1}
            <label class="btn_yonghu">男</label>
            {else}
            <label class="btn_yonghu">其它</label>
            {/if}
            <i class="right_btn"><img src="/img/right_icon.png"/></i>
        </a>
        <a href="/user/center/update?id={$user_info.user_id}&type=birthday" class="yonghuname">
            <span class="icon_name">年龄</span>
            <label class="btn_yonghu">{if empty($user_info.age) && $user_info.age neq 0}未完善{else}{$user_info.age}{/if}</label>
            <i class="right_btn"><img src="/img/right_icon.png"/></i>
        </a>
        <!--职业-->
        <a href="/user/center/update?id={$user_info.user_id}&type=job" class="yonghuname" style="margin-top: 0.4rem;">
            <span class="icon_name">职业</span>
            <label class="btn_yonghu">{if empty($user_info.job)}未完善{else}{$user_info.job}{/if}</label>
            <i class="right_btn"><img src="/img/right_icon.png"/></i>
        </a>
        <!--<a href="#" class="yonghuname">
            <span class="icon_name">地址</span>
            <label class="btn_yonghu">重庆市 渝北区</label>
            <i class="right_btn"><img src="img/right_icon.png"/></i>
        </a> -->
        <!--手机-->
        <a href="javascript:void(0);" class="yonghuname mobile" style="margin-top: 0.4rem;">
            <span class="icon_name">手机</span>
            <label class="btn_yonghu">{if empty($user_info.mobile)}未完善{else}{$user_info.mobile}{/if}</label>
           <i class="right_btn"><img src="/img/right_icon.png"/></i>
        </a>
        {if empty($user_info.mobile)}
            <script type="text/javascript">
                $(function () {
                    $('.mobile').click(function () {
                        $.get('/user/center/check-mobile',function (result) {
                            if (result.code == 0) {
                                mui.toast(result.message,{ duration:'short', type:'div' });return false;
                            }else if(result.code == 1){
                                window.location.href = result.data;
                            }
                        },'json');
                    });
                });
            </script>
        {/if}
    </div>

</div>
</body>
</html>