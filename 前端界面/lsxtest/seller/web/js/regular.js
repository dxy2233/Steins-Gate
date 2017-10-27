//判断输入是否是一个固定电话
function istell(str){
	var result=/^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/;
	if(result.test(str)){
		return true;
	} 
	return false;
}
// 判断输入是否是一个整数
function isint(str)
{
var result=str.match(/^(-|\+)?\d+$/);
if(result==null) return false;
return true;
}
// 判断输入是否是有效的长日期格式 - "YYYY-MM-DD HH:MM:SS" || "YYYY/MM/DD HH:MM:SS"
function isdatetime(str)
{
var result=str.match(/^(\d{4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/);
if(result==null) return false;
var d= new Date(result[1], result[3]-1, result[4], result[5], result[6], result[7]);
return (d.getFullYear()==result[1]&&(d.getMonth()+1)==result[3]&&d.getDate()==result[4]&&d.getHours()==result[5]&&d.getMinutes()==result[6]&&d.getSeconds()==result[7]);
}
// 验证手机号码
function checkMobile(str){
    if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(str))){
        return false;
    }
     return true;
} 

// 只能输入数字和一位小数点和小数点后面两位小数
function clearNoNum(obj){ 
    obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符  
    obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的  
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$","."); 
    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数  
    if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额 
        obj.value= parseFloat(obj.value); 
    } 
}
// 验证只能输入字母和数字
 // onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" 
      // window.location.reload();
function ajax_xi_status(num){
  var msg = '';
  if (num==1) {
      msg = '确认开启流水席？';
    }else{
      msg = '停止流水席后，所有该流⽔水席 拼席中的订单将全部自动退款给用户，是否确认停席?';
    }
  if (window.confirm(msg)) {
    $.ajax({
    cache: false,
    type: "POST",
    url: "/shop/flowingseat/update",
    data: {banquet_id:$('input[name="banquet_id"]').val(),num:num},
    success: function(result) {
      if (result.status == 1) {
        if (num==1) {
          $('.show_status_name').html('<span>席状态</span><label>开席中</label><button class="kaixil" onclick="ajax_xi_status(0)">关席</button>');
          alert('开席成功');
          // return false;
        }else{
          $('.show_status_name').html('<span>席状态</span><label>已停止</label><button class="kaixil" onclick="ajax_xi_status(1)">开席</button>');
          alert('关席成功');
          // return false;
        }
      } else if(result.status == -1){
        alert(result.msg);
      }else {
        if (num==1) {
          alert('开席失败');
        }else{
          alert('关席失败');
        }
      }
      window.location.reload();
    },
    error: function(result) {
      alert("异常", {
        icon: 2
      });
    }
  });
  };
}

//检查银行卡号
  function CheckBankNo(bankno) {
      var bankno = bankno.replace(/\s/g,'');
      if(bankno == "") {
          alert("请填写银行卡号");
          return false;
      }
      if(bankno.length < 16 || bankno.length > 19) {
          alert("银行卡号长度必须在16到19之间");
          return false;
      }
      var num = /^\d*$/;//全数字
      if(!num.exec(bankno)) {
          alert("银行卡号必须全为数字");
          return false;
      }
      //开头6位
      var strBin = "10,18,30,35,37,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,58,60,62,65,68,69,84,87,88,94,95,98,99";
      if(strBin.indexOf(bankno.substring(0, 2)) == -1) {
          alert("银行卡号开头6位不符合规范");
          return false;
      }
      //Luhn校验
      if(!luhnCheck(bankno)){
          return false;
      }
      return true;
  }

function luhnCheck(bankno){
      var lastNum=bankno.substr(bankno.length-1,1);//取出最后一位（与luhn进行比较）
  
      var first15Num=bankno.substr(0,bankno.length-1);//前15或18位
      var newArr=new Array();
      for(var i=first15Num.length-1;i>-1;i--){    //前15或18位倒序存进数组
          newArr.push(first15Num.substr(i,1));
      }
      var arrJiShu=new Array();  //奇数位*2的积 <9
      var arrJiShu2=new Array(); //奇数位*2的积 >9
      
      var arrOuShu=new Array();  //偶数位数组
      for(var j=0;j<newArr.length;j++){
          if((j+1)%2==1){//奇数位
              if(parseInt(newArr[j])*2<9)
              arrJiShu.push(parseInt(newArr[j])*2);
              else
              arrJiShu2.push(parseInt(newArr[j])*2);
          }
          else //偶数位
          arrOuShu.push(newArr[j]);
      }
      
      var jishu_child1=new Array();//奇数位*2 >9 的分割之后的数组个位数
      var jishu_child2=new Array();//奇数位*2 >9 的分割之后的数组十位数
      for(var h=0;h<arrJiShu2.length;h++){
          jishu_child1.push(parseInt(arrJiShu2[h])%10);
          jishu_child2.push(parseInt(arrJiShu2[h])/10);
      }        
      
      var sumJiShu=0; //奇数位*2 < 9 的数组之和
      var sumOuShu=0; //偶数位数组之和
      var sumJiShuChild1=0; //奇数位*2 >9 的分割之后的数组个位数之和
      var sumJiShuChild2=0; //奇数位*2 >9 的分割之后的数组十位数之和
      var sumTotal=0;
      for(var m=0;m<arrJiShu.length;m++){
          sumJiShu=sumJiShu+parseInt(arrJiShu[m]);
      }
      
      for(var n=0;n<arrOuShu.length;n++){
          sumOuShu=sumOuShu+parseInt(arrOuShu[n]);
      }
      
      for(var p=0;p<jishu_child1.length;p++){
          sumJiShuChild1=sumJiShuChild1+parseInt(jishu_child1[p]);
          sumJiShuChild2=sumJiShuChild2+parseInt(jishu_child2[p]);
      }      
      //计算总和
      sumTotal=parseInt(sumJiShu)+parseInt(sumOuShu)+parseInt(sumJiShuChild1)+parseInt(sumJiShuChild2);
      
      //计算luhn值
      var k= parseInt(sumTotal)%10==0?10:parseInt(sumTotal)%10;        
      var luhn= 10-k;
      
      if(lastNum==luhn){
         // console.log("验证通过");
          return true;
      }else{
         alert("银行卡号不规范");
          return false;
      }        
  }
$(function(){

})


 
