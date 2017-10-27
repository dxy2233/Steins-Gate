<?php
//checksum
namespace service\payment\weixin;

class SDKRuntimeException extends \common\base\Exception
{
	public function errorMessage()
	{
		return $this->getMessage();
	}
}

?>
