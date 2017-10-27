<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
		<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
		<style type="text/css">
			#panel {
				position: absolute;
				background-color: white;
				max-height: 90%;
				overflow-y: auto;
				top: 10px;
				right: 10px;
				width: 280px;
			}
		</style>
		<script src="http://cache.amap.com/lbs/static/es5.min.js"></script>
		<script src="http://webapi.amap.com/maps?v=1.3&key=17ef230cbfa459ceda1d40d8934bd5ee&plugin=AMap.Geocoder&AMap.DistrictSearch"></script>
		<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
		<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
	</head>
	<body>
	<div id="divCenter" onclick="picClose()" align="center">
		<img src=""/>
	</div>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><a href="javascript:window.history.back(-1)" class="label">商家管理</a>><label>新增商家</label>
			</div>
		 	<!--编辑-->
			 <form  enctype="multipart/form-data" action="{yii\helpers\Url::to(['shop/edit'])}" method="post">
			 <input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}"/>
			  <input type="hidden" name="shop_id" value="{$arr.shop_id}"/>
		 	<div class="shagnjai_bianji">
		 		<div class="bianji_left">
		 			<div class="input_bainji">
		 				<span>商家名称：</span>
		 				<input name="shop_name" type="text" placeholder="请输入商家名称" value="{$arr.shop_name}" />
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 			</div>
		 			<div class="input_bainji">
		 				<span>商家端登录账号：</span>
		 				<input name="shop_user" type="text" placeholder="请输入登录账号" value="{$arr.shop_user}" />
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 			</div>
					<div class="input_bainji">
						<span>密码：</span>
						<button type="button" class="congzhipwd">重置密码</button>
					</div>
		 			<div class="input_bainji">
		 				<span>店主姓名：</span>
		 				<input name="merchant_name" type="text" placeholder="请输入姓名" value="{$arr.merchant_name}" />
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 			</div>
		 			<div class="input_bainji">
		 				<span>手机号：</span>
		 				<input name="merchant_mobile" type="text" placeholder="请输入手机号" value="{$arr.merchant_mobile}" />
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 			</div>
		 			<div class="input_bainji">
		 				<span>商家面积：</span>
		 				<input name="merchant_area" type="text" placeholder="请输入商家面积" value="{$arr.merchant_area}" />
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 			</div>
		 			<div class="input_bainji">
		 				<span>座位数：</span>
		 				<input name="merchant_seats" type="text" placeholder="请输入座位数" value="{$arr.merchant_seats}" />
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 			</div>
		 			<div class="input_bainji" style="margin-bottom: 10px;">
		 				<span>分佣比例：</span>
		 				<input name="commission_rate" type="text" value="{$arr.commission_rate}"  placeholder="请输入分佣比例" style="width: 100px;" />
		 				<label>%</label>
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 			</div>
		 			<div class="input_bainji">
		 				<span></span> 
		 				<label class="shuomin">说明：已完成的订单，平台将按照销售额（扣除红包前的销售额）*分佣比例的数额收取佣金，剩余的金额转入商家端的钱包余额</label>
		 				 
		 			</div>
					<div class="input_bainji">
						<span class="fl">营业执照：</span>
						<div class="upload-skin">
                            {if $arr.business_license_path}
								<a href="javascript:void(0)" onclick="picBig($(this).children('img').attr('src'))"><img src="{$arr.business_license_path}" alt="" class="upload"></a>
                            {else}
								<a href="javascript:void(0)" onclick="picBig($(this).children('img').attr('src'))"><img src="" alt="" class="upload"></a>
                            {/if}
							<div class="upload-info">
								<button type="button" onclick="document.getElementById('upload-btn1').click()">上传文件</button>
								<input type="file" name="business" onchange="upload1()" id="upload-btn1" style=" visibility: hidden; position: absolute;">
									<img class="upload-star" src="/img/xinhao_icon.png"/>
								<label class="check"></label>

								<label class="shuomin">支持扩展名：.BMP .JPEG .JPG .PNG</label>
							</div>
						</div>
					</div>
					<div class="input_bainji">
						<span>卫生许可证：</span>
						<div class="upload-skin">
                            {if $arr.food_license_path}
							<a href="javascript:void(0)" onclick="picBig($(this).children('img').attr('src'))"><img src="{$arr.food_license_path}" alt="" class="upload"></a>
                            {else}
								<a href="javascript:void(0)" onclick="picBig($(this).children('img').attr('src'))"><img src="" alt="" class="upload"></a>
                            {/if}
							</img>
							<div class="upload-info">
								<button type="button" onclick="document.getElementById('upload-btn2').click()">上传文件</button>
								<input type="file" name="hygienic" onchange="upload2()" id="upload-btn2" style="visibility: hidden; position: absolute;">
									<img class="upload-star" src="/img/xinhao_icon.png"/>
								<label class="check"></label>
								<label class="shuomin">支持扩展名：.BMP .JPEG .JPG .PNG</label>
							</div>
						</div>
					</div>
		 		</div>
		 		<div class="bianji_right">
		 			<div class="input_bainji">
		 				<span>联系电话：</span>
		 				<input name="merchant_telphone" type="text" placeholder="请输入联系电话" value="{$arr.merchant_telphone}" />
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 				<label class="zhanshi">对用户展示</label>
		 			</div>
		 			<div class="input_bainji">
		 				<span>商家地址：</span>
						<span class="info" style="width: auto">
                                       <label>
                                               <select style="width: auto" id="s_province" name="s_province" onchange="gradeChange()">
                                                   {foreach from=$city.level item=$val}
													   <option value="{$val.region_code}" {if $post.s_province}{if $val.region_code == $post.s_province } selected {/if}{else}{/if}>{$val.region_name}</option>
                                                   {/foreach}
												   <select>

                                               <select style="width: auto" id="s_city" name="s_city" onchange="gradeChangetwo()">
                                                   {foreach from=$city.parent_code_one item=$val}
													   <option value="{$val.region_code}" {if $val.region_code == $post.s_city } selected {/if}>{$val.region_name}</option>
                                                   {/foreach}
												   <select>
                                               <select style="width: auto" id="s_county" name="s_county">
                                                   {foreach from=$city.parent_code_two item=$val}
													   <option value="{$val.region_code}" {if $val.region_code == $post.s_county } selected {/if}>{$val.region_name}</option>
                                                   {/foreach}
												   <select>
                                       </label>
                                       <label id="show"></label>
                               </span>
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
		 				<label class="zhanshi">对用户展示</label>
		 			</div>
		 			<div class="input_bainji">
		 				<span>详细地址：</span>
		 				<input type="text" id="keyword" name="address" value="{$arr.address}" placeholder="请输入详细地址" style="width: 380px;" />
		 				<label><img src="/img/xinhao_icon.png"/></label>
						<label class="check"></label>
						<button onclick="sousuo()" type="button">搜索</button>
		 			</div>
		 			<div class="input_bainji">
		 				<span>地址经纬度：</span>
		 				<input type="text" id="lnglat_lng" name="shop_lng" value="{$arr.shop_lng}" placeholder="请输入经纬度" style="width: 123px;" /><label>　 </label>
		 				<input type="text" id="lnglat_lat" name="shop_lat" value="{$arr.shop_lat}" placeholder="请输入经纬度" style="width: 123px;" />
		 			</div>
		 			<div class="input_bainji">
						<span></span>
		 				<div class="ditu" id="container"></div>
						<div id="panel"></div>
		 			</div>
		 			<div class="input_bainji">
		 				<span>商家状态：</span>
		 				<input type="radio"  name="shop_status" value="1" {if $arr.shop_status eq 0}{else}checked="checked"{/if}  style="width: auto;height: auto;" /><label class="zhaugntia">启用</label><label>　</label>
		 				<input type="radio" name="shop_status" value="0"  {if $arr.shop_status eq 0}checked="checked"{/if} style="width: auto;height: auto;"  /><label class="zhaugntia">停用</label>
		 			</div> 
		 		</div> 
		 	</div>
		 	
		 	<!--确认修改-->
		 	<div class="querenxiugai">
		 		<input type="submit" value="确认修改" class="queren" />
		 	</div>
				 <!--弹框-->
				 <div class="tankuang_xiugai">
					 <div class="tiank_name">重置密码</div>
					 <div class="tiank_xiugai_jine">是否重置为默认密码：123456</div>

					 <div class="tankuagn_btn">
						 <input type="button" value="确认" class="tan_queren" />
						 <input type="button" value="取消" class="tan_quxiao" />
					 </div>
				 </div>

			 </form>
		 </div>

		 <script>
             $(function(){
                 $(".congzhipwd").click(function(){
                     $(".tankuang_xiugai").show();
                 });
                 $(".tan_quxiao").click(function(){
                     $(".tankuang_xiugai").hide();
                 });
                 $(".tan_queren").click(function(){
                     $.get('{\yii\helpers\Url::to(['/shop/shop/repassword','id'=>$arr.shop_id])}',
                         function(data)
                         {
                             $(".tankuang_xiugai").hide();
                         },'json')
                 });

             })
             var map = new AMap.Map('container', {
                 resizeEnable: true,
                 doubleClickZoom: false,
                 zoom: 13
             });
             AMap.service(["AMap.PlaceSearch"], function() {
                 var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                     pageSize: 5,
                     pageIndex: 1,
                     city: "010", //城市
                     map: map,
                     panel: "panel"
                 });

             });
             function sousuo()
             {
                 var name=document.getElementById("keyword").value;
                 var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                     pageSize: 1,
                     pageIndex: 1,
                     city: "010", //城市
                     map: map,
                     panel: "panel"
                 });
                 //关键字查询
                 placeSearch.search(name);
             }
             // AMap.Marker.on('click',function(e)
             // {
             // 	 console.log("我大概是进来了");
             // });
             //点标记点击事件
             //  AMap.event.addListener(_marker,'click',function(e){
             //     console.log("我大概是进来了");
             //  });
             //  {
             //  	AMap.event.addListener(placeSearch, "markerClick", function(e){
             //       console.log(e.data.location);//当前marker的经纬度信息
             //
             //      console.log( e.data.address);//获取当前marker的具体地址信息
             //      console.log(e.data);//则是包含所有的marker数据
             //
             //  }
             //  }
             //地图初始化的时候是否自带坐标使用
             map.setCity('重庆');
//             var xy=[106.538141,29.576683];
//             regeocoder(xy);

             //为地图注册click事件获取鼠标点击出的经纬度坐标
             var clickEventListener = map.on('click', function(e) {
//      document.getElementById("lnglat").value = e.lnglat.getLng() + ',' + e.lnglat.getLat();
                 document.getElementById("lnglat_lng").value = e.lnglat.getLng();
                 document.getElementById("lnglat_lat").value = e.lnglat.getLat();
                 var x=e.lnglat.getLng();
                 var y=e.lnglat.getLat();
                 var xy=[x,y];
                 map.clearMap();
                 regeocoder(xy);

             });
//             AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
//             function select(e) {
//                 if (e.poi && e.poi.location) {
//                     map.setZoom(15);
//                     map.setCenter(e.poi.location);
//                 }
//             }
             //逆地理编码
             function regeocoder(xy) {  //逆地理编码
                 var geocoder = new AMap.Geocoder({
                     radius: 1000,
                     extensions: "all",
                 });
                 geocoder.getAddress(xy, function(status, result) {
                     if (status === 'complete' && result.info === 'OK') {
                         geocoder_CallBack(result);
                     }
                 });

                 var marker = new AMap.Marker({  //加点
                     map: map,
                     position: xy
                 });
                 map.setFitView();
             }
             function geocoder_CallBack(data) {
                 var address = data.regeocode.formattedAddress; //返回地址描述
                 document.getElementById("keyword").value = address;
             }
             //根据行政区来进行划分

		 </script>
	</body>
	<script src="/js/gradeChange.js"></script>
	<script src="/js/check.js"></script>
</html>
