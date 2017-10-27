<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="/css/index.css" />
        <link rel="stylesheet" href="/css/jcDate.css" />

</head>
<body>
<div class="combox">
       <!--所在位置显示-->
       <div class="weizhixianshi">
               <span>你的位置：</span><label>财务管理</label>
       </div>
       <!--财务管理-->
       <div class="caiwuguanli">
            <form id="formid" method = "post"  action = "{yii\helpers\Url::to(['account/index'])}" >
               <div class="shagnjianname">
                   <span>商家名称：<input type="text" class="shagn_name_ipu" id="name" name="name" value="{$post.name}" placeholder="请输入商家名称"></span>
                       <span style="margin-right: 0px;">地区筛选：
                               <span class="info"> 
                                       <label>
                                               {if empty($post.s_province)}
                                                   <script type="text/javascript">
                                                          window.onload=function () {
                                                              $('#s_province').trigger("change");
                                                          }
                                                   </script>
                                               {elseif !empty($post.s_city)}
                                                   <script type="text/javascript">
                                                              window.onload=function () {
                                                                  $('#s_city').trigger("change");
                                                              }
                                                    </script>
                                                {elseif !empty($post.s_county)}
                                                   <script type="text/javascript">
                                                              window.onload=function () {
                                                                  $('#s_city').trigger("change");
                                                              }
                                                       </script>
                                               {/if}

                                               <select id="s_province" name="s_province" onchange="gradeChange()">
                                                   <option value="">全部</option>
                                                   {foreach from=$level item=$val}
                                                       <option value="{$val.region_code}" {if $post.s_province}{if $val.region_code == $post.s_province } selected {/if}{else}{/if}>{$val.region_name}</option>
                                                   {/foreach}
                                               </select>

                                               <select id="s_city" name="s_city" onchange="gradeChangetwo()">
                                                   <option value="">请选择</option>
                                                   {foreach from=$parent_code_one item=$val}
                                                       <option value="{$val.region_code}" {if $val.region_code == $post.s_city } selected {/if}>{$val.region_name}</option>
                                                   {/foreach}
                                               </select>
                                               <select id="s_county" name="s_county">
                                                   <option value="">请选择</option>
                                                   {foreach from=$parent_code_two item=$val}
                                                       <option value="{$val.region_code}" {if $val.region_code == $post.s_county } selected {/if}>{$val.region_name}</option>
                                                   {/foreach}
                                               </select>
                                       </label>
                                       <label id="show"></label>
                               </span>
                       </span>
                       <span>
                               起止日期：
                               <input class="jcDate" name="add_time_begin" id="add_time_begin" value="{$post.add_time_begin}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
                               <label>-</label>
                               <input class="jcDate" name="add_time_end" id="add_time_end" value="{$post.add_time_end}" style="width:120px; height:20px; line-height:20px; padding:4px;border: none;border: 1px solid #ccc;" />
                       </span>
               </div>
               <input type="hidden" name="_csrf" id="csrf" value="{Yii::$app->request->csrfToken}">
               <div class="shagnjianname"> 
                       <button class="xinzen_dianpu" style="background: #1c93e6;float: right;margin-right: 25px;">搜　索</button>
                   <input class="xinzen_dianpu" id="btn_export" style="background: #1c93e6;float: right;margin-right: 25px;" value="导出"/>
                       <a href="{yii\helpers\Url::to(['account/shenqingtixian'])}" class="xinzen_dianpu" style="float: right;margin-right: 25px;">审核提现申请</a> 
               </div>
           </form>

               <!--搜索表单-->
               <div class="suoshoubiaosdan">
                       <div class="gongshi">共搜索到<span>{$page.count}</span>条数据</div>
                       <table class="gongsuou index5_cente" cellpadding="0" cellspacing="0">
                                 <tr class="biaoticaiwu">
                                               <td>订单汇总：<span>{if $list.banquet_orders}{$list.banquet_orders}{else}0{/if}</span></td>
                                               <td>销售额汇总：<span>{if $list.sales_amount}{$list.sales_amount}{else}0{/if}元</span></td>
                                               <td>账户余额汇总：<span>{if $list.total_balnce}{$list.total_balnce}{else}0{/if}元</span></td>
                                               <td>已提现汇总：<span>{if $list.withdraw_amount}{$list.withdraw_amount}{else}0{/if}元</span></td>
                                               <td>平台佣金汇总：<span>{if $list.platform_amount}{$list.platform_amount}{else}0{/if}元</span></td> 
                                 </tr>

                                 <tr class="gong_nav">
                                         <td class="lefttalbe">商家名称</td>
                                         <td>地区</td>
                                         <td>席单总数</td>
                                         <td>销售总额</td>
                                         <td>账户余额</td>
                                         <td>已提现总额 </td>
                                         <td>平台佣金 </td>
                                         <td>当前分佣比例（%） </td>

                                 </tr>
                                 <tbody>
                                     {if $data}
                                    {foreach from=$data item=$val}
                                        <tr>
                                               <td>{$val.shop_name}</td>
                                               <td>{$val.region_name}</td>
                                               <td>{$val.banquet_orders}</td>
                                               <td>{$val.sales_amount}</td>
                                               <td>{$val.total_balnce}</td>
                                               <td>{$val.withdraw_amount}</td>
                                               <td>{$val.platform_amount}</td>
                                               <td>{$val.commission_rate}</td> 
                                        </tr> 
                                    {/foreach}
                                    {/if}
                                 </tbody> 
                       </table>
                        <!--分页-->
                     <div class="fenye">
                                        <form enctype="multipart/form-data" action="{\yii\helpers\Url::to(['/account/account/index'])}" method="get">
                                                <div class="fenye_conbox">
                                                        <div class="fenye_titile">
                                                                显示<span>{$page.pagestart}-{$page.pageend}</span>条记录，共<span>{$page.count}</span>条记录<label>　|　</label>
                                                                <a href="{\yii\helpers\Url::to(['/account/account/index'])}">首页</a>
                                                                <a href="{\yii\helpers\Url::to(['/account/account/index','page'=>$page.page-1])}">上一页</a>
                                                                <a href="{\yii\helpers\Url::to(['/account/account/index','page'=>$page.page+1])}">下一页</a>
                                                                <a href="{\yii\helpers\Url::to(['/account/account/index','page'=>10000])}">尾页</a>
                                                                <input name="page" type="text" class="text" />
                                                                <input type="submit" value="跳 转" class="tiaozhuan" />
                                                        </div>
                                                </div>
                                        </form>
                                    </div>

               </div>


       </div>

</div>
</body>
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script src="/js/jQuery-jcDate.js"></script>
<script src="/js/gradeChange.js"></script>

<script>
    $(function (){
        $(".jcDate").jcDate({					       
                        IcoClass : "jcDateIco",
                        Event : "click",
                        Speed : 100,
                        Left : 0,
                        Top : 28,
                        format : "-",
                        Timeout : 100
        });
    });
    $("#btn_export").click(function() {
        if(!confirm("确认要导出吗？")){ 
            return false; 
        }
            var data={};
            var name = $('#name').val();
            var s_province = $('#s_province').val();
            var s_city = $('#s_city').val();
            var s_county = $('#s_county').val();
            var add_time_begin = $('#add_time_begin').val();
            var add_time_end = $('#add_time_end').val();
            data.name=name;
            data.s_province=s_province;
            data.s_city=s_city;
            data.s_county=s_county;
            data.add_time_begin=add_time_begin;
            data.add_time_end=add_time_end;
            window.location.href='/account/account/daochu?name='+name+'&s_province='+s_province+'&s_city='+s_city+'&s_county='+s_county+'&add_time_begin='+add_time_begin+'&add_time_end='+add_time_end;

//             $.ajax({
//                url:'/account/account/export',
//                type:'POST',
//                data:data,
//                jsonType:'json',
//                success:function(res){
//                   console.log(res);
//                }
//            });
    });
</script>
</html>
