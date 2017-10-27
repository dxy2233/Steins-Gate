<?php
//checksum
namespace service\payment;

class CashierPayResult extends PayResult
{
	public function getResultUrl()
	{
		return mhomeurl();
	}

	public function render($is_success, $params = array())
	{
		$url = $this->getResultUrl();
		return \Yii::$app->response->redirect($url);
	}
}

?>
