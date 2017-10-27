<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="/css/index.css" />
		<link rel="stylesheet" href="/css/jcDate.css" />
		<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	</head>
	<body>
		 <div class="combox">
		 	<!--所在位置显示-->
			<div class="weizhixianshi">
				<span>你的位置：</span><a href="{yii\helpers\Url::to(['account/index'])}" class="label">财务管理</a>><label>审核商家提现申请</label>
			</div>
		 	<!--财务管理-->
                        <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['account/shenqingtixian'])}" >
			<div class="caiwuguanli">
				<div class="shagnjianname">
					<span>商家名称：<input type="text" name="name" value="{$post.name}" class="shagn_name_ipu" placeholder="请输入商家名称"></span>
					<span>
						申请提现日期：
						<input class="jcDate" name="add_time_begin" value="{$post.add_time_begin}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
						<label>-</label>
						<input class="jcDate" name="add_time_end" value="{$post.add_time_end}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
					</span>
					<span style="margin-right: 0px;">审核状态：
                                            <select class="zhaugntai" name="request_status">
                                                <option value="0">全部状态</option>
                                                <option value="1" {if $post.request_status == 1}selected{/if}>申请中</option>
                                                <option value="2" {if $post.request_status == 2}selected{/if}>审核通过</option>
                                                <option value="3" {if $post.request_status == 3}selected{/if}>审核未通过</option>
                                            </select>
                                        </span>
                                        <input type="hidden" name="_csrf" id="csrf" value="{Yii::$app->request->csrfToken}">
					<input type="submit"  class="xinzen_dianpu" style="background: #1c93e6;margin-right: 0px;" value="搜 索">
				</div>
				</form>
				
				<!--搜索表单-->
				<div class="suoshoubiaosdan">
					<div class="gongshi">共搜索到<span>{$page.count}</span>条数据
					<input class="xinzen_dianpu export_Withdrawals" style="background: #1c93e6;margin-right: 0px;" value="导 出">
					<script type="text/javascript">
						$('.export_Withdrawals').click(function () {
							var	name =$('input[name="name"]').val();
							var	add_time_begin =$('input[name="add_time_begin"]').val();
							var	add_time_end =$('input[name="add_time_end"]').val();
							var	request_status =$('select[name="request_status"] option:selected').val();
                            window.location.href='/account/account/export-withdrawals?name='+name+'&add_time_begin='+add_time_begin+'&add_time_end='+add_time_end+'&request_status='+request_status;
						});
					</script>
					</div>
					<table class="gongsuou" cellpadding="0" cellspacing="0"> 
						  <tr class="gong_nav">
						  	  <td class="lefttalbe">商家名称</td>
						  	  <td>店主手机号</td>
						  	  <td>申请提现金额</td>
						  	  <td>状态</td>
						  	  <td>申请日期 </td>
                                                          <td>审核日期 </td>
						  	  <td>操作者 </td>
						  	  <td>操作</td>
						  	   
						  </tr>
						  <tbody> 
                                                        {foreach from=$data item=$val}
						  	<tr>
                                                            <td>{$val.shop_name}</td>
                                                            <td>{$val.merchant_mobile}</td>
                                                            <td>￥{$val.request_amount}</td>
                                                            <td>
                                                                {if $val.request_status == 0}
                                                                    待审核
                                                                {else if $val.request_status == 1}
                                                                    审核通过
                                                                {else if $val.request_status == 2}
                                                                    审核未通过
                                                                {/if}
                                                            </td>
                                                            <td>{date('Y-m-d H:i:s',$val.request_time)}</td>
                                                            <td>{if $val.update_time}{date('Y-m-d H:i:s',$val.update_time)}{/if}</td>
                                                            <td>{$val.user_name}</td>
                                                            <td>
                                                                {if $val.request_status == 0}
                                                                    <a href="#" onclick="xianshi('{$val.withdraw_name}','{$val.bank_account}','{$val.withdraw_bank}');">查看　</a>
                                                                    <a onClick="return confirm('确认要通过？')" href="{yii\helpers\Url::to(['account/adopt'])}?request_id={$val.request_id}">通过　</a>
                                                                    <a  href="#" onclick="jujue('{$val.request_id}')">拒绝　</a>
                                                                {else}
                                                                    <a href="#" onclick="xianshi('{$val.withdraw_name}','{$val.bank_account}','{$val.withdraw_bank}');">查看　</a>
                                                                {/if}
                                                            </td> 
						  	</tr> 
						  	{/foreach}
						  </tbody> 
					</table>
					 <!--分页-->
			 	    <div class="fenye">
						<form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/account/account/shenqingtixian'])}" method="get">
						{if !empty(post)}
                            {foreach from=$post item=post_info key=post_info_key}
								<input type="hidden" name="post[{$post_info_key}]" value="{$post_info}"/>
                            {/foreach}
                        {/if}
			 	    	<div class="fenye_conbox">
			 	    		<div class="fenye_titile">
			 	    			显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
			 	    			<a href="{\yii\helpers\Url::to(['/account/account/shenqingtixian','post'=>$post])}">首页</a>
								<a href="{\yii\helpers\Url::to(['/account/account/shenqingtixian','post'=>$post,'page'=>$page.page-1])}">上一页</a>
								<a href="{\yii\helpers\Url::to(['/account/account/shenqingtixian','post'=>$post,'page'=>$page.page+1])}">下一页</a>
								<a href="{\yii\helpers\Url::to(['/account/account/shenqingtixian','post'=>$post,'page'=>10000])}">尾页</a>
			 	    		    <input name="page" type="text" class="text" />
			 	    		    <input type="submit" value="跳 转" class="tiaozhuan" />
			 	    		</div>
			 	    	</div>
						</form>
					</div>
				</div> 
			</div>
		 
		    <!--弹框-->
			 <div class="tankuang_xiugai">
			 	<div class="tiank_name">银行卡信息</div>
			 	<div class="tiank_xiugai_jine">姓　名：<span id="withdraw_name"></span></div>
			 	<div class="tiank_xiugai_jine">银行卡号：<span id="bank_account"></span></div>
			 	<div class="tiank_xiugai_jine">开 户 行：<span id="withdraw_bank"></span></div>
			 	<!--拒绝理由-->
			 	<textarea class="jujue_textrer"></textarea>
			 	<div class="tankuagn_btn">
			 		<input type="submit" value="确认" class="tan_queren " onclick="quxiao();"/>
			 		<input type="submit" value="取消" class="tan_quxiao" onclick="quxiao();" />
			 	</div> 
			 </div>
			 <!--拒绝弹框-->
                         <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['account/refuse'])}" >
			 <div class="tankuang_xiugai1">
			 	<div class="tiank_name">拒绝</div>
			 	<div class="tiank_xiugai_jine jujue">拒绝理由：</div> 
			 	<!--拒绝理由-->
			 	<textarea class="jujue_textrer" name="content"></textarea>
			 	<div class="tankuagn_btn tankuagn_btn1">
			 		<input type="submit" value="确认" class="tan_queren" />
			 		<input type="" value="取消" class="tan_quxiao" onclick="quxiao();" />
			 	</div> 
			 </div>
                         <input type="hidden" name="_csrf" id="csrf" value="{Yii::$app->request->csrfToken}">
                         <input type="hidden" name="request_id" id="request_id" value="">
			</form>
		 </div>
	  
	</body>
	<script src="/js/jQuery-jcDate.js"></script>
	<script>
		$(function() {  
			$(".jcDate").jcDate({
				IcoClass: "jcDateIco",
				Event: "click",
				Speed: 100,
				Left: 0,
				Top: 28,
				format: "-",
				Timeout: 100
			});
			
			var Gid = document.getElementById;

			var showArea = function() {

				Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" +

					Gid('s_city').value + " - 县/区" +

					Gid('s_county').value + "</h3>"

			} 
			
		});
		function xianshi(withdraw_name,bank_account,withdraw_bank){
                                $('#withdraw_name').html(withdraw_name);
                                $('#bank_account').html(bank_account);
                                $('#withdraw_bank').html(withdraw_bank);
				$(".tankuang_xiugai").show();
				$(".jujue_textrer").hide();
				$(".tankuang_xiugai1").hide(); 
				
			}
		
		function quxiao(){
				 $(".tankuang_xiugai").hide(); 
				$(".tankuang_xiugai1").hide(); 
				 
			}
		/*拒绝*/
		function jujue(id){
                                $('#request_id').val(id);
				$(".tankuang_xiugai1").show(); 
				$(".jujue_textrer").show();
		}
			 
		
	</script>
</html>
