<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>添加流水席</title>
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="/js/DateTimePicker.js" ></script>
		<script src="/js/mui.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		<link rel="stylesheet" href="/css/DateTimePicker.css" />
		<link href="/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/css/base.css" />
		<script type="text/javascript" charset="utf-8">
			mui.init();
		</script>
	</head>
<style>
	/*单选*/
.age {
    display: block !important;
} 
.right_btn5 {
    float: right;
    width: 0.42rem;
    height: 0.42rem;
    position: relative;
    top: 34%;
    margin-right: 0.35rem;
    display: none;
}
.right_btn5 img{
	width: 100%;
	height: 100%;
}
</style>
	<body>
		<!-- 选择类型 -->
		<div class="box box_class" style='display:none'> 
			<div class="lebibox">
		        <div class="leibiegaun">选择类别</div>
		        <!-- {if $type_list} -->
				<!-- {foreach from=$type_list item=tl} -->
				<!-- if $tl.type_id==$type_msg checked='checked'  /if -->
				 <div class="leibbtn">
		        	<span class='type_name'>{$tl.type_name}</span>
		        	 <i class="right_btn5" type_id='{$tl.type_id}'><img src="/img/danxuankuang.png"></i>
		        </div>
				<!-- <div class="leibbtn">
		        	<span><label class='type_name'>{$tl.type_name}</label><input  value='{$tl.type_id}' type="hidden" name="type"></span>
		        	 <i class="right_btn5"><img src="img/danxuankuang.png"></i>
		        </div> -->
			 	<!-- {/foreach} -->
			 	<!--{/if} -->
		    </div>
		     <div class="tinleib"> <input style='font-size:32px;' type="button"  class="queren sure_calss" value="确认"></div>
		</div>

	<!-- 添加菜品 -->
	<div class="box box_add_menu" style='display:none'>
			<div class="tianjaicaipinbox add_class">
				<div class="caipinliebiaoage">
					<span class="spancaipin">菜品列表(共<label>{count($Menu_id_list)}</label>项)</span>
					<a class="aagecaipin aagecaipin_add" ><img src="/img/querenbtn.png" /></a>
				</div>
				 <!-- {if $Menu_id_list} -->
				<!-- {foreach from=$Menu_id_list item=mil} -->
					<!-- if !in_array($mil.dish_id,$Menu_id_array) -->
					<div class="caipinagebox">
						<div class="mui-input-row mui-checkbox mui-left dish_id_parent"> 
							<input name="dish_id[]" class='dish_id{$mil.dish_id}'  value="{$mil.dish_id}" type="checkbox" style="top: 10px;z-index: 999;">
							<span class="cai_namge dish_name">{$mil.dish_name}</span>
							<p class="cai_moeryjiage">￥<span class='dish_price'>{$mil.dish_price}</span></p>
						</div> 
					</div>
					<!-- /if -->
				<!-- {/foreach} -->
				<!-- {/if} -->
			</div>
		</div>
	<!-- 删除菜品 -->
	<div class="box box_delete_menu" style='display:none'>
			<div class="tianjaicaipinbox delete_class">
				<div class="caipinliebiaoage">
					<span class="spancaipin">菜品列表(共<label>38</label>项)</span>
					<a class="aagecaipin aagecaipin_delete" ><img src="/img/shanchubtnimg.png" /></a>
				</div>
				
			</div>

		</div>
		<!-- 第一步 -->
		<form  id="uploadForm" method="post" enctype="multipart/form-data" action="" > 
		<div class="box box_one">
			<div class="addliushuixi">
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
				<!---->
				<div class="tianjia_mingcehn">
					<span>名称</span>
					<input type="text" name='banquet_name' onkeyup="value=value.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\@\.]/g,'')"  maxlength='12'  placeholder="请输入流水席名称" />
				</div>
				<div class="tianjia_mingcehn select_class_msg">
					<span>类别</span>
					<a ><label class='caipin_name'>请选择</label><i class="lefig"><img src="/img/leftimg.png"></i></a>
					<input  type="hidden" name='type_id' value/>
				</div>
				<div class="tianji_tishi">
			 	   	   <span>菜品</span>
			 	   	   <label>* 菜品的价格不会作为实际价格结算，只作展示用</label>
			 	</div>
				<div class="caipinbox">
					 
				</div>
				<!--加减符号-->
				<div class="jiajianbtn">
					<a  class="jaiimg add_show_menu"><img src="/img/bianjijia.png"/></a>
					<a  class="jaiimg delete_show_menu"><img src="/img/jianbtn.png"/></a>
				</div> 
			</div>
            <div class="xiayibubtn"><a class='addmain_next'>下一步</a></div>
		</div>
		
		<!-- 第二步 -->
		<div class="box box_two"  style='display:none'>
			<div class="tianjialiushuixi_xiayibu">
				<div class="chapage1" style="padding-right: 0rem;">
					<span>每位价格</span>
					<label class="jiagexiugai"><input  onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" name='price' type="text" class="danjaimor" value=""></label>
				</div>
				<div class="chapage1">
					<span>开席人数</span>
					<div class="mui-numbox jainbtnan" data-numbox-step='1' data-numbox-min='0' data-numbox-max='100'>
						<button class="mui-btn mui-numbox-btn-minus renshubtnj1"   type="button">-</button>
						<input name='total_peoples' class="mui-numbox-input renshubtnjinput"  onkeyup="value=value.replace(/[^/d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^/d]/g,''))" type="number"   onchange='setageout();'  />
						<button class="mui-btn mui-numbox-btn-plus renshubtnj2" type="button">+</button>
					</div> 
				</div>
				<div class="xiayibutnage">
					*添加的菜品总价（门市价）为￥<label class="total_money_msg">0</label><input class="total_money" name='banquet_amount' type="hidden" value='0'/>
				</div>
				<div class="chapage1" style="padding-right: 0rem;">
					<span>每席总价</span>
					<label class="jiagexiugai"><label></label></label>
				</div>
				<div class="chapage1">
					<span>每日最多开席数</span>
					<div class="mui-numbox jainbtnan" data-numbox-step='1' data-numbox-min='1' data-numbox-max='100'>
						<button class="mui-btn mui-numbox-btn-minus" type="button">-</button>
						<input name='banquet_number' class="mui-numbox-input"  onkeyup="value=value.replace(/[^/d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^/d]/g,''))" type="number" />
						<button class="mui-btn mui-numbox-btn-plus" type="button">+</button>
					</div>

				</div> 
			</div>
			<div class="kaiqishijian">
					<span>开启时间</span>
					<label>
					  <input type="text" class="kaiqiiput" name='begin_time' data-field="time" readonly placeholder="请选择时间段">  
		              </label>
					<div id="dtBox"></div>
				</div>
				
				<div class="kaiqishijian" style="margin-top: 0rem;">
					<span>关闭时间</span>
					<label>
					  <input type="text" class="kaiqiiput" name='end_time'  data-field="time" readonly placeholder="请选择时间段">  
		              </label>
					<div id="dtBox"></div>
				</div>
			
			
            <div class="xiayibubtn"><a id='release'>发布流水席</a></div>
		</div>

		</form>
	</body>
	<script type="text/javascript">
	$(".leibbtn").click(function(){
    	$(this).children(".right_btn5").addClass("age").parent().siblings().children(".right_btn5").removeClass("age");
    });
	$(document).ready(function() {
			$("#dtBox").DateTimePicker({
				dateFormat: "dd-MMM-yyyy"
			});
		});
		$(function() {
			// console.log(getObjectURL($("input[name='file']").files[0]));
			// if ($("input[name='file']").val()=='') {
			// 		alert('请先选择流水席结束时间');
					// return false;
			// 	};
			$('#release').click(function() {
			var type_id = $("input[name='type_id']").val();

			var banquet_name = $("input[name='banquet_name']").val();

			var dish_id = $(".show_dish_id").val();

			var menu_quantity = $("input[name='menu_quantity[]']").val();

			var price = $("input[name='price']").val();

			var total_peoples = $("input[name='total_peoples']").val();

			var banquet_number = $("input[name='banquet_number']").val();

			var begin_time = $("input[name='begin_time']").val();

			var end_time = $("input[name='end_time']").val();

			var imgurl = $('.z_addImg>img').attr('src');

			var shop_opening_hour = '{$shop_time.opening_hour|default:"00:00"}';

		    var shop_closing_hour = '{$shop_time.closing_hour|default:"00:00"}';
				if (imgurl==undefined) {
					alert('请先上传封面图');
					return false;
				};
				if (banquet_name=='') {
					alert('请输入流水席名称');
					return false;
				};
				if (type_id=='') {
					alert('请先选择类别');
					return false;
				};

				if (menu_quantity==''||menu_quantity==undefined) {
					alert('请至少添加一个菜品');
					return false;
				};
				if (dish_id=='') {
					alert('请先添加菜品');
					return false;
				};
				if (price=='') {
					alert('每位价格不能为空');
					return false;
				};
				if (total_peoples<1) {
					alert('开席人数要大于0');
					return false;
				};
				if (banquet_number<1) {
					alert('每日最多开席数要大于0');
					return false;
				};
				if (begin_time=='') {
					alert('请先选择流水席开始时间');
					return false;
				};
				if (end_time=='') {
					alert('请先选择流水席结束时间');
					return false;
				};
				if (begin_time.substr(0,2)>end_time.substr(0,2)) {
					console.log(begin_time.substr(0,2)+':'+end_time.substr(0,2));
		    	 	alert('开启时间段不能大于关闭时间段');
		    	 	return false;
		    	 };
		    	 if (begin_time.substr(0,2)==end_time.substr(0,2)&&begin_time.substr(3)>end_time.substr(3)) {
					console.log(begin_time.substr(0,2)+':'+end_time.substr(0,2)+'----'+begin_time.substr(3)+':'+end_time.substr(3));
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
				$('#uploadForm').submit();
			});
			
      //  		/*价格，人数，总价*/
		    // $(".renshubtnj2").click(function(){
		    // 	 setageout(2);
		    	
		    // });
		    // /*价格，人数，总价*/
		    // $(".renshubtnj1").click(function(){
		    // 	 setageout(1);
		    	
		    // });
		    $(".select_class_msg").click(function(){
		    	 $('.box').css("display", "none");
		    	 $('.box_class').css("display", "block");
		    	
		    });
		    $(".sure_calss").click(function(){
		    	 $('.box').css("display", "none");
		    	 $('.box_one').css("display", "block");
		    	 
		    	
		    });

		    $(".add_show_menu").click(function(){
		    	 $('.box').css("display", "none");
		    	 $('.box_add_menu').css("display", "block");
		    	 
		    	
		    });
		    // $(".aagecaipin_add").click(function(){
		    // 	 $('.box').css("display", "none");
		    // 	 $('.box_one').css("display", "block");
		    	 
		    	
		    // });

		    $(".delete_show_menu").click(function(){
		    	 $('.box').css("display", "none");
		    	 $('.box_delete_menu').css("display", "block");
		    	 
		    	
		    });
		    $(".aagecaipin_delete").click(function(){
		    	 $('.box').css("display", "none");
		    	 $('.box_one').css("display", "block");
		    	 
		    	
		    });
		    $(".addmain_next").click(function(){
		    	var type_id = $("input[name='type_id']").val();
				var banquet_name = $("input[name='banquet_name']").val();
				var menu_quantity = $("input[name='menu_quantity[]']").val();
				var imgurl = $('.z_addImg>img').attr('src');
				if (imgurl==undefined) {
					alert('请先上传封面图');
					return false;
				};
		    	if (type_id=='') {
					alert('请先选择类别');
					return false;
				};
				if (banquet_name=='') {
					alert('请输入流水席名称');
					return false;
				};
				if (menu_quantity==''||menu_quantity==undefined) {
					alert('请至少添加一个菜品');
					return false;
				};
		    	 $('.box').css("display", "none");
		    	 $('.box_two').css("display", "block");
		    	 
		    	
		    });
			/*价格，人数，总价*/
		    // $(".renshubtnj2").click(function(){
		    // 	 setageout();
		    	
		    // })
		// 选择类型
		$('.sure_calss').click(function() {
			var type_name = $(".age").parents('.leibbtn').find('.type_name').html(); 
			var type_id = $(".age").attr('type_id'); 
			if(type_name==''){
				alert('请先选择类别');
				return false;
			}
			$("input[name='type_id']").val(type_id);
			$('.caipin_name').html(type_name);
		});
		// 添加菜品
		$(".aagecaipin_add").click(function() {
			var dish_id= $('[name="dish_id[]"]');
			if(!dish_id.is(':checked')) {
				alert('请先选择至少一项');
				return false;
			}
			var s = Array();  
			var html = '';
			var submit_html = '';
			for(var i=0; i<dish_id.length; i++){
				if(dish_id[i].checked){
					s[i] = Array();
					s[i]['dish_id'] = dish_id[i].value;
					s[i]['dish_name'] = $('.dish_id'+dish_id[i].value).parents('.dish_id_parent').find('.dish_name').html();
					s[i]['dish_price'] = $('.dish_id'+dish_id[i].value).parents('.dish_id_parent').find('.dish_price').html();
					
					$('.dish_id'+dish_id[i].value).parents('.caipinagebox').remove();
					html+='<div class="caipinagebox">';
						html+='<div class="mui-input-row mui-checkbox mui-left menu_id_parent">' ;
							html+='<input name="menu_id[]" class=menu_id'+s[i]['dish_id']+' value="'+s[i]['dish_id']+'" type="checkbox" style="top: 10px;z-index: 999;">';
							html+="<span class='cai_namge menu_name'>"+s[i]['dish_name']+"</span>";
							html+='<p class="cai_moeryjiage">￥<span class="menu_price">'+s[i]['dish_price']+'</span></p>';
						html+='</div> ';
					html+='</div>';

					submit_html+='<div class="tianjia_caipingbox  submit_menu_id'+s[i]['dish_id']+'">';
					 	submit_html+='<span class="caiage_ming cai_namgeboxsize">'+s[i]['dish_name']+'</span>';
					 	submit_html+='<span>';
					 		submit_html+="<div class='mui-numbox jainbtnan' data-numbox-step='1' data-numbox-min='1' data-numbox-max='100'>";
								submit_html+="<button onclick='reduce_num(this)' class='mui-btn mui-numbox-btn-minus jiabtnboxpage1' type='button'>-</button>";
								submit_html+='<input readonly class="mui-numbox-input shuliang" name="menu_quantity[]" type="number" value="1" />';
								submit_html+="<button class='mui-btn mui-numbox-btn-plus jiabtnboxpage2' type='button' onclick='plus_num(this)' >+</button>";
							submit_html+='</div>';
					 	submit_html+='</span>' ;
					 	submit_html+='<input type="hidden" name="dish_id[]" class="show_dish_id"  value="'+s[i]['dish_id']+'" />';
					 	submit_html+='<input type="hidden" class="price" value="'+s[i]['dish_price']+'" />';
					 	submit_html+='<span class="caiage_jiage cai_namgeboxsize">￥<label class="jiagemory">'+s[i]['dish_price']+'</label></span> ';
					 submit_html+='</div>';
				} 
			} 
			$('.delete_class').append(html);
			$('.caipinbox').append(submit_html);
			$('.box').css("display", "none");
		    $('.box_one').css("display", "block");
			savetotal_money();

		});
		// 删除菜品
		$(".aagecaipin_delete").click(function() {
			var menu_id= $('[name="menu_id[]"]');
			if(!menu_id.is(':checked')) {
				alert('请先选择至少一项');
				return false;
			}
			var s = Array();  
			var html = '';
			for(var i=0; i<menu_id.length; i++){
				if(menu_id[i].checked){
					s[i] = Array();
					s[i]['menu_id'] = menu_id[i].value;
					s[i]['menu_name'] = $('.menu_id'+menu_id[i].value).parents('.menu_id_parent').find('.menu_name').html();
					s[i]['menu_price'] = $('.menu_id'+menu_id[i].value).parents('.menu_id_parent').find('.menu_price').html();

					$('.submit_menu_id'+s[i]['menu_id']).remove();
					$('.menu_id'+menu_id[i].value).parents('.caipinagebox').remove();
					html+='<div class="caipinagebox">';
						html+='<div class="mui-input-row mui-checkbox mui-left dish_id_parent">' ;
							html+='<input name="dish_id[]" class=dish_id'+s[i]['menu_id']+' value="'+s[i]['menu_id']+'" type="checkbox" style="top: 10px;z-index: 999;">';
							html+="<span class='cai_namge dish_name'>"+s[i]['menu_name']+"</span>";
							html+='<p class="cai_moeryjiage">￥<span class="dish_price">'+s[i]['menu_price']+'</span></p>';
						html+='</div> ';
					html+='</div>';
				} 
			} 
			$('.add_class').append(html);
			savetotal_money();
		});
			
		});
		function savetotal_money(){
			var dish_id= $('.show_dish_id');
			var money_total = 0;
			var s = Array();  
			for(var i=0; i<dish_id.length; i++){
				s[i] = Array();
				s[i]['dish_id'] = dish_id[i].value;
				s[i]['dish_price'] = $('.submit_menu_id'+s[i]['dish_id']).find('.price').val();
				s[i]['shuliang'] = $('.submit_menu_id'+s[i]['dish_id']).find('.shuliang').val();
				money_total+=Math.round(s[i]['shuliang']*s[i]['dish_price']*100)/100;
			}
				$('.total_money_msg').html(money_total);
				$('.total_money').val(money_total);
		}
		/*菜品数量*单价*/
		function setAmountCount(Obj,textObj){
				var jiagemoryobj=parseFloat(Obj.parents('.tianjia_caipingbox').eq(0).find('.price').val());
				var dish_id = Obj.parents('.tianjia_caipingbox').find("input[name='dish_id[]']").val(); 
				var dish_name = Obj.parents('.tianjia_caipingbox').find(".caiage_ming").html(); 
				var shuliang = Obj.siblings("input").val(); 
				if (shuliang<1) {
					var html = '';
					$('.menu_id'+dish_id).parents('.caipinagebox').remove();
					html+='<div class="caipinagebox">';
						html+='<div class="mui-input-row mui-checkbox mui-left dish_id_parent">' ;
							html+='<input name="dish_id[]" class=dish_id'+dish_id+' value="'+dish_id+'" type="checkbox" style="top: 10px;z-index: 999;">';
							html+="<span class='cai_namge dish_name'>"+dish_name+"</span>";
							html+='<p class="cai_moeryjiage">￥<span class="dish_price">'+jiagemoryobj+'</span></p>';
						html+='</div> ';
					html+='</div>';
					$('.add_class').append(html);
					$('.submit_menu_id'+dish_id).remove();
				};
				textObj.text(Math.round(shuliang*jiagemoryobj*100)/100);
				savetotal_money();
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
	 /*人数*每位价格*/
		function setageout(){
			/*人数*/
			var renshubtnjinput=parseInt($(".renshubtnjinput").val());


		    /*单价*/
			var danjia=$(".danjaimor").val();
			var zo=Math.round(renshubtnjinput*danjia*100)/100;
			$(".jiagexiugai").children("label").text(zo);
			
		}
		function reduce_num(obj){
			// if($(obj).siblings("input").val()>1){
				var num = parseInt($(obj).siblings("input").val())-1;
				if (num<0) num=0;
				$(obj).siblings("input").val(num);
			// }
			setAmountCount($(obj),$(obj).parents('.tianjia_caipingbox').eq(0).find('.jiagemory').eq(0));
		}
		function plus_num(obj){
			var num = parseInt($(obj).siblings("input").val())+1;
			$(obj).siblings("input").val(num);
			setAmountCount($(obj),$(obj).parents('.tianjia_caipingbox').eq(0).find('.jiagemory').eq(0));
		}
		$(".jiabtnboxpage2").click(function() { 
				setAmountCount($(this),$(this).parents('.tianjia_caipingbox').eq(0).find('.jiagemory').eq(0));
			});
			$(".jiabtnboxpage1").click(function() { 
				setAmountCount($(this),$(this).parents('.tianjia_caipingbox').eq(0).find('.jiagemory').eq(0));
			}); 
		
		
		
	</script>

</html>