<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
		<link rel="stylesheet" href="/css/jcDate.css" />
		<style>
			input[type="file"] {
			  color: transparent;
			}
		</style>
	</head>
	<body>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><a href="javascript:window.history.back(-1)" class="label">首页轮播图管理</a>><label>添加轮播图</label>
			</div>
		 	<!--财务管理-->
                        <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['banner/add'])}" enctype="multipart/form-data" onsubmit = "return checkUser();" >
			<div class="caiwuguanli">
				<div class="shagnjianname">
					<span>类别名称：<input type="text" id="carousel_descprtion" value="{if $data.carousel_descprtion}{$data.carousel_descprtion}{/if}" name="carousel_descprtion" class="shagn_name_ipu" placeholder="请输入类别名称"></span> 
				</div>
				<div class="shagnjianname">
					<span>排序：<input type="text" name="class_sort" value="{if $data.class_sort}{$data.class_sort}{/if}" class="shagn_name_ipu" placeholder="请输入排序数字"></span> 
				</div>
				<div class="shagnjianname">
					<span>链接地址：<input type="text" id="carousel_url" value="{if $data.carousel_url}{$data.carousel_url}{/if}" name="carousel_url" class="shagn_name_ipu" placeholder="请输入链接地址"></span> 
				</div> 
			    <div class="shagnjianname" style="height: 185px;">
					<span>图片上传：
                                            
                                            <label class="file0">
                                                {if $data.carousel_path}
                                                    <img src="{imageurl($data.carousel_path)}"/>
                                                {else}
                                                    <img src="/img/shagnchuan.png"/>
                                                {/if}
                                                <input type="file" class="file1" name="carousel_path">
                                            </label>
                                                
                                        </span> 
				</div> 
				<div class="shagnjianname">
					<span>是否显示：<input style="cursor: pointer;" {if $data.is_display == 1}checked="checked"{/if} name="is_display"  value="1"  type="radio"><label style="font-size: 14px;">是</label>　<input style="cursor: pointer;" name="is_display" type="radio"  value="0" {if $data.is_display == 0}checked="checked"{/if}><label style="font-size: 14px;">否</label> </span> 
				</div>
				<div class="shagnjianname">
		 		   <input type="submit" class="queren queren2"  style="float: left;background: #1c93e6;margin-left: 93px;" value="确认添加">
				</div> 
                                <input type="hidden" value="{$data.carousel_id}" name="carousel_id"/>
                                <input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}">
			</div>
		 	</form>
		 </div>
	  
	</body>
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script src="/js/jQuery-jcDate.js"></script>
	<script>
    function checkUser(){
       var Carousel_descprtion = document.getElementById("carousel_descprtion").value;
       var Carousel_urll = document.getElementById("carousel_url").value;

       if(Carousel_descprtion == ""  ){
         alert("名称不能为空");
         return false;
       }
       if(Carousel_urll == ""  ){
        alert("链接地址不能为空");
         return false;
       }
      document.getElementById("formid").submit();
    }
	</script>
</html>
