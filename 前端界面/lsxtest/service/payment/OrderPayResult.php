<?php
//checksum
namespace service\payment;

class OrderPayResult extends PayResult
{
	public $order;

	private function getOrder()
	{
		if ($this->order == null) {
			$this->order = \common\models\Order::find()->where(array(
	'or',
	array('order_sn' => $this->order_sn),
	array('parent_sn' => $this->order_sn)
	))->one();
		}

		return $this->order;
	}

	public function getResultUrl()
	{
		$order = $this->getOrder();
		if (empty($order) || empty($order->order_id)) {
			return '/checkout/result.html';
		}

		if (($order->order_type == OT_FIGHT_GROUP) && is_frontend_mobile_app()) {
			$order_data = unserialize($order->order_data);
			return '/activity/groupon/join.html?group_sn=' . $order_data['group_sn'];
		}

		return '/checkout/result.html?order_sn=' . $this->order_sn;
	}

	public function render($is_success, $params = array())
	{
		$order = $this->getOrder();
		if (($order->order_type == OT_FIGHT_GROUP) && is_frontend_mobile_app()) {
			$controller = \Yii::$app->createController('/activity/groupon');

			if ($controller instanceof \app\modules\activity\controllers\GrouponController) {
				$order_data = unserialize($order->order_data);
				return $controller->actionJoin($order_data['group_sn']);
			}
		}
		else {
			$value = \Yii::$app->createController('/checkout/result');

			if (!empty($value)) {
				$controller = $value[0];

				if ($controller instanceof \app\modules\checkout\controllers\CheckoutController) {
					if (empty($order)) {
						return $controller->renderResult(null, false);
					}

					return $controller->renderResult($this->order_sn, $is_success);
				}
			}
		}

		return false;
	}

	public function getObjectId()
	{
		$order = $this->getOrder();
		return $order->order_id;
	}
}

?>
