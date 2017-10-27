<?php
//checksum
namespace service\payment\weixin;

use yii\db\Exception;

class WxPayPubHelper
{
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class Wxpay_client_pub extends WxPayPubHelper
{
	public $parameters;
	public $response;
	public $result;
	public $url;
	public $curl_timeout;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function setParameter($param)
	{
		$this->parameters = $param;
	}

	public function createXml()
	{
		$this->parameters['appid'] = $this->app_id;
		$this->parameters['mch_id'] = $this->mch_id;
		$this->parameters['nonce_str'] = $this->createNoncestr();
		$this->parameters['sign'] = $this->getSign($this->parameters);
		return $this->arrayToXml($this->parameters);
	}

	public function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function postXmlSSL()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlSSLCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function getResult()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class UnifiedOrder_pub extends Wxpay_client_pub
{
	public $parameters;
	public $response;
	public $result;
	public $url;
	public $curl_timeout;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function __construct()
	{
		$this->url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$this->curl_timeout = 10;
	}

	public function createXml()
	{
		try {
			if ($this->parameters['out_trade_no'] == null) {
				throw new Exception('缺少统一支付接口必填参数out_trade_no！' . '<br>');
			}
			else if ($this->parameters['body'] == null) {
				throw new Exception('缺少统一支付接口必填参数body！' . '<br>');
			}
			else if ($this->parameters['total_fee'] == null) {
				throw new Exception('缺少统一支付接口必填参数total_fee！' . '<br>');
			}
			else if ($this->parameters['notify_url'] == null) {
				throw new Exception('缺少统一支付接口必填参数notify_url！' . '<br>');
			}
			else if ($this->parameters['trade_type'] == null) {
				throw new Exception('缺少统一支付接口必填参数trade_type！' . '<br>');
			}
			else {
				if (($this->parameters['trade_type'] == 'JSAPI') && ($this->parameters['openid'] == NULL)) {
					throw new Exception('统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！' . '<br>');
				}
			}

			$this->parameters['appid'] = $this->app_id;
			$this->parameters['mch_id'] = $this->mch_id;
			$this->parameters['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
			$this->parameters['nonce_str'] = $this->createNoncestr();
			$this->parameters['sign'] = $this->getSign($this->parameters);
			return $this->arrayToXml($this->parameters);
		}
		catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	public function getPrepayId()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
		$prepay_id = $this->result['prepay_id'];
		return $prepay_id;
	}

	public function setParameter($param)
	{
		$this->parameters = $param;
	}

	public function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function postXmlSSL()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlSSLCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function getResult()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';

		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class OrderQuery_pub extends Wxpay_client_pub
{
	public $parameters;
	public $response;
	public $result;
	public $url;
	public $curl_timeout;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function __construct()
	{
		$this->url = 'https://api.mch.weixin.qq.com/pay/orderquery';
		$this->curl_timeout = 10;
	}

	public function createXml()
	{
		try {
			if (($this->parameters['out_trade_no'] == null) && ($this->parameters['transaction_id'] == null)) {
				throw new SDKRuntimeException('订单查询接口中，out_trade_no、transaction_id至少填一个！' . '<br>');
			}

			$this->parameters['appid'] = $this->app_id;
			$this->parameters['mch_id'] = $this->mch_id;
			$this->parameters['nonce_str'] = $this->createNoncestr();
			$this->parameters['sign'] = $this->getSign($this->parameters);
			return $this->arrayToXml($this->parameters);
		}
		catch (SDKRuntimeException $e) {
			exit($e->errorMessage());
		}
	}

	public function setParameter($param)
	{
		$this->parameters = $param;
	}

	public function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function postXmlSSL()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlSSLCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function getResult()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class Refund_pub extends Wxpay_client_pub
{
	public $parameters;
	public $response;
	public $result;
	public $url;
	public $curl_timeout;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function __construct()
	{
		$this->url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
		$this->curl_timeout = 10;
	}

	public function createXml()
	{
		try {
			if (($this->parameters['out_trade_no'] == null) && ($this->parameters['transaction_id'] == null)) {
				throw new Exception('退款申请接口中，out_trade_no、transaction_id至少填一个！' . '<br>');
			}
			else if ($this->parameters['out_refund_no'] == null) {
				throw new Exception('退款申请接口中，缺少必填参数out_refund_no！' . '<br>');
			}
			else if ($this->parameters['total_fee'] == null) {
				throw new Exception('退款申请接口中，缺少必填参数total_fee！' . '<br>');
			}
			else if ($this->parameters['refund_fee'] == null) {
				throw new Exception('退款申请接口中，缺少必填参数refund_fee！' . '<br>');
			}
			else {
				if ($this->parameters['op_user_id'] == null) {
					throw new Exception('退款申请接口中，缺少必填参数op_user_id！' . '<br>');
				}
			}

			$this->parameters['appid'] = $this->app_id;
			$this->parameters['mch_id'] = $this->mch_id;
			$this->parameters['nonce_str'] = $this->createNoncestr();
			$this->parameters['sign'] = $this->getSign($this->parameters);
			return $this->arrayToXml($this->parameters);
		}
		catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	public function getResult()
	{
		$this->postXmlSSL();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}

	public function setParameter($param)
	{
		$this->parameters = $param;
	}

	public function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function postXmlSSL()
	{
		$xml = $this->createXml();
//        file_put_contents('/tmp/weixin.log',json_encode($xml),FILE_APPEND);
//        file_put_contents('/tmp/weixin.log',$this->url,FILE_APPEND);
		$this->response = $this->postXmlSSLCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, '/www/web/earthwa_shop/lsxtest' . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, '/www/web/earthwa_shop/lsxtest' . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
//        file_put_contents('/tmp/weixin.log',ROOT_PATH . WEIXIN_APICLIENT_CERT,FILE_APPEND);
        file_put_contents('/tmp/weixin.log',$error,FILE_APPEND);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class RefundQuery_pub extends Wxpay_client_pub
{
	public $parameters;
	public $response;
	public $result;
	public $url;
	public $curl_timeout;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function __construct()
	{
		$this->url = 'https://api.mch.weixin.qq.com/pay/refundquery';
		$this->curl_timeout = 10;
	}

	public function createXml()
	{
		try {
			if (($this->parameters['out_refund_no'] == null) && ($this->parameters['out_trade_no'] == null) && ($this->parameters['transaction_id'] == null) && ($this->parameters['refund_id '] == null)) {
				throw new Exception('退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！' . '<br>');
			}

			$this->parameters['appid'] = $this->app_id;
			$this->parameters['mch_id'] = $this->mch_id;
			$this->parameters['nonce_str'] = $this->createNoncestr();
			$this->parameters['sign'] = $this->getSign($this->parameters);
			return $this->arrayToXml($this->parameters);
		}
		catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	public function getResult()
	{
		$this->postXmlSSL();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}

	public function setParameter($param)
	{
		$this->parameters = $param;
	}

	public function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function postXmlSSL()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlSSLCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class DownloadBill_pub extends Wxpay_client_pub
{
	public $parameters;
	public $response;
	public $result;
	public $url;
	public $curl_timeout;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function __construct()
	{
		$this->url = 'https://api.mch.weixin.qq.com/pay/downloadbill';
		$this->curl_timeout = 10;
	}

	public function createXml()
	{
		try {
			if ($this->parameters['bill_date'] == null) {
				throw new Exception('对账单接口中，缺少必填参数bill_date！' . '<br>');
			}

			$this->parameters['appid'] = $this->app_id;
			$this->parameters['mch_id'] = $this->mch_id;
			$this->parameters['nonce_str'] = $this->createNoncestr();
			$this->parameters['sign'] = $this->getSign($this->parameters);
			return $this->arrayToXml($this->parameters);
		}
		catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	public function getResult()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->result_xml);
		return $this->result;
	}

	public function setParameter($param)
	{
		$this->parameters = $param;
	}

	public function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function postXmlSSL()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlSSLCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class ShortUrl_pub extends Wxpay_client_pub
{
	public $parameters;
	public $response;
	public $result;
	public $url;
	public $curl_timeout;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function __construct()
	{
		$this->url = 'https://api.mch.weixin.qq.com/tools/shorturl';
		$this->curl_timeout = 10;
	}

	public function createXml()
	{
		try {
			if ($this->parameters['long_url'] == null) {
				throw new Exception('短链接转换接口中，缺少必填参数long_url！' . '<br>');
			}

			$this->parameters['appid'] = $this->app_id;
			$this->parameters['mch_id'] = $this->mch_id;
			$this->parameters['nonce_str'] = $this->createNoncestr();
			$this->parameters['sign'] = $this->getSign($this->parameters);
			return $this->arrayToXml($this->parameters);
		}
		catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	public function getShortUrl()
	{
		$this->postXml();
		$prepay_id = $this->result['short_url'];
		return $prepay_id;
	}

	public function setParameter($param)
	{
		$this->parameters = $param;
	}

	public function postXml()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function postXmlSSL()
	{
		$xml = $this->createXml();
		$this->response = $this->postXmlSSLCurl($xml, $this->url, $this->curl_timeout);
		return $this->response;
	}

	public function getResult()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
		return $this->result;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class Wxpay_server_pub extends WxPayPubHelper
{
	public $data;
	public $returnParameters;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function saveData($xml)
	{
		$this->data = $this->xmlToArray($xml);
	}

	public function checkSign()
	{
		$tmpData = $this->data;
		unset($tmpData['sign']);
		$sign = $this->getSign($tmpData);

		if ($this->data['sign'] == $sign) {
			return TRUE;
		}

		return FALSE;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setReturnParameter($parameter, $parameterValue)
	{
		$this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}

	public function createXml()
	{
		return $this->arrayToXml($this->returnParameters);
	}

	public function returnXml()
	{
		$returnXml = $this->createXml();
		return $returnXml;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class Notify_pub extends Wxpay_server_pub
{
	public $data;
	public $returnParameters;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function saveData($xml)
	{
		$this->data = $this->xmlToArray($xml);
	}

	public function checkSign()
	{
		$tmpData = $this->data;
		unset($tmpData['sign']);
		$sign = $this->getSign($tmpData);

		if ($this->data['sign'] == $sign) {
			return TRUE;
		}

		return FALSE;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setReturnParameter($parameter, $parameterValue)
	{
		$this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}

	public function createXml()
	{
		return $this->arrayToXml($this->returnParameters);
	}

	public function returnXml()
	{
		$returnXml = $this->createXml();
		return $returnXml;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class NativeCall_pub extends Wxpay_server_pub
{
	public $data;
	public $returnParameters;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function createXml()
	{
		if ($this->returnParameters['return_code'] == 'SUCCESS') {
			$this->returnParameters['appid'] = $this->app_id;
			$this->returnParameters['mch_id'] = $this->mch_id;
			$this->returnParameters['nonce_str'] = $this->createNoncestr();
			$this->returnParameters['sign'] = $this->getSign($this->returnParameters);
		}

		return $this->arrayToXml($this->returnParameters);
	}

	public function getProductId()
	{
		$product_id = $this->data['product_id'];
		return $product_id;
	}

	public function saveData($xml)
	{
		$this->data = $this->xmlToArray($xml);
	}

	public function checkSign()
	{
		$tmpData = $this->data;
		unset($tmpData['sign']);
		$sign = $this->getSign($tmpData);

		if ($this->data['sign'] == $sign) {
			return TRUE;
		}

		return FALSE;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setReturnParameter($parameter, $parameterValue)
	{
		$this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}

	public function returnXml()
	{
		$returnXml = $this->createXml();
		return $returnXml;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class NativeLink_pub extends WxPayPubHelper
{
	public $parameters;
	public $url;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function __construct()
	{
	}

	public function setParameter($parameter, $parameterValue)
	{
		$this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}

	public function createLink()
	{
		try {
			if ($this->parameters['product_id'] == null) {
				throw new Exception('缺少Native支付二维码链接必填参数product_id！' . '<br>');
			}

			$this->parameters['appid'] = $this->app_id;
			$this->parameters['mch_id'] = $this->mch_id;
			$this->parameters['time_stamp'] = gmtime();
			$this->parameters['nonce_str'] = $this->createNoncestr();
			$this->parameters['sign'] = $this->getSign($this->parameters);
			$bizString = $this->formatBizQueryParaMap($this->parameters, false);
			$this->url = 'weixin://wxpay/bizpayurl?' . $bizString;
		}
		catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	public function getUrl()
	{
		$this->createLink();
		return $this->url;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}

class JsApi_pub extends WxPayPubHelper
{
	public $code;
	public $openid;
	public $parameters;
	public $prepay_id;
	public $curl_timeout;
	public $app_id = WEIXIN_APP_ID;
	public $appsecret = WEIXIN_APPSECRET;
	public $mch_id = WEIXIN_MCH_ID;
	public $key = WEIXIN_KEY;

	public function __construct()
	{
		$this->curl_timeout = 10;
	}

	public function createOauthUrlForCode($redirectUrl)
	{
		$urlObj['appid'] = $this->app_id;
		$urlObj['redirect_uri'] = $redirectUrl;
		$urlObj['response_type'] = 'code';
		$urlObj['scope'] = 'snsapi_base';
		$urlObj['state'] = 'STATE' . '#wechat_redirect';
		$bizString = $this->formatBizQueryParaMap($urlObj, false);
		return 'https://open.weixin.qq.com/connect/oauth2/authorize?' . $bizString;
	}

	public function createOauthUrlForOpenid()
	{
		$urlObj['appid'] = $this->app_id;
		$urlObj['secret'] = $this->appsecret;
		$urlObj['code'] = $this->code;
		$urlObj['grant_type'] = 'authorization_code';
		$bizString = $this->formatBizQueryParaMap($urlObj, false);
		return 'https://api.weixin.qq.com/sns/oauth2/access_token?' . $bizString;
	}

	public function getOpenid()
	{
		$url = $this->createOauthUrlForOpenid();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$res = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($res, true);
		$this->openid = $data['openid'];
		return $this->openid;
	}

	public function setPrepayId($prepayId)
	{
		$this->prepay_id = $prepayId;
	}

	public function setCode($code_)
	{
		$this->code = $code_;
	}

	public function getParameters()
	{
		$jsApiObj['appId'] = $this->app_id;
		$jsApiObj['timeStamp'] = '\'' . time() . '\'';
		$jsApiObj['nonceStr'] = $this->createNoncestr();
		$jsApiObj['package'] = 'prepay_id=' . $this->prepay_id;
		$jsApiObj['signType'] = 'MD5';
		$jsApiObj['paySign'] = $this->getSign($jsApiObj);
		$this->parameters = json_encode($jsApiObj);
		return $this->parameters;
	}

	public function trimString($value)
	{
		$ret = null;

		if (null != $value) {
			$ret = $value;

			if (strlen($ret) == 0) {
				$ret = null;
			}
		}

		return $ret;
	}

	public function createNoncestr($length = 32)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		return $str;
	}

	public function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = '';
		ksort($paraMap);

		foreach ($paraMap as $k => $v) {
			if ($urlencode) {
				$v = urlencode($v);
			}

			$buff .= $k . '=' . $v . '&';
		}

		if (0 < strlen($buff)) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}

		return $reqPar;
	}

	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}

		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String . '&key=' . $this->key;
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}

	public function arrayToXml($arr)
	{
		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function xmlToArray($xml)
	{
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}

	public function postXmlCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function postXmlSSLCurl($xml, $url, $second = 30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . WEIXIN_APICLIENT_CERT);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . WEIXIN_APICLIENT_KEY);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}

		$error = curl_errno($ch);
		echo 'curl出错，错误码:' . $error . '<br>';
		echo '<a href=\'http://curl.haxx.se/libcurl/c/libcurl-errors.html\'>错误原因查询</a></br>';
		curl_close($ch);
		return false;
	}

	public function printErr($wording = '', $err = '')
	{
		print_r('<pre>');
		echo $wording . '</br>';
		var_dump($err);
		print_r('</pre>');
	}
}


?>
