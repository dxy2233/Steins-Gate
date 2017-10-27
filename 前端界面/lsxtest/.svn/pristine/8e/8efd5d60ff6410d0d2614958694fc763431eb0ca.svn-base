<?php
 $data = file_get_contents('php://input');

//$data = '<xml><appid><![CDATA[wxb6548c05943dc4a3]]></appid>
//<attach><![CDATA[{"order_id":"1","banquet_id":"1","price":"0.01","number":"1","surplus":"","user_id":6}]]></attach>
//<bank_type><![CDATA[CFT]]></bank_type>
//<cash_fee><![CDATA[1]]></cash_fee>
//<fee_type><![CDATA[CNY]]></fee_type>
//<is_subscribe><![CDATA[Y]]></is_subscribe>
//<mch_id><![CDATA[1489372972]]></mch_id>
//<nonce_str><![CDATA[t2o13ksvfyqyvxcv2q3dyxdknssdfss0]]></nonce_str>
//<openid><![CDATA[oRRXY04bdFf0qUQftq6OXK490DIQ]]></openid>
//<out_trade_no><![CDATA[20170927000032-1506477962]]></out_trade_no>
//<result_code><![CDATA[SUCCESS]]></result_code>
//<return_code><![CDATA[SUCCESS]]></return_code>
//<sign><![CDATA[BBEF64EE0708970C918F8A23FEB673F4]]></sign>
//<time_end><![CDATA[20170927100608]]></time_end>
//<total_fee>1</total_fee>
//<trade_type><![CDATA[JSAPI]]></trade_type>
//<transaction_id><![CDATA[4200000021201709274506541224]]></transaction_id>
//</xml>';
 if(empty($data))
     {
         return;
 }

 $url = 'http://lsx.earthwa.com/respond/back-weixin';
  $curl = curl_init();
 curl_setopt($curl, CURLOPT_URL, $url);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
 curl_setopt($curl,CURLOPT_SSLVERSION,CURL_SSLVERSION_TLSv1);
 curl_setopt($curl, CURLOPT_POST, 1);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 $output = curl_exec($curl);
$error = curl_errno($curl);
 curl_close($curl);
//var_dump($output);
return '<xml>
  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>';
//var_dump($output);

 ?>