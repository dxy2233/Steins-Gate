<?php
//checksum
namespace service\payment\weixin;

class AppWeixinPay extends WxPayPubHelper implements \service\payment\IPay
{
	public $notify_url = 'respond/back-app-weixin';
	public $app = 'APP';

	public function __construct()
	{
		$query = new \yii\db\Query();
		$query->select('pay_config')->from(\common\models\Payment::tableName());
		$query->andWhere(array('pay_code' => 'app_weixin'));
		$pay = $query->one();
		$pay_config = \common\helpers\Format::unserialize_config($pay['pay_config']);
		define(WEIXIN_APP_ID, $pay_config['appid']);
		define(WEIXIN_APPSECRET, $pay_config['appsecret']);
		define(WEIXIN_MCH_ID, $pay_config['mchid']);
		define(WEIXIN_KEY, $pay_config['key']);
		define(WEIXIN_APICLIENT_CERT, $pay_config['apiclient_cert']);
		define(WEIXIN_APICLIENT_KEY, $pay_config['apiclient_key']);
	}

	public function goPay($params = array())
	{
		extract($params);
		return $this->appPay($out_trade_no, $body, $total_fee);
	}

	public function appPay($out_trade_no, $body, $total_fee)
	{
		$unifiedOrder = new UnifiedOrder_pub();
		$unifiedOrder->setParameter(array('out_trade_no' => $out_trade_no . '-' . gmtime(), 'body' => $body, 'total_fee' => $total_fee * 100, 'notify_url' => homeurl($this->notify_url), 'trade_type' => $this->app));
		$prepay_id = $unifiedOrder->getPrepayId();
		$wxpay = new WxPayPubHelper();
		$data = array('appid' => WEIXIN_APP_ID, 'partnerid' => WEIXIN_MCH_ID, 'prepayid' => $prepay_id, 'noncestr' => $wxpay->createNoncestr(), 'timestamp' => gmtime(), 'package' => 'Sign=WXPay');
		$data['sign'] = $wxpay->getSign($data);
		return $data;
	}

	public function goRefund($params = array())
	{
		extract($params);
		$refund = new Refund_pub();
		$refund->setParameter(array('transaction_id' => $transaction_id, 'out_refund_no' => $out_refund_no, 'total_fee' => $total_fee, 'refund_fee' => $refund_fee, 'op_user_id' => WEIXIN_MCH_ID));
		$refundResult = $refund->getResult();

		if ($refundResult['return_code'] == 'FAIL') {
			return false;
		}

		return true;
	}

	public function respond()
	{
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$notify = new Notify_pub();
		$notify->saveData($xml);
		$respond = new \frontend\models\Respond();

		if ($notify->checkSign() == TRUE) {
			$out_trade_no = explode('-', $notify->data['out_trade_no']);
			$respond->params['order_sn'] = $out_trade_no[0];
			$respond->params['money'] = $notify->data['total_fee'] / 100;
			$respond->params['bank_sn'] = $notify->data['transaction_id'];
			$result_code = $notify->data['result_code'];
			$return_code = $notify->data['return_code'];
			$respond->params['action_state'] = (strtolower($result_code) == 'success') && (strtolower($return_code) == 'success') ? 1 : 0;
			return $respond->FrontAction();
		}
	}
}

?>
