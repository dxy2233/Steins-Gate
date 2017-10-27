<?php
//checksum
namespace service\payment;

class PayResult extends \yii\base\Object
{
	public $order_sn;
	public $pay_log;
	public $pay_type;

	static public function getInstance($order_sn, $pay_type = NULL)
	{
		if ($pay_type === null) {
			$pay_log = \common\models\PayLog::find()->orWhere(array('order_sn' => $order_sn))->orWhere(array('parent_sn' => $order_sn))->asArray()->one();
			$pay_type = $pay_log['pay_type'];
		}
		else {
			$pay_log = null;
		}

		$classes = static::getPayResults();

		if (!isset($classes[$pay_type])) {
			throw new \common\base\UserException('不支持的支付类型#' . $pay_type);
		}

		$class = $classes[$pay_type];
		return new $class(array('order_sn' => $order_sn, 'pay_type' => $pay_type, 'pay_log' => $pay_log));
	}

	static public function getPayResults()
	{
		return array(PT_ORDER_PAY => 'service\\payment\\OrderPayResult', PT_RECHARGE => 'service\\payment\\RechargePayResult', PT_CASHIER => 'service\\payment\\CashierPayResult',PT_RENEW => 'service\\payment\\RechargePayResult');
	}

	public function getPayLog()
	{
		if ($this->pay_log == null) {
			$this->pay_log = \common\models\PayLog::findOne(array('order_sn' => $order_sn));
		}

		return $this->pay_log;
	}

	public function getResultUrl()
	{
		return null;
	}

	public function render($is_success, $params = array())
	{
		return null;
	}

	public function getObjectId()
	{
		return null;
	}

	public function getPayCode()
	{
		return $this->getPayLog()->pay_code;
	}
}

?>
