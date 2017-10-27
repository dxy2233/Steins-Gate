<?php
//checksum
namespace service\payment\weixin;

class WeixinPay extends WxPayPubHelper implements \service\payment\IPay
{
	public $notify_url = '123.php';
	public $jsapi = 'JSAPI';
	public $native = 'NATIVE';

	public function __construct()
	{
//		var_dump(1);die;
		define('WEIXIN_APP_ID','wxb6548c05943dc4a3');
		define('WEIXIN_APPSECRET', '424d140e70e7b4288e7d8af696c524dd');
		define('WEIXIN_MCH_ID','1489372972');
		define('WEIXIN_KEY','0y5hvo6MmayoU9JeGJOuDVitJXVT8dUv' );
		define('WEIXIN_APICLIENT_CERT', '/service/payment/weixin/apiclient_cert.pem');
		define('WEIXIN_APICLIENT_KEY','/service/payment/weixin/apiclient_key.pem');
	}

	public function goPay($params = array())
	{
		extract($params);

		return $this->jsapiPay($out_trade_no, $body, $total_fee ,$attach);
	}

	public function jsapiPay($out_trade_no, $body, $total_fee ,$attach)
	{
		$selfUrl = \Yii::$app->request->getHostInfo() . \Yii::$app->request->url;
		$jsApi = new JsApi_pub();
		$session = \Yii::$app->getSession();
		$openid = $session->get('openid');

		if (empty($openid)) {
			if (!\Yii::$app->request->get('code')) {
				$url = $jsApi->createOauthUrlForCode($selfUrl);
				header('Location:' . $url);
				exit();
			}
			else {
				$code = \Yii::$app->request->get('code');
				$jsApi->setCode($code);
				$openid = $jsApi->getOpenId();
			}
		}

		$unifiedOrder = new UnifiedOrder_pub();
		$unifiedOrder->setParameter(array('openid' => $openid, 'out_trade_no' => $out_trade_no . '-' . time(), 'body' => $body, 'total_fee' => $total_fee * 100, 'notify_url' => 'http://lsx.earthwa.com/123.php', 'trade_type' => $this->jsapi ,'attach' => $attach));
		$prepay_id = $unifiedOrder->getPrepayId();
		$jsApi->setPrepayId($prepay_id);
		return $jsApi->getParameters();
	}

	public function nativePay($out_trade_no, $body, $total_fee)
	{
		$unifiedOrder = new UnifiedOrder_pub();
		$unifiedOrder->setParameter(array('out_trade_no' => $out_trade_no . '-' . time(), 'body' => $body, 'total_fee' => $total_fee * 100, 'notify_url' => homeurl($this->notify_url), 'trade_type' => $this->native));
		$unifiedOrderResult = $unifiedOrder->getResult();

		if ($unifiedOrderResult['return_code'] == 'FAIL') {
			return '通信出错：' . $unifiedOrderResult['return_msg'];
		}

		if ($unifiedOrderResult['result_code'] == 'FAIL') {
			return '错误代码描述：' . $unifiedOrderResult['err_code_des'];
		}

		$product_url = $unifiedOrderResult['code_url'];
		return '<img src=\'http://qr.liantu.com/api.php?text=' . $product_url . '\' alt=\'扫码支付\'>';
	}

	public function goRefund($params = array())
	{
		extract($params);
		$refund = new Refund_pub();
		$refund->setParameter(array('transaction_id' => $transaction_id, 'out_refund_no' => $out_refund_no, 'total_fee' => $total_fee, 'refund_fee' => $refund_fee, 'op_user_id' => WEIXIN_MCH_ID));
		$refundResult = $refund->getResult();

        file_put_contents('/tmp/weixin.log',json_encode($refundResult),FILE_APPEND);
		if ($refundResult['return_code'] == 'FAIL')
		{
			return false;
		}else if($refundResult['result_code'] == 'FAIL')
		{
			return false;
		}else if(isset($refundResult['err_code']))
		{
			if($refundResult['err_code'] != '')
			{
				return false;
			}
		}

		return true;
	}

	public function respond($xml)
	{
//		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
//		$xml = file_get_contents('php://input');
//		return $xml;
		$notify = new Notify_pub();
		$notify->saveData($xml);
		$respond = new \frontend\models\PaymentDo();
//		return $notify->checkSign();
		if ($notify->checkSign() == TRUE) {
//			return 712389472198;
			$out_trade_no = explode('-', $notify->data['out_trade_no']);
            $respond->params['record_sn'] = $out_trade_no[0];
            $respond->params['total_fee'] = $notify->data['total_fee'] / 100;
            $respond->params['pay_serianlno'] = $notify->data['transaction_id'];
            $respond->params['attach'] = $notify->data['attach'];
			$result_code = $notify->data['result_code'];
			$return_code = $notify->data['return_code'];
            $respond->params['success'] = (strtolower($result_code) == 'success') && (strtolower($return_code) == 'success') ? 1 : 0;
//            $respond->params['record_sn'] = 20170926123465;
//            $respond->params['total_fee'] = 0.01;
//            $respond->params['pay_serianlno'] = '21541654864165489456';
//            $respond->params['success'] = 1;
//            $respond->params['attach'] ='{"order_id":"1","banquet_id":"1","price":"12","number":"2","surplus":"10","user_id":1}';
//			return json_encode($respond->params);
			return $respond->payment();

		}
	}
}

?>
