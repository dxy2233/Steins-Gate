<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>编辑流水席</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<script type="text/javascript" src="/js/regular.js"></script>
		<script type="text/javascript" src="/js/DateTimePicker.js"></script>
		<link rel="stylesheet" href="/css/DateTimePicker.css" />
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
	 
		
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>

	<body>
		<div class="box">
			<form class="mui-input-group" id='shop_login'  enctype="multipart/form-data"  action='save_main' method='post' >
			<input type="hidden"  name='banquet_id' value="{$banquet_id}">
			<div class="chakna">
				<div class="chapage1 show_status_name">
					<span>席状态</span>
					<label><!-- {if $list_msg.banquet_status<1} -->
					 			 	已停止
					 			 	</label>
									<button class="kaixil" type='button'  onclick="ajax_xi_status(1)">开席</button>
					 			 	<!-- {else} -->
					 			 	开席中
					 			 	</label>
									<button class="kaixil" type='button'  onclick="ajax_xi_status(0)">关席</button>
					 			 	<!-- {/if} -->
				</div>
				<div class="fenmian">
					<span>封面图</span>
					<label><img src="{imageurl($list_msg.banquet_url)|default:'/img/haixian_icon.png'}"/></label>
				</div>
				<div class="fenmian">
					<span>点击下面上传新的封面图</span><br/>
						<div class="container">
							<!--    照片添加    -->
							<div class="z_photo">
								<div class="z_file">
									<input type="file" name="file" id="file" value="" accept="image/*" multiple onchange="imgChange('z_photo','z_file');" />
								</div>
							</div>

							<!--遮罩层-->
							<div class="z_mask">
								<!--弹出框-->
								<div class="z_alert">
									<p>确定要删除这张图片吗？</p>
									<p>
										<span class="z_cancel">取消</span>
										<span class="z_sure">确定</span>
									</p>
								</div>
							</div>
						</div>
				</div>
				<div class="chapage1">
					<span>名称</span>
					<label><input type="text" onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\@\.]/g,'')" {if $list_msg.banquet_status==1} readonly{/if} maxlength='12' class="jidian" name='banquet_name' value="{$list_msg.banquet_name}"></label>
				</div>
				<a {if $list_msg.banquet_status<1} href="class?type_id={$list_msg.type_id}&banquet_id={$list_msg.banquet_id}" {/if} class="chapage1">
					<span>类别</span>
					<label class="leibir2">{$list_msg.type_name}</label>
					<i class="lefig"><img src="/img/leftimg.png"/></i>
				</a>
				<div class="tishi">
					<span>菜品</span>
					<label>* 菜品的价格不会作为实际价格结算，只作展示用</label>
				</div>
				<!--显示菜品-->
				<div class="caipinbox">
					<!-- {if $menu_list} -->
					<!-- {foreach from=$menu_list item=item} -->
					 <div class="tianjia_caipingbox">
					 	<span class="caiage_ming">{$item.menu_name}</span>
					 	<span>
					 		<div class="mui-numbox jainbtnan" data-numbox-step='1' data-numbox-min='0' data-numbox-max='100'>
					 			<input  name='menu_id[]' type="hidden" value='{$item.menu_id}' />
								<button class="mui-btn mui-numbox-btn-minus {if $list_msg.banquet_status<1} jiabtnboxpage1 {/if}  " type="button">-</button>
								<input class="mui-numbox-input shuliang"  {if $list_msg.banquet_status==1} readonly{/if}  name='menu_quantity[]'  {if $list_msg.banquet_status<1} onchange='change_save(this)'{/if}  type="number" value='{$item.menu_quantity}' />
								<button class="mui-btn mui-numbox-btn-plus {if $list_msg.banquet_status<1}  jiabtnboxpage2 {/if} " type="button">+</button>
							</div>
					 	</span> 
					 	<input type="hidden" class="price" value="{$item.menu_price}" />
					 	<span class="caiage_jiage">￥<label class="jiagemory">{$item.menu_price*$item.menu_quantity}</label></span> 
					 </div>
			 	<!-- {/foreach} -->
			 	<!--{/if} -->
				</div>
				<!--加减符号-->
				<div class="jiajianbtn">
					<a  {if $list_msg.banquet_status<1} href="add?banquet_id={$banquet_id}" {/if}  class="jaiimg"><img src="/img/bianjijia.png"/></a>
					<a {if $list_msg.banquet_status<1} href="delete?banquet_id={$banquet_id}"  {/if} class="jaiimg"><img src="/img/jianbtn.png"/></a>
				</div>
				<div class="chapage1">
					<span>每位价格</span>
					<label class="jiagexiugai" style='width:50%'>￥<input  {if $list_msg.banquet_status==1} readonly{/if}  style='width:80%'  onkeyup="if(isNaN(value))execCommand('undo')" data-numbox-step='10.01' data-numbox-min='10.01' data-numbox-max='100000' onafterpaste="if(isNaN(value))execCommand('undo')" name='price' class='danjia' type="text" value="{$list_msg.price}"></label>
				</div>
				<div class="chapage1">
					<span>开席人数</span>
					<div class="mui-numbox jainbtnan" data-numbox-step='1' data-numbox-min='1' data-numbox-max='100'>
						<button class="mui-btn mui-numbox-btn-minus renshubtnj1"  type="button">-</button>
						<input class="mui-numbox-input renshubtnjinput" name='total_peoples'  {if $list_msg.banquet_status==1} readonly{/if}  onchange='setageout();' type="number"  value='{$list_msg.total_peoples}'/>
						<button class="mui-btn mui-numbox-btn-plus renshubtnj2"   type="button">+</button>
					</div> 
				</div>
				<div class="chapage1" style="padding-right: 0rem;">
					<span>每席总价</span>
					<label class="jiagexiugai"><label>{$list_msg.price*$list_msg.total_peoples}</label></label>
					<!-- <input class='total_money' n	ame='banquet_amount' type="hidden"value="{$list_msg.banquet_amount}"> -->
				</div>
				<div class="chapage1">
					<span>每日最多开席数</span>
					<div class="mui-numbox jainbtnan" data-numbox-step='1' data-numbox-min='1' data-numbox-max='100'>
						<button class="mui-btn mui-numbox-btn-minus" type="button">-</button>
						<input class="mui-numbox-input"  {if $list_msg.banquet_status==1} readonly{/if}  data-numbox-step='1' data-numbox-min='1' data-numbox-max='100000' type="number" name='banquet_number' value='{$list_msg.banquet_number}' />
						<button class="mui-btn mui-numbox-btn-plus" type="button">+</button>
					</div>

				</div>
				<div class="kaiqishijian">
					<span>开启时间</span>
					<label>
					  <input type="text" class="kaiqiiput"  {if $list_msg.banquet_status==1} readonly{/if}  name='begin_time' data-field="time" value='{$list_msg.begin_time}' readonly placeholder="请选择时间段">  
		              </label>
					<div id="dtBox"></div>
				</div>
				
				<div class="kaiqishijian" style="margin-top: 0rem;">
					<span>关闭时间</span>
					<label>
					  <input type="text"  {if $list_msg.banquet_status==1} readonly{/if}  class="kaiqiiput" name='end_time' data-field="time" value='{$list_msg.end_time}'  readonly placeholder="请选择时间段">  
		              </label>
					<div id="dtBox"></div>
				</div>
				
			</div>
            <div class="bianjitijia"> 
            	<button type='button' id='submit_baquet' class="btn1">确认保存</button>
            	<button class="btnsc" type='button'  onclick='delete_bquet()'>删除</button>
            </div>
        </form>
		</div>
	</body>
	<script> 
	$(document).ready(function() {
			$("#dtBox").DateTimePicker({
				dateFormat: "dd-MMM-yyyy"
			});
		});
		$(function() {

		    $('#submit_baquet').click(function(){
		    	if ({$list_msg.banquet_status}==1) {
		    	 	alert('该流水席正在开席中，要关席才能修改！');
		    	 	return false;
		    	};
		    	 if ($('.jidian').val()=='') {
		    	 	alert('流水席名称不能为空');
		    	 	return false;
		    	 };
		    	 if ($("input[name='price']").val()=='') {
		    	 	alert('每位价格不能为空');
		    	 	return false;
		    	 };
		    	 var begin_time = $("input[name='begin_time']").val();
		    	 var end_time = $("input[name='end_time']").val();
		    	 var shop_opening_hour = '{$shop_time.opening_hour|default:0}';
		    	 var shop_closing_hour = '{$shop_time.closing_hour|default:0}';
		    	 if (begin_time=='') {
		    	 	alert('请选择开启时间段');
		    	 	return false;
		    	 };
		    	 if (end_time=='') {
		    	 	alert('请选择关闭时间段');
		    	 	return false;
		    	 };

		    	 if (begin_time.substr(0,2)>end_time.substr(0,2)) {
		    	 	alert('开启时间段不能大于关闭时间段');
		    	 	return false;
		    	 };
		    	 if (begin_time.substr(0,2)==end_time.substr(0,2)&&begin_time.substr(3)<end_time.substr(3)) {
		    	 	alert('开启时间段不能大于关闭时间段');
		    	 	return false;
		    	 };
		    	 if (begin_time.substr(0,2)<shop_opening_hour.substr(0,2)) {
		    	 	alert('开启时间段不能小于店铺营业时间');
		    	 	return false;
		    	 };
		    	 if (begin_time.substr(0,2)==shop_opening_hour.substr(0,2)&&begin_time.substr(3)<shop_opening_hour.substr(3)) {
		    	 	alert('开启时间段不能小于店铺营业时间');
		    	 	return false;
		    	 };
		    	 if (end_time.substr(0,2)>shop_closing_hour.substr(0,2)) {
		    	 	alert('关闭时间段不能大于店铺歇业时间');
		    	 	return false;
		    	 };
		    	 if (end_time.substr(0,2)==shop_closing_hour.substr(0,2)&&end_time.substr(3)>shop_closing_hour.substr(3)) {
		    	 	alert('关闭时间段不能大于店铺歇业时间');
		    	 	return false;
		    	 };
		    	 $('#shop_login').submit();
		    	
		    })
			
			
		});
        function change_save(obj){
       		setAmountCount($(obj),$(obj).parents('.tianjia_caipingbox').eq(0).find('.jiagemory').eq(0));
        }
		/*人数*每位价格*/
		function setageout(){
			/*人数*/

			var renshubtnjinput=parseInt($(".renshubtnjinput").val());


		    /*单价*/
			var danjia=$(".danjia").val();
			var zo=Math.round(renshubtnjinput*danjia*100)/100;
			$(".jiagexiugai").children("label").text(zo);
			
			
		}

		/*删除流水席*/
		function delete_bquet(){
			if (confirm('确认删除这个流水席吗')==true) {
				window.location.href='/shop/flowingseat/delete_bquet?banquet_id={$banquet_id}'
			};
			return false;
		}
		
		/*菜品数量*单价*/
		function setAmountCount(Obj,textObj){
				var jiagemoryobj=parseFloat(Obj.parents('.tianjia_caipingbox').eq(0).find('.price').val());
				var shuliang = Obj.val();
				if (shuliang==0) {
					var data = {};
					data.menu_id = Obj.siblings("input[name='menu_id[]']").val();
					data.banquet_id = $("input[name='banquet_id']").val();
					$.ajax({
						cache: false,
						type: "POST",
						url: "/shop/flowingseat/delete",
						data: data,
						success: function(result) {
							if (result.status == 1) {
								alert(result.msg);
								Obj.parents('.tianjia_caipingbox').remove();
							}else {
								alert(result.msg);
								Obj.val(1);
								change_save(Obj);
				      		}
						},
						error: function(result) {
							alert("异常", {
								icon: 2
							});
						}
					});
				};
				// console.log(jiagemoryobj+':'+shuliang);
				textObj.text(Math.round(shuliang*jiagemoryobj*100)/100);
			}
		//px转换为rem
		(function(doc, win) {
			var docEl = doc.documentElement,
				resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
				recalc = function() {
					var clientWidth = docEl.clientWidth;
					if(!clientWidth) return;
					if(clientWidth >= 640) {
						docEl.style.fontSize = '100px';
					} else {
						docEl.style.fontSize = 100 * (clientWidth / 640) + 'px';
					}
				};

			if(!doc.addEventListener) return;
			win.addEventListener(resizeEvt, recalc, false);
			doc.addEventListener('DOMContentLoaded', recalc, false);
		})(document, window);

		function imgChange(obj1, obj2) {
			console.log(1)
			//获取点击的文本框
			var file = document.getElementById("file");
			//存放图片的父级元素
			var imgContainer = document.getElementsByClassName(obj1)[0];
			//获取的图片文件
			var fileList = file.files;
			//文本框的父级元素
			var input = document.getElementsByClassName(obj2)[0];
			var imgArr = [];
			//遍历获取到得图片文件
			for(var i = 0; i < fileList.length; i++) {
				var imgUrl = window.URL.createObjectURL(file.files[i]);
				imgArr.push(imgUrl);
				var img = document.createElement("img");
				img.setAttribute("src", imgArr[i]);
				var imgAdd = document.createElement("div");
				imgAdd.setAttribute("class", "z_addImg");
				imgAdd.appendChild(img);
				imgContainer.appendChild(imgAdd);
			};
			imgRemove();
		};

		function imgRemove() { 
			var imgList = document.getElementsByClassName("z_addImg");
			var mask = document.getElementsByClassName("z_mask")[0];
			var cancel = document.getElementsByClassName("z_cancel")[0];
			var sure = document.getElementsByClassName("z_sure")[0];
			for(var j = 0; j < imgList.length; j++) {
				imgList[j].index = j;
				imgList[j].onclick = function() {
					console.log(1)
//					var t = this;
//					mask.style.display = "block";
					cancel.onclick = function() { 
						mask.style.display = "none";
					};
					sure.onclick = function() { 
						mask.style.display = "none";
						t.style.display = "none";
					};

				}
			};
		};
	</script>

</html>