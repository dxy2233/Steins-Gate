<?php
//checksum
namespace service\payment;

class RechargePayResult extends PayResult
{
	public function getResultUrl()
	{
		return '/user/recharge.html';
	}

	public function render($is_success, $params = array())
	{
		$value = \Yii::$app->createController('/user/recharge');

		if (!empty($value)) {
			$controller = $value[0];

			if ($controller instanceof \app\modules\user\controllers\RechargeController) {
				return $controller->actionList();
			}
		}

		return false;
	}
}

?>
