<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/19
 * Time: 13:53
 */
namespace common\report;

Class Daochu {
	/**
	* 导出excel表单
	** @access public static
	* @param array $head 一维数组，excel表第一行的表示
	* @param mixed $list 二维数组，对应输出的数据
	* @param mixed $filename 文件名称
	* @param mixed $cow_index 一维数组，$list中对应的二维数组下标。必须和$head长度相等
	* @author ysl
	* @return null
.	*/
    static public function daochu($head, $list ,$filename ,$cow_index)
     {
         ini_set('memory_limit','300M');
         header('Content-Type: application/vnd.ms-excel;charset=utf-8');
         $name = $filename.".xls";
         header('Content-Disposition: attachment;filename='.$name.'');
         header('Cache-Control: max-age=0');
         header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
         echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
           xmlns:x="urn:schemas-microsoft-com:office:excel"
           xmlns="http://www.w3.org/TR/REC-html40">
        <head>           
           <meta http-equiv=Content-Type content="text/html; charset=gb2312">
           <!--[if gte mso 9]><xml>
           <x:ExcelWorkbook>
           <x:ExcelWorksheets>
             <x:ExcelWorksheet>
             <x:Name></x:Name>
             <x:WorksheetOptions>
               <x:DisplayGridlines/>
             </x:WorksheetOptions>
             </x:ExcelWorksheet>
           </x:ExcelWorksheets>
           </x:ExcelWorkbook>
           </xml><![endif]-->
        </head>';
         $where = "1=1";
         // PHP文件句柄，php://output 表示直接输出到浏览器
         $fp = fopen('php://output', 'a');
         // 输出Excel列头信息
         $head = $head;
         //字符替换
         $p_new_lines = array("\r\n", "\n","\t","\r","\r\n", "<pre>","</pre>","<br>","</br>","<br/>");
         $p_change_line_in_excel_cell = '';
         echo "<table>";
         echo "<tr>";
         foreach($head as $v){
             echo "<td>".iconv('utf-8','gb2312',$v)."</td>";
         }
         echo "</tr>";
         // 逐行取出数据，节约内存
         foreach($list as $res)
         {
             echo "<tr>";
//                echo  "<td style='vnd.ms-excel.numberformat:@'>".$res['id']."</td>";
             for($i=0;$i<count($cow_index);$i++)
             {
                 echo  "<td>".iconv('utf-8', 'gb2312', $res[$cow_index[$i]])."</td>";
             }
//             echo  "<td>".iconv('utf-8', 'gb2312', $res['shop_name'])."</td>";
//             echo  "<td>".iconv('utf-8', 'gb2312', $res['region_name'])."</td>";
//             echo  "<td>".iconv('utf-8', 'gb2312', $res['banquet_orders'])."</td>";
//             echo  "<td>".iconv('utf-8', 'gb2312', $res['sales_amount'])."</td>";
//             echo  "<td>".iconv('utf-8', 'gb2312', $res['total_balnce'])."</td>";
//             echo  "<td>".iconv('utf-8', 'gb2312', $res['withdraw_amount'])."</td>";
//             echo  "<td>".iconv('utf-8', 'gb2312', $res['platform_amount'])."</td>";
//             echo  "<td>".iconv('utf-8', 'gb2312', $res['commission_rate'])."</td>";
             echo"</tr>";
         }

         echo "</table>";

     }
}