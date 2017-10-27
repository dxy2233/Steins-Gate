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
				<span>你的位置：</span><a href="javascript:window.history.back(-1)" class="label">首页分类设置</a>><label>编辑类别</label>
			</div>
		 	<!--财务管理-->
                         <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['category/add'])}" enctype="multipart/form-data"  >
			<div class="caiwuguanli">
				<div class="shagnjianname">
					<span>专题名称：<input type="text" name="category_name" id="category_name" value="{$data.category_name}" class="shagn_name_ipu" placeholder="请输入类别名称"></span> 
				</div>
				<div class="shagnjianname">
					<span>　　排序：<input type="text" name="category_sort" id="category_sort" value="{$data.category_sort}" class="shagn_name_ipu" placeholder="请输入排序数字"></span> 
				</div>
				<div class="shagnjianname">
					<span>链接地址：<input type="text" name="category_url" id="category_url" value="{$data.category_url}" class="shagn_name_ipu" placeholder="请输入链接地址"></span> 
				</div> 
			    <div class="shagnjianname" style="height: 185px;">
					<span>图片上传：
                                            <label class="file0">
                                                {if $data.category_path}
                                                    <img src="{imageurl($data.category_path)}"/>
                                                {else}
                                                    <img src="/img/shagnchuan.png"/>
                                                {/if}
                                                <input type="file" class="file1" name="category_path">
                                                
                                            </label>
                                        </span> 
				</div> 
				
				<div class="shagnjianname">
		 		   <input type="button" class="queren queren2" style="float: left;background: #1c93e6;margin-left: 93px;" value="保　存" onclick = "checkUser();">
				</div> 
			     
			    <input type="hidden" value="{$data.category_id}" name="category_id"/>
                                <input type="hidden" name="_csrf" value="{Yii::$app->request->csrfToken}">
			</div>
		 	</form>
		 </div>
	  
	</body>
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script src="/js/jQuery-jcDate.js"></script>
<script>
    function checkUser(){
       var category_name = document.getElementById("category_name").value;
       var category_urll = document.getElementById("category_url").value;
       var ok = false;

       var data = {};
       data._csrf = '{Yii::$app->request->csrfToken}';
       data.category_name = category_name;
       data.category_id = '{$data.category_id}';

//       return false;
       if(category_name == ""  ){
         alert("专题名称不能为空");
         return false;
       }
       if(category_urll == ""  ){
        alert("链接地址不能为空");
         return false;
       }
        $.post('/category/category/check-name',data,function(result){
//           console.log(result);
            if(result.code == 0)
            {
                alert("专题名称不能重复！");
            }
            else {
                document.getElementById("formid").submit();
            }
        },'json');


    }
</script>
</html>
