function checkShopName() {
    if ($('.bianji_left .input_bainji:nth-child(1) input').val().length >= 16) {
        $('.bianji_left .input_bainji:nth-child(1) .check').text('商家名称请在16个字以内');
    } else if ($('.bianji_left .input_bainji:nth-child(1) input').val().length == 0) {
        $('.bianji_left .input_bainji:nth-child(1) .check').text('商家名称不能为空');
    } else {
        $.ajax({
            url:'http://backend.lsx.earthwa.com/shop/shop/username',
            type:'GET',
            data:{
                shop_name : $('.bianji_left .input_bainji:nth-child(1) input').val()
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.success == 1) {
                    $('.bianji_left .input_bainji:nth-child(1) .check').text('');
                }
                else {
                    $('.bianji_left .input_bainji:nth-child(1) .check').text('名称重复');
                }
            },
            error: function () {
                console.log('error');
            }
        })
    }
}

function checkUser() {
    if ($('.bianji_left .input_bainji:nth-child(2) input').val().length >= 16) {
        $('.bianji_left .input_bainji:nth-child(2) .check').text('商家登录账号请在16个字符以内');
    } else if ($('.bianji_left .input_bainji:nth-child(2) input').val().length == 0) {
        $('.bianji_left .input_bainji:nth-child(2) .check').text('商家登录账号不能为空');
    } else {
        $('.bianji_left .input_bainji:nth-child(2) .check').text('');
    }
}

function checkPW() {
    var str = $('.bianji_left .input_bainji:nth-child(3) input').val().replace(/\s+/g, "");
    $('.bianji_left .input_bainji:nth-child(3) input').val(str);
    if (str.length >= 16) {
        $('.bianji_left .input_bainji:nth-child(3) .check').text('密码请小于16个字符');
    } else if (str.length <= 6) {
        $('.bianji_left .input_bainji:nth-child(3) .check').text('密码请大于6个字符');
    } else {
        $('.bianji_left .input_bainji:nth-child(3) .check').text('');
    }
}

function checkShopkeeperName() {
    if ($('.bianji_left .input_bainji:nth-child(4) input').val().length > 6) {
        $('.bianji_left .input_bainji:nth-child(4) .check').text('店主姓名请在6个字符以内');
    } else if ($('.bianji_left .input_bainji:nth-child(4) input').val().length == 0) {
        $('.bianji_left .input_bainji:nth-child(4) .check').text('店主姓名不能为空');
    } else {
        $('.bianji_left .input_bainji:nth-child(4) .check').text('');
    }
}

function checkIphone() {
    if (!/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/.test($('.bianji_left .input_bainji:nth-child(5) input').val())) {
        $('.bianji_left .input_bainji:nth-child(5) .check').text('请检查手机号');
    } else {
        $('.bianji_left .input_bainji:nth-child(5) .check').text('');
    }
}

function cheackShopArea() {
    if (!/^[1-9][0-9]*$/.test($('.bianji_left .input_bainji:nth-child(6) input').val())) {
        $('.bianji_left .input_bainji:nth-child(6) .check').text('请输入正确的商家面积');
    } else {
        $('.bianji_left .input_bainji:nth-child(6) .check').text('');
    }
}

function checkSeat() {
    if (!/^[1-9][0-9]*$/.test($('.bianji_left .input_bainji:nth-child(7) input').val())) {
        $('.bianji_left .input_bainji:nth-child(7) .check').text('请输入正确的座位数');
    } else {
        $('.bianji_left .input_bainji:nth-child(7) .check').text('');
    }
}

function checkRate() {
    if (!/^100$|^(\d|[1-9]\d)$/.test($('.bianji_left .input_bainji:nth-child(8) input').val())) {
        $('.bianji_left .input_bainji:nth-child(8) .check').text('请输入0-100的整数');
    } else {
        $('.bianji_left .input_bainji:nth-child(8) .check').text('');
    }
}

function checkBusiness() {
    if ($('.bianji_left .input_bainji:nth-child(10) .upload-skin a img').attr('src') == '') {
        $('.bianji_left .input_bainji:nth-child(10) .check').text('请上传营业执照');
        return
    } else {
        $('.bianji_left .input_bainji:nth-child(10) .check').text('');
    }
}

function checkHealth() {
    if ($('.bianji_left .input_bainji:nth-child(11) .upload-skin a img').attr('src') == '') {
        $('.bianji_left .input_bainji:nth-child(11) .check').text('请上传卫生许可证');
        return
    } else {
        $('.bianji_left .input_bainji:nth-child(11) .check').text('');
    }
}

function checkTelephone() {
    if (!/^(0|[1-9]\d{0,10})$/.test($('.bianji_right .input_bainji:nth-child(1) input').val())) {
        $('.bianji_right .input_bainji:nth-child(1) .check').text('请输入正确的号码');
    } else {
        $('.bianji_right .input_bainji:nth-child(1) .check').text('');
    }
}

function checkAddr() {
    if ($('.bianji_right .input_bainji:nth-child(3) input').val().length > 32) {
        $('.bianji_right .input_bainji:nth-child(3) .check').text('最大长度为32个字符');
    } else if ($('.bianji_right .input_bainji:nth-child(3) input').val().length <= 0) {
        $('.bianji_right .input_bainji:nth-child(3) .check').text('请输入地址');
    } else {
        $('.bianji_right .input_bainji:nth-child(3) .check').text('');
    }
}
function checkAddrSelect() {
    if ($('#s_province').text() == '请选择' || $('#s_city').text() == '请选择' ||
        $('#s_county').text() == '请选择') {
        $('.bianji_right .input_bainji:nth-child(2) .check').text('请选择地址');
    } else {
        $('.bianji_right .input_bainji:nth-child(2) .check').text('');
    }
}


$('.bianji_left .input_bainji:nth-child(1) input').blur(checkShopName);
$('.bianji_left .input_bainji:nth-child(2) input').blur(checkUser);
$('.bianji_left .input_bainji:nth-child(3) input').blur(checkPW);
$('.bianji_left .input_bainji:nth-child(4) input').blur(checkShopkeeperName);
$('.bianji_left .input_bainji:nth-child(5) input').blur(checkIphone);
$('.bianji_left .input_bainji:nth-child(6) input').blur(cheackShopArea);
$('.bianji_left .input_bainji:nth-child(7) input').blur(checkSeat);
$('.bianji_left .input_bainji:nth-child(8) input').blur(checkRate);
$('.bianji_right .input_bainji:nth-child(1) input').blur(checkTelephone);
$('.bianji_right .input_bainji:nth-child(3) input').blur(checkAddr);


function checkSub () {
    checkShopName();
    checkUser();
    checkPW();
    checkShopkeeperName();
    checkIphone();
    cheackShopArea();
    checkSeat();
    checkRate();
    checkTelephone();
    checkAddr();
    // checkBusiness();
    // checkHealth();
    checkAddrSelect();
    if ( $('.check').text()=='' ) {
        console.log('ss');
        return true;
    }else
    	{
    		return false;
		}
}

// $('.queren').click(function () {
//     checkSub();
// })

//图片放大
function picBig(imgSrc) {
	console.log(imgSrc);
    if(imgSrc == '') return;
    else {
        $('#divCenter').children('img').attr('src',imgSrc);
        $('#divCenter').show();
    }
}
function picClose() {
    $('#divCenter').hide();
}
