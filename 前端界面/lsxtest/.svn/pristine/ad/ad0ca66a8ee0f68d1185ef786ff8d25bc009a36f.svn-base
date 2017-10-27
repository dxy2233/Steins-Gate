<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>绑定手机号</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/style.js"></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="/js/base.js"></script>

    <link href="/css/mui.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/index.css" />
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>
</head>

<body>
<div class="box">
    <div class="bdsjh_box">
        <div class="bdsh_nav">为了确保账号安全，请先绑定手机号再付款</div>
        <div class="bdsh_input">
            <div class="bdsh_age1"><span>中国</span><span>+86</span></div>
            <div class="bdsh_age2"><input name="mobile" class="mobile" type="text" placeholder="请输入手机号"></div>
        </div>
        <div class="bdsh_yanzhengma">
            <div class="bdsh_page1">短信验证</div>
            <div class="bdsh_page2"><input type="text" class="verification" placeholder="输入验证码"></div>
            <div class="bdsh_page3"><button class="hqyzm">获取验证码</button></div>
        </div>
        <div class="bdsjh_tiaokauna">
			  	  	 <span class="xuanzhongbdsicon">
			  	  	 </span>
            <span>同意《流水席用户协议和隐私条款》</span>
        </div>
        <div class="querenbangding">
            <input type="button" class="sub_Verification" value="确认绑定" />
        </div>

    </div>
</div>
</body>
<script>
    var i=1;
    $(function() {
        $(".hqyzm").click(function(){
            var This=$(this);
            var mobile=$('.mobile').val();
            if (mobile == '' || mobile == null ) {
                mui.toast('请输入手机号',{ duration:'short', type:'div' });return false;
            }
            var data={
                mobile:mobile
            };
            $.get('/site/check-mobile',data,function (result) {
                if (result.code == 0) {
                    mui.toast(result.message,{ duration:'short', type:'div' });return false;
                }else if(result.code == 1) {
                    mui.toast(result.message,{ duration:'short', type:'div' });
                    This.attr('disabled','disabled');
                    var a=This.text("重新获取");
                    This.addClass("datacss");
                    This.append("<span class='dataspan'> <label class='sjdata'>60</label>s</span>")
                    var data=$(".sjdata").text();
                    var setintbs= setInterval(function(){
                        data=data-1;
                        $(".sjdata").text(data);
                        if(data==0){
                            clearInterval(setintbs);
                            This.removeAttr("disabled");
                            This.text("获取验证码");
                            $(".hqyzm").removeClass("datacss");
                            $(".dataspan").remove();
                            This.attr('style','color: #0084ff;background: #eef1ff;');
                        }
                    },1000);
                }
            },'json');

        });

        $(".bdsjh_tiaokauna").click(function(){
            if(i==1){
                /*
                 * xuanzhongbdsicon2表示不选中
                 * */
                $(".xuanzhongbdsicon").addClass("xuanzhongbdsicon2");
                $(".sub_Verification").attr('disabled','disabled');
                i=2;
            }else if(i==2){
                $(".xuanzhongbdsicon").removeClass("xuanzhongbdsicon2");
                $(".sub_Verification").removeAttr("disabled");
                i=1;
            }

        });
        
        //提交验证码绑定
        $('.sub_Verification').click(function () {
            var verification=$('.verification').val();
            var mobile=$('.mobile').val();
            if (mobile == '' || mobile == null ) {
                mui.toast('请输入手机号',{ duration:'short', type:'div' });return false;
            }
            if (verification == '' || verification == null ) {
                mui.toast('请输入验证码',{ duration:'short', type:'div' });return false;
            }
            var data ={
                verification :verification,
                mobile :mobile,
                {Yii::$app->request->csrfParam} :'{yii::$app->request->csrfToken}',
            }
            $.post('/user/center/bind-mobile',data,function (result) {
                if (result.code == 0) {
                    mui.toast(result.message,{ duration:'short', type:'div' });return false;
                }else if(result.code == 1){
                    mui.toast(result.message,{ duration:'short', type:'div' });
                    window.location.href='{$data}';
                }
            },'json');
        });
    });
</script>

</html>