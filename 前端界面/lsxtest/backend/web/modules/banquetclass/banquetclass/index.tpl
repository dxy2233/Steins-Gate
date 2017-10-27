<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
	</head>
	<body style="width: 100%;height: 100%;background: url(img/bg.png) no-repeat right;background-position-y: -170px;">
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><label>流水席类别设置</label>
			</div>
			<!--流水席类别设置-->
		 	<div class="shagnjiachakan">
		 		<div class="chakntongji" style="width: 100%;border-bottom: none;">
		 			<div class="shagnjiaqiben" style="margin-bottom: 20px;"><a href="#" class="xinzen_dianpu" style="float: right;background: #1c93e6;">添加类别</a></div>
		 			<table class="gongsuou" cellpadding="0" cellspacing="0" >
						  <tr class="gong_nav">
						  	  <td class="lefttalbe">类别</td>
						  	  <td>排序</td> 
						  	  <td class="righttalble">操作</td> 
						  </tr>
						  <tbody> 
                                                        {foreach from=$data item=$val}
						  	 <tr>
						  	 	<td>{$val.type_name}</td>
						  	 	<td>{$val.type_sort}</td> 
						  	 	<td class="taibcloor" style="cursor: pointer;" onclick="taibcloor('{$val.type_id}','{$val.type_name}','{$val.type_sort}','{$val.type_path}','{$val.type_url}')">编辑</td>
						  	 </tr> 
						  	{/foreach} 
						  </tbody> 
					</table>
					 <!--分页-->
			 	    <div class="fenye">
                                        <form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/banquetclass/banquetclass/index'])}" method="get">
                                                <div class="fenye_conbox">
                                                        <div class="fenye_titile">
                                                                显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
                                                                <a href="{\yii\helpers\Url::to(['/banquetclass/banquetclass/index'])}">首页</a>
                                                                <a href="{\yii\helpers\Url::to(['/banquetclass/banquetclass/index','page'=>$page.page-1])}">上一页</a>
                                                                <a href="{\yii\helpers\Url::to(['/banquetclass/banquetclass/index','page'=>$page.page+1])}">下一页</a>
                                                                <a href="{\yii\helpers\Url::to(['/banquetclass/banquetclass/index','page'=>10000])}">尾页</a>
                                                                <input name="page" type="text" class="text" />
                                                                <input type="submit" value="跳 转" class="tiaozhuan" />
                                                        </div>
                                                </div>
                                        </form>
                                    </div>
		 		</div>  
		 	</div> 
		 	<!--弹框-->
                        <form id="formid" method = "post" enctype="multipart/form-data"  action = "{yii\helpers\Url::to(['banquetclass/banquetadd'])}" onsubmit = "return checkUser();" >
			 <div class="tankuang_xiugai">
			 	<div class="tiank_name">编辑类别</div>
		 	    <div class="tiank_xiugai_jine">类别名称:<input type="text" class="in_jine" name="type_name" id="type_name"><label> <img src="/img/xinhao_icon.png"/></label></div>
                            <div class="tiank_xiugai_jine">连接地址:<input type="text" class="in_jine" name="type_url" id="type_url"><label></label></div>
                             <div class="shagnjianname" style="height: 185px;top: 12px;">
					<span>图片上传：
                                            <label class="file0">
                                                    <img src="/img/shagnchuan.png" id="img"/>
                                                <input type="file" class="file1" name="type_path">
                                            </label>
                                                
                                        </span> 
				</div> 
		 	    <div class="tiank_xiugai_jine paixu">排序:<input type="text" style="width: 64px;" name="type_sort" id="type_sort" class="in_jine"><label class="zisufanwei"> 字数范围0~255，数字越小越靠前</label></div>
                            
			 	<div class="tankuagn_btn" style="top: -20px;">
			 		<input type="submit" value="确认" class="tan_queren" />
			 		<input type="" value="取消" class="tan_quxiao" />
			 	</div> 
			 </div> 
                         <input type="hidden" name="_csrf" id="csrf" value="{Yii::$app->request->csrfToken}">
                         <input type="hidden" name="type_id" id="type_id" value="">
		 	</form>
		 	
		 </div> 
	</body>
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js" ></script>
<script>
        $(function(){ 
                var i=$(".in_jine").val(); 
                $(".shagnjiaqiben").click(function(){
                        $(".tiank_name").text("添加类别");
                        $(".tankuang_xiugai").show();
                        $('#type_id').val('');
                        $('#type_name').val('');
                        $('#type_sort').val('');
                        $('#type_url').val('');
                        var element = document.getElementById('img');
                        element.src = "/img/shagnchuan.png";
                });


                $(".tan_quxiao").click(function(){
                        $(".tankuang_xiugai").hide(); 
                });

        })
    function taibcloor(id,name,sort,path,url){
            $('#type_id').val(id);
            $('#type_name').val(name);
            $('#type_sort').val(sort);
            $('#type_url').val(url);
            var element = document.getElementById('img');
            if(path != '' ){ 
                element.src = path;
            }else{
                element.src = "/img/shagnchuan.png";
            }
            $(".tiank_name").text("编辑类别");
            $(".tankuang_xiugai").show();  
    }
    function checkUser(){
       var type_name = document.getElementById("type_name").value;

       if(type_name == ""  ){
         alert("名称不能为空");
         return false;
       }
      document.getElementById("formid").submit();
    }		
	</script>

</html>
